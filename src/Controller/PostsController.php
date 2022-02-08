<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;

/**
 * Posts Controller
 *
 * @method \App\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($page = null)
    {



        $this->viewBuilder()->setLayout('main');
        $userPost = TableRegistry::get('Posts');
        $userDetails = TableRegistry::get('Users');
        $alluser = $userDetails->find('all')->toArray();
        $allpost = $userPost->find('all')->toArray();
        $detail = $userDetails->find('all')->toArray();
        $users = $userPost->find()
          ->contain(['Comments','Likes'])
          ->order(['Posts.created' => 'DESC']);

        $user = $this->paginate($users, ['limit'=>'5']);

        $this->set(compact('user', 'detail', 'alluser', 'allpost'));
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if ($this->request->is('ajax')) {
          $userDetails = TableRegistry::get('Users');
          $post = $this->Posts->get($id, ['contain' => ['Likes', 'Comments'],]);
          $alluser = $userDetails->find('all')->toArray();
          echo json_encode(['post'=> $post, 'users'=> $alluser]);
          exit();
        } else {
          $this->viewBuilder()->setLayout('main');
          $userDetails = TableRegistry::get('Users');
          $userPost = TableRegistry::get('Posts');
          $allpost = $userPost->find('all')->toArray();
          $post = $this->Posts->get($id, ['contain' => ['Likes', 'Comments'],]);
          $alluser = $userDetails->find('all')->toArray();
          $this->set(compact('post', 'alluser', 'allpost'));
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      $posts = $this->Posts->newEmptyEntity();

      if ($this->request->is('post')) {
        $postTable = TableRegistry::get('Posts');
        $image = $this->request->getData('image_post');
        if (!empty($image->getClientFilename())) {
          $image = $this->request->getData('image_post');
          $fileName = $image->getClientFilename();
          $path = WWW_ROOT.'img'.DS."post_upload/".$fileName;
          $image->moveTo($path);
        } else {
          $fileName = null;
        }
        $data = [
          'user_id'        => $_SESSION['user_id'],
          'image_path'     => $fileName,
          'post'           => $this->request->getData('post'),
        ];
        $posts = $postTable->newEntity($data);
        if ($this->Posts->save($posts)) {
          $this->Flash->success(__('Successfully Posted!'));
          $this->redirect($this->referer());
        } else {
          $this->Flash->error(__('Something wrong. Please, try again.'));
          $this->redirect($this->referer());
        }
      }
      $this->set(compact('posts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
          $image = $this->request->getData('image_post');

          if (!empty($image->getClientFilename())) {
            $image = $this->request->getData('image_post');
            $fileName = $image->getClientFilename();
            $path = WWW_ROOT.'img'.DS."post_upload/".$fileName;
            $image->moveTo($path);
          } else {
            $fileName = null;
          }

          $data = [
            'image_path'      => $fileName,
            'post'            => $this->request->getData('post'),
          ];

          $post = $this->Posts->patchEntity($post, $data);

          if ($this->Posts->save($post)) {
            $this->Flash->success(__('The Post has been saved.'));
            return $this->redirect($this->referer());
          } else {
            $this->Flash->error(__('Something wrong. Please, try again.'));
            return $this->redirect($this->referer());
          }
        } else {
          $this->Flash->error(__('Something wrong. Please, try again.'));
          return $this->redirect($this->referer());
        }

    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Posts->get($id);
        if ($this->Posts->delete($post)) {
            $this->Flash->success(__('The post has been deleted.'));
            return $this->redirect($this->referer());
        } else {
            $this->Flash->error(__('The post could not be deleted. Please, try again.'));
            return $this->redirect($this->referer());
        }

        return $this->redirect($this->referer());
    }

    public function share()
    {
      $post = $this->Posts->newEmptyEntity();
      if ($this->request->is('post')) {
        $data = [
          'user_id' => $this->request->getData('user_id'),
          'post' => $this->request->getData('post'),
          'shared_post_id' => $this->request->getData('post_id'),
        ];
        $post = $this->Posts->newEntity($data);
        if ($this->Posts->save($post)) {
          return $this->redirect($this->referer());
        } else {
          return $this->redirect($this->referer());
        }
      }
    }

}
