<style>

.page-link {
  position: relative;
  display: block;
  padding: 0.5rem 0.75rem;
  margin-left: -1px;
  line-height: 1.25;
  color: #fff;
  background-color: #999999;
  border: 1px solid #d9e2ef;
}

.page-item.disabled .page-link {
  color: #868e96;
  pointer-events: none;
  cursor: auto;
  background-color: #d9e2ef;
  border-color: #999999;
}

.page-item.active .page-link {
  z-index: 1;
  color: #fff;
  background-color: #646464;
  border-color: #d9e2ef;
}

.page-link:focus, .page-link:hover {
  color: #fff;
  text-decoration: none;
  background-color: #646464;
  border-color: #d9e2ef;

}

</style>

<?php foreach ($user as $post): ?>
<div class="row justify-content-md-center mt-3 card p-3" style="background-color:#999999;color:white;">
  <div class="col-md-12">
    <table style="width:100%;">
      <tr>
        <?php foreach ($alluser as $userDetail): ?>
        <?php if ($userDetail->id == $post->user_id): ?>
        <td style=" width:42px;" rowspan="2" class="p-2">
          <?= $this->Html->image("upload/".$userDetail->profile_path, ["alt" => "Microblog", 'width'=>'40px', 'url' => ['controller' => 'Users', 'action' => 'profile', $userDetail->id]])?>
        </td>
        <td>
          <?= $this->Html->link(
          $userDetail->full_name,
          ['controller' => 'Users', 'action' => 'profile', $userDetail->id],
          ['style' => 'color:inherit;text-decoration:none;']); ?>
        </td>
      <?php endif; ?>
      <?php endforeach; ?>
        <td class="float-end">
          <?php if ($this->Identity->get('id') == $post->user_id): ?>
            <sup data-bs-toggle="modal" data-bs-target = "#editPost" data-id="<?=$post->id?>" data-post = "<?=$post->post?>" data-image="<?=$post->image_path?>" style="cursor:pointer;" onclick="editPost(this)">Edit</sup>
            <sup data-bs-toggle="modal" data-bs-target = "#deletePost" data-id="<?=$post->id?>" style="cursor:pointer;" onclick="deletePost(this)">Delete</sup>
          <?php endif; ?>
        </td>
      </tr>
      <tr>
        <td> <sup><?=  date('m-d-Y H:i A', strtotime($post->created)) ?></sup></td>
        <td></td>
      </tr>
    </table>
  </div>
  <div class="col-md-12">
    <?= $this->Html->link(
    'Post Description:',
    ['controller' => 'Posts', 'action' => 'view', $post->id],
    ['style' => 'color:inherit;text-decoration:none;']); ?>
    <p style="text-align: justify;"><?= $post->post ?></p>

    <?php if (!empty($post->shared_post_id)): ?>
            <?php foreach ($allpost as $shared): ?>

              <?php if ($post->shared_post_id == $shared->id): ?>

                <div class="row card p-3" style="background-color:#999999;color:white;">
                  <div class="col-md-12">
                    <table style="width:100%;">
                      <tr>
                        <?php foreach ($alluser as $userDetail): ?>
                        <?php if ($userDetail->id == $shared->user_id): ?>
                        <td style=" width:42px;" rowspan="2" class="p-2">
                          <?= $this->Html->image("upload/".$userDetail->profile_path, ["alt" => "Microblog", 'width'=>'40px', 'url' => ['controller' => 'Users', 'action' => 'profile', $userDetail->id]])?>
                        </td>
                        <td>
                          <?= $this->Html->link(
                          $userDetail->full_name,
                          ['controller' => 'Users', 'action' => 'profile', $userDetail->id],
                          ['style' => 'color:inherit;text-decoration:none;']); ?>
                        </td>
                      <?php endif; ?>
                      <?php endforeach; ?>
                      </tr>
                      <tr>
                        <td> <sup><?=  date('m-d-Y H:i A', strtotime($shared->created)) ?></sup></td>
                      </tr>
                    </table>
                  </div>

                <div class="col-md-12">
                  <?= $this->Html->link(
                  'Post Description:',
                  ['controller' => 'Posts', 'action' => 'view', $shared->id],
                  ['style' => 'color:inherit;text-decoration:none;']); ?>
                  <p style="text-align: justify;"><?= $shared->post ?></p>
                  <span>
                    <?php if (!empty($shared->image_path)): ?>
                      <?= $this->Html->image('post_upload/'.$shared->image_path, array('alt' => 'Microblog', 'border' => '1', 'class'=> 'img-fluid mx-auto d-block')); ?>
                    <?php endif; ?>
                  </span>
                </div>
                </div>
              <?php endif; ?>

            <?php endforeach; ?>
    <?php endif; ?>

    <span>
      <?php if (!empty($post->image_path)): ?>
        <?= $this->Html->image('post_upload/'.$post->image_path, array('alt' => 'Microblog', 'border' => '1', 'class'=> 'img-fluid mx-auto d-block')); ?>
      <?php endif; ?>
    </span>
  </div>
  <div class="col-md-12">
    <div class="row">
      <div class="col-sm-4 mt-2">
      <button type="button" id="<?= $post->id ?>" onclick="like(this)" name="like" class="form-control btn btn-sm btn-secondary" data-value="<?= !empty($post->likes[0]['id']) ? $post->likes[0]['id'] : null ?>" data-postID="<?= $post->id?>" data-userID="<?= $detail[0]['id']?>" >
          <?php if (isset($post->likes[0])): ?>
            UNLIKE
            <?php else: ?>
            LIKE
          <?php endif; ?>
      </button>
      </div>
      <div class="col-sm-4 mt-2">
        <button type="button" name="button" class="form-control btn btn-sm btn-secondary">COMMENT</button>
      </div>
      <div class="col-sm-4 mt-2">
        <button data-bs-toggle="modal" data-bs-target = "#sharePost" class="form-control btn btn-sm btn-secondary" data-postid = "<?= !empty($post->shared_post_id) ? $post->shared_post_id : $post->id?>" onclick="share(this)">SHARE</button>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="row justify-content-md-center mt-2 p-3 card"  style="background-color:#999999;color:white;">
      <?php foreach ($post->comments as $comment): ?>
          <div class="col-md-12">
            <table style="width:100%;">
              <tr>
                <?php foreach ($alluser as $element): ?>
                  <?php if ($element->id == $comment->user_id): ?>
                <td style=" width:42px;" rowspan="2" class="p-2"><?= $this->Html->image('upload/'.$element->profile_path, array('alt' => 'Microblog', 'border' => '1', 'width'=>'40px')); ?></td>
                <td>
                  <?= $this->Html->link(
                  $element->full_name,
                  ['controller' => 'Users', 'action' => 'profile', $element->id],
                  ['style' => 'color:inherit;text-decoration:none;']); ?>

                  <?php endif; ?>
                   <?php endforeach; ?>
                </td>
                <td class="float-end">
                  <?php if ($this->Identity->get('id') == $comment->user_id): ?>
                    <sup data-bs-toggle="modal" data-id="<?= $comment->id?>" data-comment="<?= $comment->comment?>" onclick="edtcmmt(this)" style="cursor:pointer;" data-bs-target="#editComment">Edit</sup>
                    <sup data-bs-toggle="modal" data-id="<?= $comment->id?>" style="cursor:pointer;" data-bs-target="#deleteComment" onclick="deleteComment(this)">Delete</sup>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <td> <sup><?=  date('m-d-Y H:i A', strtotime($comment->created)) ?></sup></td>
                <td></td>
              </tr>
            </table>
          </div>
          <div class="col-md-12">
              <p style="text-align: justify;" class="p-2"><?= $comment->comment ?></p>
              <hr>
          </div>
      <?php endforeach; ?>
    </div>

  </div>
  <!-- COMMENT FORM -->
  <div class="row justify-content-md-center mt-2 p-2">
    <div class="col-md-12">
      <textarea name="comment" id="<?= "comment_".$post->id ?>" rows="3" class="form-control mt-2" style="min-width: 100%; background-color:#999999;color:white;" placeholder="WRITE A COMMENT"></textarea>
    </div>
    <div class="col-md-3 offset-md-9">
      <button name="btnComment" class="form-control btn btn-secondary btn-sm mt-2" data-pid="<?= $post->id ?>" data-uid="<?= $this->Identity->get('id')?>" onclick="addcomment(this)"> SUBMIT </button>
    </div>
  </div>
</div>
<?php endforeach; ?>

<nav aria-label="pagination" class="float-end mt-3">
  <ul class="pagination">
    <?= $this->Paginator->prev("<<")?>
    <?= !$this->Paginator->numbers() ? '<li class="page-item"><a href="#" class="page-link">1</a></li>' : $this->Paginator->numbers() ?>
    <?= $this->Paginator->next(">>")?>
  </ul>
</nav>



<script type="text/javascript">
  var isLogged_in = "<?= $this->Identity->get('id')?>";

</script>
