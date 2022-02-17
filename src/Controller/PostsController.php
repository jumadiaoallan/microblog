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
        $noti = TableRegistry::get('Notifications');
        $follow = TableRegistry::get('Followers');
        $logged = $this->Authentication->getResult();
        $loggedID = $logged->getData();

        if (!empty($loggedID)) {
          $id = $loggedID['id'];
        } else {
          $id = 0;
        }

        $notification = $noti->find()
                      ->where(['user_id' => $id])
                      ->andWhere(['status'=>FALSE])
                      ->andWhere(['user_from !=' => $id])
                      ->count();
        $post = $userPost->newEmptyEntity();
        $search = $userDetails->newEmptyEntity();
        $alluser = $userDetails->find('all')->toArray();
        $allpost = $userPost->find('all', ['withDeleted'])->toArray();
        $detail = $userDetails->find('all')->toArray();
        $followings = $follow->find('all')
                     ->where(['follower_user' => $loggedID['id']]);

        $arr = [$loggedID['id']];
        foreach ($followings as $following) {
          $param = $following->following_user;
          array_push($arr, $param);
        }

          $users = $userPost->find()
            ->contain(['Comments','Likes'])
            ->order(['Posts.created' => 'DESC'])
            ->where(['Posts.user_id IN' => $arr]);

        $user = $this->paginate($users, ['limit'=>'5']);
        $header = ["title"=>"Homepage", "notification"=>$notification];
        $this->set(compact('header','post','search','user', 'detail', 'alluser', 'allpost'));
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

          $logged = $this->Authentication->getResult();
          $loggedID = $logged->getData();
          $noti = TableRegistry::get('Notifications');
          $notification = $noti->find()
                        ->where(['user_id' => $loggedID['id']])
                        ->andWhere(['status'=>FALSE])
                        ->andWhere(['user_from !=' => $loggedID['id']])
                        ->count();

          $header = ["title"=>"View Post", "notification"=>$notification];
          $userDetails = TableRegistry::get('Users');
          $search = $userDetails->newEmptyEntity();
          $userPost = TableRegistry::get('Posts');
          $allpost = $userPost->find('all', ['withDeleted'])->toArray();

          $post = $this->Posts->get($id, ['contain' => ['Likes', 'Comments'],]);

          $alluser = $userDetails->find('all')->toArray();

          $this->set(compact('post','header', 'search','alluser', 'allpost'));
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      $post = $this->Posts->newEmptyEntity();

      if ($this->request->is('post')) {
        $postTable = TableRegistry::get('Posts');
        $image = $this->request->getData('image_post');
        if (!empty($image->getClientFilename())) {
          $image = $this->request->getData('image_post');
          $fileName = time()."_".$image->getClientFilename();
          $path = WWW_ROOT.'img'.DS."post_upload/".$fileName;
          $image->moveTo($path);
        } else {
          $fileName = null;
        }

        $usersLogedin = $this->Authentication->getResult();
        $logged = $usersLogedin->getData();

        $data = [
          'user_id'        => $logged['id'],
          'image_path'     => $fileName,
          'post'           => $this->request->getData('post'),
        ];
        $post = $postTable->patchEntity($post, $data);
        if ($this->Posts->save($post)) {
          $this->Flash->success(__('Successfully Posted!'));
          $this->redirect($this->referer());
        } else {
          $this->Flash->error(__('Something wrong. Please, try again.'));
          $this->redirect($this->referer());
        }
      }
      $this->set(compact('post'));
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
          $this->Flash->success(__('The post has been shared.'));

          //notification
          $notification = TableRegistry::get("Notifications");
          $posts = TableRegistry::get("Posts");
          $userid = $posts->find()->where(['id'=>$this->request->getData("post_id")])->first();
          $noti = $notification->newEmptyEntity();
          $data = [
            "user_id" => $userid->user_id,
            "user_from" => $this->request->getData('user_id'),
            "notification" => "Shared on your post.".$post->id,
            "status" => false
          ];
          $noti = $notification->newEntity($data);
          $notification->save($noti);
          //end notification


          return $this->redirect($this->referer());
        } else {
          return $this->redirect($this->referer());
        }
      }
    }

}
