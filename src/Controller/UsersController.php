<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
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
     }


     public function login()
     {

        $this->viewBuilder()->setLayout('login');

         $result = $this->Authentication->getResult();
         $getVerified = $result->getData();

         if ($result->isValid()) {
           if ($getVerified['verified'] == 1) {
             $target = $this->Authentication->getLoginRedirect() ?? '/users';
             return $this->redirect($target);
           } else {
             $this->Flash->error('Your account is not verified');
             $this->Authentication->logout();
             return $this->redirect(['controller' => 'Users', 'action' => 'login']);
           }
         }
         if ($this->request->is('post') && !$result->isValid()) {
             $this->Flash->error('Invalid username or password');
         }

     }

    public function index()
    {
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
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
          $userTable = TableRegistry::get('Users');
          $hasher = new DefaultPasswordHasher();
          $fullname = $this->request->getData('full_name');
          $email = $this->request->getData('email');
          $gender = $this->request->getData('gender');
          $age = $this->request->getData('age');
          $password = $this->request->getData('password');
          $activation_token = Security::hash(Security::randomBytes(32));
          $data = [
            'username'        => $this->request->getData('username'),
            'full_name'        => $this->request->getData('full_name'),
            'email'            => $this->request->getData('email'),
            'gender'           => $this->request->getData('gender'),
            'age'              => $this->request->getData('age'),
            'password'         => $password,
            'verified'         => FALSE,
            'activation_token' => $activation_token,
          ];
          $user = $userTable->newEntity($data);
          if ($userTable->save($user)) {

            $this->Flash->success(__('The user has been registered.'));
            return $this->redirect(['action' => 'login']);

          } else {
            $this->Flash->error(__('Registration failed, please try again.'));
          }
        }
        $this->set(compact('user'));
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
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
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

}
