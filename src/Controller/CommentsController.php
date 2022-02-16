<?php
declare(strict_types=1);

namespace App\Controller;
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
        $comments = $this->paginate($this->Comments);

        $this->set(compact('comments'));
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
        $comment = $this->Comments->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('comment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $comment = $this->Comments->newEmptyEntity();
        if ($this->request->is('ajax')) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {

              //notification
              $notification = TableRegistry::get("Notifications");
              $posts = TableRegistry::get("Posts");
              $userid = $posts->find()->where(['id'=>$this->request->getData("post_id")])->first();
              $noti = $notification->newEmptyEntity();
              $data = [
                "user_id" => $userid->user_id,
                "user_from" => $this->request->getData("user_id"),
                "notification" => "Comment on your post.".$this->request->getData("post_id"),
                "status" => false
              ];
              $noti = $notification->newEntity($data);
              $notification->save($noti);
              //end notification

                echo "success";
            } else {
              echo "failed";
            }
        }
        exit();
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
        $comment = $this->Comments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));
                return $this->redirect($this->referer());
            }
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
        $this->request->allowMethod(['post', 'delete', 'ajax']);
        $comment = $this->Comments->get($id);
        if ($this->Comments->delete($comment)) {
            $this->Flash->success(__('The comment has been deleted.'));
            echo json_encode(['massage'=>'success']);
            exit();
        } else {
            $this->Flash->error(__('Something went wrong, please try again.'));
          echo json_encode(['massage'=>'failed']);
          exit();;
        }
        $this->Flash->error(__('Something went wrong, please try again.'));
        echo json_encode(['massage'=>'error']);
        exit();;
    }
}
