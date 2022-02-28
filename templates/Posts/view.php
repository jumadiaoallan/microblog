<div class="row justify-content-md-center mt-3 card p-3" style="background-color:#999999;color:white;">
  <div class="col-md-12">
    <table style="width:100%;">
      <tr>
        <?php foreach ($alluser as $userDetail) : ?>
            <?php if ($userDetail->id == $post->user_id) : ?>
        <td style="width:50px;height:50px;" rowspan="2" class="p-2 post_profile">
                <?= $this->Html->image('upload/' . h($userDetail->profile_path), ['alt' => 'Microblog']); ?>
        </td>
        <td>  &nbsp;
                <?= h($userDetail->full_name)?>
        </td>
            <?php endif; ?>
        <?php endforeach; ?>
        <td class="float-end">
            <sup data-bs-toggle="modal" data-bs-target = "#editPost" data-id="<?=h($post->id)?>" data-post = "<?=h($post->post)?>" data-image="<?=h($post->image_path)?>" style="cursor:pointer;" onclick="editPost(this)">Edit</sup>
            <sup data-bs-toggle="modal" data-bs-target = "#deletePost" data-id="<?=h($post->id)?>" style="cursor:pointer;" onclick="deletePost(this)">Delete</sup>
        </td>
      </tr>
      <tr>
        <td> &nbsp;<sup><?= date('m-d-Y H:i A', strtotime(h($post->created))) ?></sup></td>
        <td></td>
      </tr>
    </table>
  </div>
  <div class="col-md-12">
    <?= $this->Html->link(
        'Post Description:',
        ['controller' => 'Posts', 'action' => 'view', h($post->id)],
        ['style' => 'color:inherit;text-decoration:none;']
    ); ?>
    <p style="text-align: justify;"><?= h($post->post) ?></p>

    <?php if (!empty($post->shared_post_id)) : ?>
            <?php foreach ($allpost as $shared) : ?>
                <?php if ($post->shared_post_id == $shared->id) : ?>
                    <?php if ($shared->deleted == null) : ?>
                    <div class="row card p-3" style="background-color:#999999;color:white;">
                      <div class="col-md-12">
                        <table style="width:100%;">
                          <tr>
                            <?php foreach ($alluser as $userDetail) : ?>
                                <?php if ($userDetail->id == $shared->user_id) : ?>
                            <td style=" width:50px;height:50px;" rowspan="2" class="p-2 post_profile"><?= $this->Html->image('upload/' . h($userDetail->profile_path), ['alt' => 'Microblog']); ?></td>
                            <td>
                                    <?= $this->Html->link(
                                        h($userDetail->full_name),
                                        ['controller' => 'Users', 'action' => 'profile', h($userDetail->id)],
                                        ['style' => 'color:inherit;text-decoration:none;']
                                    ); ?>
                            </td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                          </tr>
                          <tr>
                            <td> <sup><?= date('m-d-Y H:i A', strtotime(h($shared->created))) ?></sup></td>
                          </tr>
                        </table>
                      </div>

                    <div class="col-md-12">
                        <?= $this->Html->link(
                            'Post Description:',
                            ['controller' => 'Posts', 'action' => 'view', h($shared->id)],
                            ['style' => 'color:inherit;text-decoration:none;']
                        ); ?>
                      <p style="text-align: justify;"><?= h($shared->post) ?></p>

                        <?php if (!empty($shared->image_path)) : ?>
                          <div class="post_photo">
                            <?= $this->Html->image('post_upload/' . h($shared->image_path), ['alt' => 'Microblog', 'border' => '1', 'class' => 'img-fluid mx-auto d-block']); ?>
                          </div>
                        <?php endif; ?>

                    </div>
                    </div>
                    <?php else : ?>
                      <div class="row card p-3" style="background-color:#999999;color:white;">
                        <div class="col-md-12 text-center">
                           Shared contain is not available.
                        </div>
                      </div>
                    <?php endif; ?>

                <?php endif; ?>

            <?php endforeach; ?>
    <?php endif; ?>


      <?php if (!empty($post->image_path)) : ?>
        <div class="post_photo">
            <?= $this->Html->image('post_upload/' . h($post->image_path), ['alt' => 'Microblog', 'border' => '1', 'class' => 'img-fluid mx-auto d-block']); ?>
        </div>
      <?php endif; ?>

  </div>
  <div class="col-md-12">
    <div class="row">
      <div class="col-sm-4 mt-2">
      <button type="button" id="<?= h($post->id) ?>" onclick="like(this)" name="like" class="form-control btn btn-sm btn-secondary btnlike" data-value="<?= !empty($post->likes[0]['id']) ? h($post->likes[0]['id']) : null ?>" data-postID="<?= h($post->id)?>" data-userID="<?= h($this->Identity->get('id'))?>" >
        <?php $liked = $post->likes ?>
        <?php
        $find_user = array_search(h($this->Identity->get('id')), array_column($liked, 'user_id')) + 1;
        $like_user = array_search(h($this->Identity->get('id')), array_column($liked, 'user_id'));
        ?>
         <?php if (count($liked) != 0) : ?>
                <?php if ($find_user) : ?>
                    <?php if ($post->likes[$like_user]['user_id'] == $this->Identity->get('id')) : ?>
                 UNLIKE (<?= count($liked)?>)
                    <?php else : ?>
                 LIKE (<?= count($liked)?>)
                    <?php endif; ?>
                <?php endif; ?>
         <?php else : ?>
             LIKE (<?= count($liked)?>)
         <?php endif; ?>
      </button>
      </div>
      <div class="col-sm-4 mt-2">
        <button type="button" name="button" class="form-control btn btn-sm btn-secondary">COMMENT</button>
      </div>
      <div class="col-sm-4 mt-2">
        <button type="button" data-bs-toggle="modal" data-bs-target = "#sharePost" name="button" class="form-control btn btn-sm btn-secondary"  data-postid = "<?= !empty($post->shared_post_id) ? h($post->shared_post_id) : h($post->id)?>" onclick="share(this)" >SHARE</button>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="row justify-content-md-center mt-2 p-3 card"  style="background-color:#999999;color:white;">
      <?php if (count($post->comments) != 0) : ?>
            <?php foreach ($post->comments as $comment) : ?>
          <div class="content" style="display:none;">
            <div class="col-md-12">
              <table style="width:100%;">
                <tr>
                  <?php foreach ($alluser as $element) : ?>
                        <?php if ($element->id == $comment->user_id) : ?>
                  <td style=" width:50px;" rowspan="2" class="p-2 post_profile">
                    &nbsp;
                            <?= $this->Html->image('upload/' . h($element->profile_path), ['alt' => 'Microblog']); ?>
                  </td>
                  <td>      &nbsp;
                            <?= $this->Html->link(
                                h($element->full_name),
                                ['controller' => 'Users', 'action' => 'profile', h($element->id)],
                                ['style' => 'color:inherit;text-decoration:none;']
                            ); ?>

                        <?php endif; ?>
                  <?php endforeach; ?>
                  </td>
                  <td class="float-end">
                    <?php if ($this->Identity->get('id') == $comment->user_id) : ?>
                      <sup data-bs-toggle="modal" data-id="<?= h($comment->id)?>" data-comment="<?= h($comment->comment)?>" onclick="edtcmmt(this)" style="cursor:pointer;" data-bs-target="#editComment">Edit</sup>
                      <sup data-bs-toggle="modal" data-id="<?= h($comment->id)?>" style="cursor:pointer;" data-bs-target="#deleteComment" onclick="deleteid(this)">Delete</sup>
                    <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <td> &nbsp;&nbsp;<sup><?= date('m-d-Y H:i A', strtotime(h($comment->created))) ?></sup></td>
                  <td></td>
                </tr>
              </table>
            </div>
            <div class="col-md-12">
                <p style="text-align: justify;" class="p-2"><?= h($comment->comment) ?></p>
                <hr>
            </div>
          </div>
            <?php endforeach; ?>
      <?php else : ?>
          <span class="text-center">No Comment</span>
      <?php endif; ?>
      <center>
        <?php if (count($post->comments) > 3) : ?>
          <span id="loadMore" data-id = "<?=$post->id?>" onclick="loadMore(this)" style="cursor:pointer;">Load More</span>
        <?php endif; ?>
      </center>
    </div>

  </div>
  <!-- COMMENT FORM -->
  <div class="row justify-content-md-center mt-2 p-2">
    <div class="col-md-12">
      <textarea name="comment" id="<?= 'comment_' . h($post->id) ?>" rows="3" class="form-control mt-2" style="min-width: 100%; background-color:#999999;color:white;" placeholder="WRITE A COMMENT"></textarea>
    </div>
    <div class="col-md-3 offset-md-9">
      <button name="btnComment" class="form-control btn btn-secondary btn-sm mt-2" data-pid="<?= h($post->id) ?>" data-uid="<?= h($this->Identity->get('id'))?>" onclick="addcomment(this)"> SUBMIT </button>
    </div>
  </div>
</div>

<?= $this->element('modal') ?>

<?= $this->Html->script('view-comment-load');?>

<script type="text/javascript">

$( document ).ready(function() {
    post_edit.onchange = evt => {
      const [file] = post_edit.files
      if (file) {
        $("#image_edit").removeClass("d-none");
        image_edit.src = URL.createObjectURL(file);
      }
      }

  });

</script>
