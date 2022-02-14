<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */


     public function beforeFilter(\Cake\Event\EventInterface $event)
     {
         parent::beforeFilter($event);
         $this->Authentication->allowUnauthenticated(['login']);
         $this->Authentication->addUnauthenticatedActions(['add', 'view']);
         $this->Authentication->addUnauthenticatedActions(['verification', 'view']);
     }




     public function login()
     {

        $this->viewBuilder()->setLayout('login');

         $result = $this->Authentication->getResult();
         $getVerified = $result->getData();
         $title = "Login";
         if ($result->isValid()) {
           if ($getVerified['verified'] == TRUE) {
             $target = $this->Authentication->getLoginRedirect() ?? '/posts';
             $_SESSION['user_id'] = $getVerified['id'];
             return $this->redirect($target)  ;
           } else {
             $this->Flash->error('Your account is not verified');
             $this->Authentication->logout();
             return $this->redirect(['controller' => 'Users', 'action' => 'login']);
           }
         }
         if ($this->request->is('post') && !$result->isValid()) {
             $this->Flash->error('Invalid username or password');
         }

         $this->set(compact('title'));

     }

     public function verification($token)
     {
       $this->viewBuilder()->setLayout('login');
       $userTable = TableRegistry::get('Users');
       $verify = $userTable->find('all')->where(['activation_token'=>$token])->first();
       if ($verify['verified'] == TRUE) {
         echo "This email verification is already expired";
         exit();
       }
       $verify->verified = TRUE;
       $userTable->save($verify);
     }

    public function index()
    {
        $this->viewBuilder()->setLayout('main');
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Comments', 'Likes', 'Notifications', 'Posts'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('login');
        $title = "Registration";
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
          $userTable = TableRegistry::get('Users');
          $hasher = new DefaultPasswordHasher();
          $full_name = $this->request->getData('full_name');
          $email = $this->request->getData('email');
          $password = $this->request->getData('password');
          $confirm_password = $this->request->getData('confirm_password');

          $activation_token = Security::hash(Security::randomBytes(32));
          $data = [
            'username'        => $this->request->getData('username'),
            'full_name'        => $this->request->getData('full_name'),
            'email'            => $this->request->getData('email'),
            'gender'           => $this->request->getData('gender'),
            'age'              => $this->request->getData('age'),
            'banner_path'      => "logo.png",
            'profile_path'     => "icon.png",
            'password'         => $password,
            'confirm_password' => $confirm_password,
            'verified'         => FALSE,
            'activation_token' => $activation_token,
          ];
          $user = $userTable->newEntity($data);
          if ($userTable->save($user)) {

            $this->Flash->success(__('Register successful, Please see email for verification.'));
            $mailer = new Mailer('default');
            $mailer->setFrom(['noreply@mail.com' => 'John Doe']);
            $mailer->setViewVars(['full_name'=> $full_name,'token' => $activation_token])
            ->setTo($email)
            ->setEmailFormat('html')
            ->setSubject('Verify New Account')
            ->viewBuilder()
                ->setTemplate('default')
                ->setLayout('default');
            $mailer->deliver();
            return $this->redirect(['action' => 'login']);

          } else {
            $this->Flash->error(__('Registration failed, please try again.'));
          }
        }
        $this->set(compact('user', 'title'));
    }

    public function profile($id = null)
    {

      $search = $this->Users->newEmptyEntity();
      $photo = $this->Users->newEmptyEntity();
      $this->viewBuilder()->setLayout('main');
      $userPost = TableRegistry::get('Posts');
      $userDetails = TableRegistry::get('Users');
      $follower = TableRegistry::get('Followers');
      $alluser = $userDetails->find('all')->toArray();
      $post = $userPost->newEmptyEntity();
      $allpost = $userPost->find('all')->toArray();
      $logged = $this->Authentication->getResult();
      $loggedID = $logged->getData();
      $noti = TableRegistry::get('Notifications');

      $detail = $this->Users->get($id, [
          'contain' => [],
        ])->toArray();

      $notification = $noti->find()
                    ->where(['user_id' => $loggedID['id']])
                    ->andWhere(['status'=>FALSE])
                    ->andWhere(['user_from !=' => $loggedID['id']])
                    ->count();

      $header = ["title"=>$detail['full_name'], "notification"=>$notification];

      $followers = $follower->find('all', ['withDeleted'])
                ->where(['following_user' => $id])
                ->toArray();

      $followersTbl = $follower->find('all');

      $users = $userPost->find()
        ->contain(['Likes', 'Comments'])
        ->order(['Posts.created' => 'DESC'])
        ->where(['Posts.user_id' => $id]);
      $user = $this->paginate($users, ['limit'=>'5']);
      $this->set(compact('header','photo','post','search','user', 'detail', 'alluser', 'allpost', 'followers', 'followersTbl'));
    }


    public function profilepic($id = null)
    {
      $user = $this->Users->get($id, [
          'contain' => [],
      ]);

      if ($this->request->is(['patch', 'post', 'put'])) {
          $image = $this->request->getData('update_profile');
          $fileName = $image->getClientFilename();
          $data = ["profile_path" => $fileName];
          $user = $this->Users->patchEntity($user, $data);

          $path = WWW_ROOT.'img'.DS."upload/".$fileName;
          $image->moveTo($path);

          if ($this->Users->save($user)) {
              $this->Flash->success(__('The profile has been updated.'));
              return $this->redirect($this->referer());
          }
          $this->Flash->error(__('The profile could not be saved. Please, try again.'));
          return $this->redirect($this->referer());
      }
    }

    public function banner($id = null)
    {
      $user = $this->Users->get($id, [
          'contain' => [],
      ]);

      if ($this->request->is(['patch', 'post', 'put'])) {
          $image = $this->request->getData('update_banner');
          $fileName = $image->getClientFilename();
          $data = ["banner_path" => $fileName];
          $user = $this->Users->patchEntity($user,$data);

          $path = WWW_ROOT.'img'.DS."upload/".$fileName;
          $image->moveTo($path);
          if ($this->Users->save($user)) {
              $this->Flash->success(__('The Banner has been saved.'));
              return $this->redirect($this->referer());
          }
          $this->Flash->error(__('The Banner could not be saved. Please, try again.'));
          return $this->redirect($this->referer());
      }
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('main');
        $noti = TableRegistry::get('Notifications');
        $userLoggedIn = $this->Authentication->getResult()->getData()->id;
        $search = $this->Users->newEmptyEntity();
        if ((int)$id != $userLoggedIn) {
              return $this->redirect(['action' => 'edit/'.$userLoggedIn]);
            }


        $notification = $noti->find()
                      ->where(['user_id' => $userLoggedIn])
                      ->andWhere(['status'=>FALSE])
                      ->andWhere(['user_from !=' => $userLoggedIn])
                      ->count();

        $header = ["title"=>"Edit Profile", "notification"=>$notification];

        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
          $password = $this->request->getData('password');
          if (empty($password)) {
            $data = [
              'full_name' => $this->request->getData('full_name'),
              'username' => $this->request->getData('username'),
              'age' => $this->request->getData('age'),
              'gender' => $this->request->getData('gender'),
            ];
          } else {
            $data = [
              'full_name' => $this->request->getData('full_name'),
              'username' => $this->request->getData('username'),
              'age' => $this->request->getData('age'),
              'gender' => $this->request->getData('gender'),
              'password' => $this->request->getData('password'),
              'confirm_password' => $this->request->getData('confirm_password'),
            ];
          }

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'edit/'.$user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user','header', 'search'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }


    public function search()
    {
      $this->viewBuilder()->setLayout('main');
      $search = $this->Users->newEmptyEntity();
      if ($this->request->is('ajax')) {
        $this->autoRender = false;
        $find = $this->request->getQuery('term');
        $results = $this->Users->find('all', array(
                                           'conditions' => array('Users.full_name LIKE ' => '%' . $find . '%'),
                                           'recursive'  => -1
                                           ));

         $resultArr = array();
             foreach($results as $result) {
                $resultArr[] = array('label' =>$result->full_name , 'value' => $result->full_name );
             }
        echo json_encode($resultArr);
        exit();
      }

      if ($this->request->is('get')) {

        $find = $this->request->getQuery('search');

        $results = $this->Users->find()
          ->contain(['Posts'])
          ->where(['Users.full_name LIKE' => '%' . $find . '%']);

        $result = $this->paginate($results, ['limit' => 5]);
      }

      $this->set(compact('search','result'));

    }


}
