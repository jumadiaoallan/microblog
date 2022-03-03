<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

/**
 * Comments Controller
 *
 * @method \App\Model\Entity\Comment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        return $this->redirect($this->referer());
    }

    /**
     * View method
     *
     * @param string|null $id Comment id.
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

        $comment = $this->Comments->newEmptyEntity();
        $now = FrozenTime::parse('Asia/Manila')->i18nFormat('yyyy-MM-dd HH:mm:ss');
        if ($this->request->is('ajax')) {
            $data = [
              'post_id' => $this->request->getData('post_id'),
              'user_id' => $this->request->getData('user_id'),
              'comment' => $this->request->getData('comment'),
              'created' => $now,
              'modified' => $now,
            ];

            $comment = $this->Comments->patchEntity($comment, $data);
            if ($this->Comments->save($comment)) {
              //notification
                $notification = TableRegistry::get('Notifications');
                $posts = TableRegistry::get('Posts');
                $userid = $posts->find()->where(['id' => $this->request->getData('post_id')])->first();
                $noti = $notification->newEmptyEntity();
                $data = [
                'user_id' => $userid->user_id,
                'user_from' => $this->request->getData('user_id'),
                'notification' => 'Comment on your post.' . $this->request->getData('post_id'),
                'status' => false,
                'created' => $now,
                'modified' => $now,
                ];
                $noti = $notification->newEntity($data);
                $notification->save($noti);
              //end notification

                echo 'success';
                exit;
            } else {
                echo 'failed';
                exit;
            }
        } else {
            $this->Flash->error(__('Something wrong. Please try again.'));

            return $this->redirect($this->referer());
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        try {
            $comment = $this->Comments->get($id, [
              'contain' => [],
            ]);
        } catch (\Exception $e) {
            $this->Flash->error(__('Something wrong. Please, try again.'));

            return $this->redirect($this->referer());
        }

        $userLoggedIn = $this->Authentication->getResult()->getData()->id;
        if ($comment->user_id != $userLoggedIn) {
            $this->Flash->error(__('Something wrong. Please, try again.'));

            return $this->redirect($this->referer());
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));

                return $this->redirect($this->referer());
            }

            return $this->redirect($this->referer());
        } else {
            $this->Flash->error(__('Something wrong. Please try again.'));

            return $this->redirect($this->referer());
        }
        $this->set(compact('comment'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $this->request->allowMethod(['post', 'delete', 'ajax']);
        } catch (\Exception $e) {
            $this->Flash->error(__('Something wrong. Please try again.'));

            return $this->redirect($this->referer());
        }

        $comment = $this->Comments->find()->where(['id' => $id])->first();

        if (empty($comment)) {
            $this->Flash->error(__('Something went wrong, please try again.'));
            echo json_encode(['massage' => 'null']);
            exit;
        }

        $userLoggedIn = $this->Authentication->getResult()->getData()->id;
        if ($comment->user_id != $userLoggedIn) {
            $this->Flash->error(__('Something wrong. Please, try again.'));
            echo json_encode(['massage' => 'not-user']);
            exit;
        }

        if ($this->Comments->delete($comment)) {
            $this->Flash->success(__('The comment has been deleted.'));
            echo json_encode(['massage' => 'success']);
            exit;
        } else {
            $this->Flash->error(__('Something went wrong, please try again.'));
            echo json_encode(['massage' => 'failed']);
            exit;
        }
        $this->Flash->error(__('Something went wrong, please try again.'));
        echo json_encode(['massage' => 'error']);
        exit;
    }
}
