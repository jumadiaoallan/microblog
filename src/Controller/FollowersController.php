<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Followers Controller
 *
 * @property \App\Model\Table\FollowersTable $Followers
 * @method \App\Model\Entity\Follower[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FollowersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = null)
    {

        $this->viewBuilder()->setLayout('main');
        $users = TableRegistry::get('Users');
        $noti = TableRegistry::get('Notifications');
        $user = $users->find('all');
        $search = $users->newEmptyEntity();
        $logged = $this->Authentication->getResult();
        $loggedID = $logged->getData();
        if ($_GET['type'] == 'following') {
            $followings = $this->Followers->find()
                        ->where(['Followers.follower_user' => $id]);
        } else {
            $followings = $this->Followers->find()
                        ->where(['Followers.following_user' => $id]);
        }
        $notification = $noti->find()
                      ->where(['user_id' => $loggedID['id']])
                      ->andWhere(['status' => false])
                      ->andWhere(['user_from !=' => $loggedID['id']])
                      ->count();
        $header = ['title' => ucwords($_GET['type']), 'notification' => $notification];

        $following = $this->paginate($followings, ['limit' => 10]);

        $this->set(compact('header', 'search', 'following', 'user'));
    }

    /**
     * View method
     *
     * @param string|null $id Follower id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $follower = $this->Followers->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('follower'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $checkDB = TableRegistry::get('Followers');
        $following = $this->request->getData('following_user');
        $follower = $this->request->getData('follower_user');
        $follow = $checkDB->find('all', ['withDeleted'])->where(['following_user' => $following])->andWhere(['follower_user' => $follower])->first();

        if (!empty($follow)) {
            $data = ['deleted' => null];
            $foll = $this->Followers->patchEntity($follow, $data);
            $this->Followers->save($foll);
          //notification
            $notification = TableRegistry::get('Notifications');
            $noti = $notification->newEmptyEntity();
            $data = [
            'user_id' => $this->request->getData('following_user'),
            'user_from' => $this->request->getData('follower_user'),
            'notification' => 'Followed you.',
            'status' => false,
            ];
            $noti = $notification->newEntity($data);
            $notification->save($noti);
          //end notification
            echo json_encode(['message' => 'success', 'data' => 'followed']);
            exit;
        }

        $follower = $this->Followers->newEmptyEntity();
        if ($this->request->is('ajax')) {
            $follower = $this->Followers->patchEntity($follower, $this->request->getData());
            if ($this->Followers->save($follower)) {
              //notification
                $notification = TableRegistry::get('Notifications');
                $noti = $notification->newEmptyEntity();
                $data = [
                'user_id' => $this->request->getData('following_user'),
                'user_from' => $this->request->getData('follower_user'),
                'notification' => 'Followed you.',
                'status' => false,
                ];
                $noti = $notification->newEntity($data);
                $notification->save($noti);
              //end notification
                echo json_encode(['message' => 'success', 'data' => 'followed']);
                exit;
            }
                echo json_encode(['message' => 'failed']);
                exit;
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Follower id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $follower = $this->Followers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $follower = $this->Followers->patchEntity($follower, $this->request->getData());
            if ($this->Followers->save($follower)) {
                $this->Flash->success(__('The follower has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The follower could not be saved. Please, try again.'));
        }
        $this->set(compact('follower'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Follower id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $follower = $this->Followers->get($id);

        if ($this->Followers->delete($follower)) {
            $this->Flash->success(__('The follower has been deleted.'));
            echo json_encode(['message' => 'success', 'data' => 'unfollowed']);
            exit;
        } else {
            $this->Flash->error(__('The follower could not be deleted. Please, try again.'));
            echo json_encode(['message' => 'failed', 'data' => 'unfollowed']);
            exit;
        }

        exit;
    }
}
