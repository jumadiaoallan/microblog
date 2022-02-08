<?php
declare(strict_types=1);

namespace App\Controller;
use SoftDelete\Model\Table\SoftDeleteTrait;

/**
 * Likes Controller
 *
 * @method \App\Model\Entity\Like[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LikesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
     // use SoftDeleteTrait;
    public function index()
    {
        $likes = $this->paginate($this->Likes);

        $this->set(compact('likes'));
    }

    /**
     * View method
     *
     * @param string|null $id Like id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $like = $this->Likes->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('like'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      $id = $this->request->getData('value');
      $post_id = $this->request->getData('post_id');
      $user_id = $this->request->getData('user_id');

      $userLoggedIn = $this->Authentication->getResult()->getData()->id;

      if ($this->request->is('ajax')) {
        $like = $this->Likes->find()
          ->where(['id' => $id])->toArray();

        if (isset($like[0]['id'])) {
          $like = $this->Likes->get($id);
          if ($this->Likes->delete($like)) {
              echo json_encode(['status'=> 'UNLIKE', 'inserted_id'=> 0]);
              exit();
          }
        } else {

          $unliked = $this->Likes->find('all', ['withDeleted'])->where(['post_id' => $post_id])->first();

          if (isset($unliked)) {
            $data = ["deleted" => null];
            $like = $this->Likes->patchEntity($unliked, $data);
            $this->Likes->save($like);
            echo json_encode(['status'=> 'LIKE', 'inserted_id'=> 0]);
            exit();
          } else {
            $like = $this->Likes->newEmptyEntity();
            $data = [
              "user_id" => $user_id,
              "post_id" => $post_id,
            ];
            $like = $this->Likes->newEntity($data);
            if ($this->Likes->save($like)) {
              $id = $like->id;
              echo json_encode(['status'=> 'LIKE', 'inserted_id'=> $id]);
              exit();
            }
          }
        }
        exit();
      }
      exit();
    }

    /**
     * Edit method
     *
     * @param string|null $id Like id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $like = $this->Likes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $like = $this->Likes->patchEntity($like, $this->request->getData());
            if ($this->Likes->save($like)) {
                $this->Flash->success(__('The like has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The like could not be saved. Please, try again.'));
        }
        $this->set(compact('like'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Like id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $like = $this->Likes->get($id);
        if ($this->Likes->delete($like)) {
            $this->Flash->success(__('The like has been deleted.'));
        } else {
            $this->Flash->error(__('The like could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
