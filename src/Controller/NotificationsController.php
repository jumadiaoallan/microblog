<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
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
        $users = TableRegistry::get('Users');
        $posts = TableRegistry::get('Posts');
        $search = $users->newEmptyEntity();
        $user = $users->find()->toArray();
        $post = $posts->find()->toArray();
        $now = FrozenTime::parse('Asia/Manila')->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $usersLogedin = $this->Authentication->getResult();
        $logged = $usersLogedin->getData();
        if (!empty($logged)) {
            $id = $logged['id'];
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
            if ($save->status != true) {
                $getNoti = $this->Notifications->get($save->id, [
                'contain' => [],
                ]);
                $data = [
                  'status' => true,
                  'modified' => $now,
                ];
                $notiSave = $this->Notifications->patchEntity($getNoti, $data);
                $this->Notifications->save($notiSave);
            }
        }

        $notification = $this->paginate($notifications, ['limit' => 5]);
        $header = ['title' => 'Notifications', 'notification' => $noti_count->where(['status' => false])->count()];
        $this->set(compact('header', 'search', 'notifications', 'user', 'post'));
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
        return $this->redirect($this->referer());
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        return $this->redirect($this->referer());
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
        return $this->redirect($this->referer());
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
        return $this->redirect($this->referer());
    }
}
