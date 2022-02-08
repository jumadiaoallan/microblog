<div class="row justify-content-md-center mt-3 card p-3" style="background-color:#999999;color:white;">
  <div class="col-md-12">
    <table style="width:100%;">
      <tr>
        <?php foreach ($alluser as $userDetail): ?>
        <?php if ($userDetail->id == $post->user_id): ?>
        <td style=" width:42px;" rowspan="2" class="p-2"><?= $this->Html->image('upload/'.$userDetail->profile_path, array('alt' => 'Microblog', 'border' => '1', 'width'=>'40px')); ?></td>
        <td>
          <?= $userDetail->full_name?>
        </td>
      <?php endif; ?>
      <?php endforeach; ?>
        <td class="float-end">
            <sup data-bs-toggle="modal" data-bs-target = "#editPost" data-id="<?=$post->id?>" data-post = "<?=$post->post?>" data-image="<?=$post->image_path?>" style="cursor:pointer;" onclick="editPost(this)">Edit</sup>
            <sup data-bs-toggle="modal" data-bs-target = "#deletePost" data-id="<?=$post->id?>" style="cursor:pointer;" onclick="deletePost(this)">Delete</sup>
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
                        <td style=" width:42px;" rowspan="2" class="p-2"><?= $this->Html->image('upload/'.$userDetail->profile_path, array('alt' => 'Microblog', 'border' => '1', 'width'=>'40px')); ?></td>
                        <td>
                          <?= $userDetail->full_name?>
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
      <button type="button" id="<?= $post->id ?>" onclick="like(this)" name="like" class="form-control btn btn-sm btn-secondary" data-value="<?= !empty($post->likes[0]['id']) ? $post->likes[0]['id'] : null ?>" data-postID="<?= $post->id?>" data-userID="<?= $this->Identity->get('id')?>" >
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
        <button type="button" data-bs-toggle="modal" data-bs-target = "#sharePost" name="button" class="form-control btn btn-sm btn-secondary"  data-postid = "<?= !empty($post->shared_post_id) ? $post->shared_post_id : $post->id?>" onclick="share(this)" >SHARE</button>
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
                <td> <?= $element->full_name ?>
                  <?php endif; ?>
                   <?php endforeach; ?>
                </td>
                <td class="float-end">
                  <sup data-bs-toggle="modal" data-id="<?= $comment->id?>" data-comment="<?= $comment->comment?>" onclick="edtcmmt(this)" style="cursor:pointer;" data-bs-target="#editComment">Edit</sup>
                  <sup data-bs-toggle="modal" data-id="<?= $comment->id?>" style="cursor:pointer;" data-bs-target="#deleteComment" onclick="deleteComment(this)">Delete</sup>
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
      <textarea name="comment" id="comment" rows="3" class="form-control mt-2" style="min-width: 100%; background-color:#999999;color:white;" placeholder="WRITE A COMMENT"></textarea>
    </div>
    <div class="col-md-3 offset-md-9">
      <button name="btnComment" class="form-control btn btn-secondary btn-sm mt-2" data-pid="<?= $post->id ?>" data-uid="<?= $this->Identity->get('id')?>" onclick="addcomment(this)"> SUBMIT </button>
    </div>
  </div>
</div>

<?= $this->element('modal') ?>
