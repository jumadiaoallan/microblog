<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;

/**
 * Notifications Controller
 *
 * @property \App\Model\Table\NotificationsTable $Notifications
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationsController extends AppController
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

    public function index()
    {

        $this->viewBuilder()->setLayout('main');
        $users = TableRegistry::get("Users");
        $posts = TableRegistry::get("Posts");
        $search = $users->newEmptyEntity();
        $user = $users->find()->toArray();
        $post = $posts->find()->toArray();

        $usersLogedin = $this->Authentication->getResult();
        $logged = $usersLogedin->getData();
        if (!empty($logged)) {
          $id = $logged["id"];
        } else {
          $id = 0;
        }
        $notifications = $this->Notifications->find()
                     ->where(['user_id' => $id])
                     ->andWhere(['user_from !=' => $id])
                     ->order(['created' => 'DESC']);

         $noti_count = $this->Notifications->find()
                      ->where(['user_id' => $id])
                      ->andWhere(['user_from !=' => $id])
                      ->order(['created' => 'DESC']);

        foreach ($notifications as $save) {
          if ($save->status != TRUE) {
            $getNoti = $this->Notifications->get($save->id, [
                'contain' => [],
            ]);
            $data = ['status' => TRUE];
            $notiSave = $this->Notifications->patchEntity($getNoti, $data);
            $this->Notifications->save($notiSave);
          }
        }

        $notification = $this->paginate($notifications, ['limit' => 5]);
        $header = ["title"=>"Notifications", "notification"=>$noti_count->where(['status'=>FALSE])->count()];
        $this->set(compact('header','search','notifications', 'user', 'post'));
    }

    /**
     * View method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notification = $this->Notifications->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('notification'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notification = $this->Notifications->newEmptyEntity();
        if ($this->request->is('post')) {
            $notification = $this->Notifications->patchEntity($notification, $this->request->getData());
            if ($this->Notifications->save($notification)) {
                $this->Flash->success(__('The notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notification could not be saved. Please, try again.'));
        }
        $users = $this->Notifications->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('notification', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notification = $this->Notifications->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notification = $this->Notifications->patchEntity($notification, $this->request->getData());
            if ($this->Notifications->save($notification)) {
                $this->Flash->success(__('The notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notification could not be saved. Please, try again.'));
        }
        $users = $this->Notifications->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('notification', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notification = $this->Notifications->get($id);
        if ($this->Notifications->delete($notification)) {
            $this->Flash->success(__('The notification has been deleted.'));
        } else {
            $this->Flash->error(__('The notification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
