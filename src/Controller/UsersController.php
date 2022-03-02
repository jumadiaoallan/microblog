<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\FrozenTime;
use Cake\Mailer\Mailer;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;

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
        $this->Authentication->addUnauthenticatedActions(['users', 'resend']);
    }

    /**
     * Login method
     */
    public function login()
    {
         $this->viewBuilder()->setLayout('login');
         $user = $this->Users->newEmptyEntity();
         $result = $this->Authentication->getResult();
         $getVerified = $result->getData();
         $title = 'Login';
        if ($result->isValid()) {
            if ($getVerified['verified'] == true) {
                $target = $this->Authentication->getLoginRedirect() ?? '/posts';
                $_SESSION['user_id'] = $getVerified['id'];

                return $this->redirect($target);
            } else {
                $this->Flash->error('Your account is not verified');
                $this->Flash->error('Not Verified', [
                    'key' => 'not-verified',
                    'clear' => true,
                ]);
                $this->Authentication->logout();

                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid username or password');
        }

         $this->set(compact('title', 'user'));
    }

    /**
     * Login process
     */
    public function verification($token)
    {
        $this->viewBuilder()->setLayout('login');
        $userTable = TableRegistry::get('Users');
        $title = 'Verification';
        $verify = $userTable->find('all')->where(['activation_token' => $token])->first();

        if (empty($verify)) {
          echo "Invalid Varification Link";
          exit;
        }

        $tokens = $token;
        $token_generated = FrozenTime::parse($verify['generated_token'], new \DateTimeZone('Asia/Manila'));
        $expiry_token = $token_generated->addHours(1);
        $get_expiry_token = $expiry_token->format('Y-m-d H:i:s');
        $nowManila = FrozenTime::now('Asia/Manila');
        $now = FrozenTime::parse($nowManila, new \DateTimeZone('Asia/Manila'));
        $get_now_date = $now->format('Y-m-d H:i:s');

        if ($get_now_date >= $get_expiry_token) {
            echo "It's been 1 hour passed. This email verification is already expired";
            exit;
        } else {
            if ($verify['verified'] == true) {
                echo 'This email verification is already used';
                exit;
            }
            $verify->verified = true;
            $userTable->save($verify);
        }

        $this->set(compact('tokens', 'title'));
    }

    /**
     * Index
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('main');
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));

        return $this->redirect(['controller' => 'Posts', 'action' => 'index']);
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
        $title = 'Registration';
        $now = FrozenTime::parse('Asia/Manila')->i18nFormat('yyyy-MM-dd HH:mm:ss');
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
            'username' => $this->request->getData('username'),
            'full_name' => $full_name,
            'email' => $email,
            'gender' => $this->request->getData('gender'),
            'birthday' => $this->request->getData('birthday'),
            'banner_path' => 'logo.PNG',
            'profile_path' => 'icon.PNG',
            'password' => $password,
            'confirm_password' => $confirm_password,
            'verified' => false,
            'activation_token' => $activation_token,
            'generated_token' => $now,
            'created' => $now,
            'modified' => $now,
            ];
            $user = $userTable->newEntity($data);

            if ($userTable->save($user)) {
                $this->Flash->success(__('Register successful, Please see email for verification.'));

                $mailer = new Mailer('default');
                $mailer->setFrom(['allanjumadiao.yns@gmail.com' => 'John Doe']);
                $mailer->setViewVars(['full_name' => $full_name,'token' => $activation_token])
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

    /**
     * Profile Details
     */
    public function profile($id = null)
    {
        $this->viewBuilder()->setLayout('main');
        $search = $this->Users->newEmptyEntity();
        $photo = $this->Users->newEmptyEntity();
        $userPost = TableRegistry::get('Posts');
        $userDetails = TableRegistry::get('Users');
        $follower = TableRegistry::get('Followers');
        $alluser = $userDetails->find('all')->toArray();
        $post = $userPost->newEmptyEntity();
        $allpost = $userPost->find('all', ['withDeleted'])->toArray();
        $logged = $this->Authentication->getResult();
        $loggedID = $logged->getData();
        $noti = TableRegistry::get('Notifications');

        $detail = $this->Users->get($id, [
            'contain' => [],
          ])->toArray();

        $notification = $noti->find()
                      ->where(['user_id' => $loggedID['id']])
                      ->andWhere(['status' => false])
                      ->andWhere(['user_from !=' => $loggedID['id']])
                      ->count();

        $header = ['title' => $detail['full_name'], 'notification' => $notification];

        $followers = $follower->find('all', ['withDeleted'])
                  ->where(['following_user' => $id])
                  ->toArray();

        $followersTbl = $follower->find('all');

        $users = $userPost->find()
          ->contain(['Likes', 'Comments'])
          ->order(['Posts.created' => 'DESC'])
          ->where(['Posts.user_id' => $id]);

        $user = $this->paginate($users, ['limit' => '5']);

        $this->set(compact('header', 'photo', 'post', 'search', 'user', 'detail', 'alluser', 'allpost', 'followers', 'followersTbl'));
    }

    /**
     * Profile upload
     */
    public function profilepic($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        $now = FrozenTime::parse('Asia/Manila')->i18nFormat('yyyy-MM-dd HH:mm:ss');
        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($this->request->getData('update_profile')->getClientFilename() == '') {
                return $this->redirect($this->referer());
            }

              $image = $this->request->getData('update_profile');

              $imageSize = $image->getSize() * 0.000001;

            if ($imageSize >= 5) {
                $this->Flash->error('Image should only below 5MB.');

                return $this->redirect($this->referer());
            }

              $fileName = time() . '_' . $image->getClientFilename();
              $data = [
                'profile_path' => $fileName,
                'modified' => $now,
              ];
              $user = $this->Users->patchEntity($user, $data);

              $path = WWW_ROOT . 'img' . DS . 'upload/' . $fileName;
              $image->moveTo($path);

              if ($this->Users->save($user)) {
                  $this->Flash->success(__('The profile photo has been updated.'));

                  return $this->redirect($this->referer());
              }
              $this->Flash->error(__('The profile photo could not be saved. Please, try again.'));
              $this->Flash->error('Invalid Image Format', [
                  'key' => 'invalid-image',
                  'clear' => true,
              ]);

              return $this->redirect($this->referer());
        }
    }

    /**
     * Banner upload
     */
    public function banner($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        $now = FrozenTime::parse('Asia/Manila')->i18nFormat('yyyy-MM-dd HH:mm:ss');
        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($this->request->getData('update_banner')->getClientFilename() == '') {
                return $this->redirect($this->referer());
            }

            $image = $this->request->getData('update_banner');

            $imageSize = $image->getSize() * 0.000001;

            if ($imageSize >= 5) {
                $this->Flash->error('Image should only below 5MB.');

                return $this->redirect($this->referer());
            }

            $fileName = time() . '_' . $image->getClientFilename();
            $data = [
              'banner_path' => $fileName,
              'modified' => $now,
            ];
            $user = $this->Users->patchEntity($user, $data);

            $path = WWW_ROOT . 'img' . DS . 'upload/' . $fileName;
            $image->moveTo($path);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The banner photo has been saved.'));

                return $this->redirect($this->referer());
            }
              $this->Flash->error(__('The banner photo could not be saved. Please, try again.'));
              $this->Flash->error('Invalid Image Format', [
                  'key' => 'invalid-image',
                  'clear' => true,
              ]);

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
              return $this->redirect(['action' => 'edit/' . $userLoggedIn]);
        }
        $now = FrozenTime::parse('Asia/Manila')->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $notification = $noti->find()
                      ->where(['user_id' => $userLoggedIn])
                      ->andWhere(['status' => false])
                      ->andWhere(['user_from !=' => $userLoggedIn])
                      ->count();

        $header = ['title' => 'Edit Profile', 'notification' => $notification];

        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $password = $this->request->getData('password');
            if (empty($password)) {
                $data = [
                'full_name' => $this->request->getData('full_name'),
                'username' => $this->request->getData('username'),
                'birthday' => $this->request->getData('birthday'),
                'gender' => $this->request->getData('gender'),
                'modified' => $now,
                ];
            } else {
                $data = [
                'full_name' => $this->request->getData('full_name'),
                'username' => $this->request->getData('username'),
                'birthday' => $this->request->getData('birthday'),
                'gender' => $this->request->getData('gender'),
                'password' => $this->request->getData('password'),
                'confirm_password' => $this->request->getData('confirm_password'),
                'modified' => $now,
                ];
            }

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'edit/' . $user->id]);
            }
              $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user', 'header', 'search'));
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

    /**
     * Logout method
     */
    public function logout()
    {
        $this->Authentication->logout();

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * Search method
     */
    public function search()
    {
        $this->viewBuilder()->setLayout('main');
        $search = $this->Users->newEmptyEntity();
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $find = $this->request->getQuery('term');
            $results = $this->Users->find('all', [
                                             'conditions' => ['Users.full_name LIKE ' => '%' . $find . '%'],
                                             'recursive' => -1,
                                             ]);

            $resultArr = [];

            foreach ($results as $result) {
                $resultArr[] = ['label' => $result->full_name , 'value' => $result->full_name ];
            }

            echo json_encode($resultArr);
            exit;
        }

        if ($this->request->is('get')) {
            $find = $this->request->getQuery('search');
            if ($find == '') {
                return $this->redirect($this->referer());
            }
            $results = $this->Users->find()
            ->contain(['Posts'])
            ->where(['Users.full_name LIKE' => '%' . $find . '%']);

            $result = $this->paginate($results, ['limit' => 5]);
        }

        $logged = $this->Authentication->getResult();
        $loggedID = $logged->getData();
        $noti = TableRegistry::get('Notifications');
        $notification = $noti->find()
                    ->where(['user_id' => $loggedID['id']])
                    ->andWhere(['status' => false])
                    ->andWhere(['user_from !=' => $loggedID['id']])
                    ->count();

        $header = ['title' => 'Search Result', 'notification' => $notification];

        $this->set(compact('header', 'search', 'result'));
    }

    /**
     * Resend Validation Email
     */
    public function resend()
    {
        $this->viewBuilder()->setLayout('login');
        $title = 'Resend Email Verification';
        $find = $this->Users->newEmptyEntity();
        $new_token = Security::hash(Security::randomBytes(32));
        $new_date = FrozenTime::parse('Asia/Manila')->i18nFormat('yyyy-MM-dd HH:mm:ss');

        if ($this->request->is('post')) {
            $user_email = $this->request->getData('email');

            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
              $this->Flash->error('Invalid Format', [
              'key' => 'invalid-format',
              'clear' => true,
              ]);
              $_SESSION['email'] = $user_email;

              return $this->redirect($this->referer());
            }

            $find = $this->Users->find()
                ->where(['email' => $user_email])
                ->first();

            if (empty($find)) {
              $this->Flash->error(__('Email not found.'));
              $_SESSION['email'] = $user_email;

              return $this->redirect($this->referer());
            }

            if (empty($user_email)) {
                $this->Flash->error('Empty Email', [
                'key' => 'empty-email',
                'clear' => true,
                ]);

                $_SESSION['email'] = $user_email;

                return $this->redirect($this->referer());
            }

            if ($find->verified != true) {
                $data = [
                'activation_token' => $new_token,
                'generated_token' => $new_date,
                ];

                $save = $this->Users->patchEntity($find, $data);
                if ($this->Users->save($save)) {
                    $mailer = new Mailer('default');
                    $mailer->setFrom(['allanjumadiao.yns@gmail.com' => 'John Doe']);
                    $mailer->setViewVars(['full_name' => $find->full_name,'token' => $new_token])
                    ->setTo($user_email)
                    ->setEmailFormat('html')
                    ->setSubject('Resend Email Verification')
                    ->viewBuilder()
                    ->setTemplate('default')
                    ->setLayout('default');
                    $mailer->deliver();

                    $this->Flash->success(__('The email verification is successful resend, please check you email.'));

                    return $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error(__('Something went wrong, please try again'));

                    return $this->redirect($this->referer());
                }
            } else {
                $this->Flash->error(__("You're email input is already activated!"));
                $_SESSION['email'] = $user_email;

                return $this->redirect($this->referer());
            }
        }

        $this->set(compact('title', 'find'));
    }
}
