<?php $userID = h($this->Identity->get('id'))?>
<div class="row justify-content-md-center">
  <div class="col-md-12">
      <div class="banner">
        <?= $this->Html->image('upload/' . h($detail['banner_path']), ['alt' => 'Banner', 'border' => '1', 'class' => 'img-fluid', 'style' => 'width:100%;cursor:pointer', 'data-bs-toggle' => 'modal', 'data-bs-target' => '#banner']); ?>
      </div>
  </div>
  <div class="col-md-12 " style="margin-top:-15%;">
    <center>
      <div class="profile">
        <?= $this->Html->image(
            'upload/' . h($detail['profile_path']),
            ['alt' => 'Profile', 'border' => '1', 'class' => 'img-fluid',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#profiles',
            'style' => 'cursor:pointer']
        ); ?>
      </div>

    </center>
  </div>
  <div class="col-md-12 text-center mt-2 text-white">
    <h4><?= h($detail['full_name']) ?></h4>
      <?php if ($this->Identity->get('id') == $detail['id']) : ?>
            <?=$this->Html->link(
                'Edit Profile',
                ['controller' => 'Users', 'action' => 'edit', h($detail['id'])],
                ['style' => 'text-decoration:none; color:white;font-size:12px;']
            ) ?>
      <?php endif; ?>
  </div>
  <div class="col-md-12 text-center text-white">

  <?php $follow = $followers?>

  <?php $following = array_search($this->Identity->get('id'), array_column($follow, 'follower_user')) + 1 ?>
  <?php $followingDetails = array_search($this->Identity->get('id'), array_column($follow, 'follower_user')) ?>

  <?php if (count($follow) != 0) : ?>
        <?php if ($this->Identity->get('id') != $detail['id']) : ?>
            <?php if (isset($follow[$followingDetails]['follower_user'])) : ?>
        <div class="row justify-content-md-center">
          <div class="col-md-3 col-sm-3 mb-2">
            <button onclick="follow(this)" class="form-control btn btn-secondary" id="btnFollow" data-followedid="<?=h($follow[$followingDetails]['id'])?>" data-following ="<?= h($detail['id'])?>" data-follower = "<?= h($this->Identity->get('id'))?>"><?= $follow[$followingDetails]['deleted'] == null && $follow[$followingDetails]['follower_user'] == $this->Identity->get('id') ? 'Following' : 'Follow' ?></button>
          </div>
        </div>
            <?php endif; ?>
        <?php endif; ?>
  <?php else : ?>
        <?php if ($this->Identity->get('id') != $detail['id']) : ?>
        <div class="row justify-content-md-center justify-content-sm-center">
          <div class="col-md-3 col-sm-3 mb-2">
            <button onclick="follow(this)" class="form-control btn btn-secondary" id="btnFollow" data-followedid="" data-following ="<?= h($detail['id'])?>" data-follower = "<?= h($this->Identity->get('id'))?>">Follow</button>
          </div>
        </div>
        <?php endif; ?>
  <?php endif; ?>



  <?php $follow = clone $followersTbl ?>
  <?php $folling = clone $followersTbl ?>
  <?php $following = $follow->where(['follower_user' => $detail['id']])->count()?>
  <?php $followers = $folling->where(['following_user' => $detail['id']])->count()?>


  <?= $this->Html->link(
      'Followers: ' . h($followers),
      ['controller' => 'Followers', 'action' => 'index', h($detail['id']), '?' => ['type' => 'follower']],
      ['style' => 'color:inherit;text-decoration:none;font-size:12px;']
  ); ?>

  <?= $this->Html->link(
      'Following: ' . h($following),
      ['controller' => 'Followers', 'action' => 'index', h($detail['id']), '?' => ['type' => 'following']],
      ['style' => 'color:inherit;text-decoration:none;font-size:12px;']
  ); ?>
  </div>
</div>

<div class="row justify-content-md-center">
  <?php if ($this->Identity->get('id') == $detail['id']) : ?>
        <?= $this->element('post') ?>
  <?php endif; ?>
</div>
  <div id = "comment_section">
    <?= $this->element('post-view') ?>
  </div>

  <?= $this->element('modal') ?>

  <div class = "modal" id ="profiles">
    <div class="modal-dialog modal-dialog-centered" >
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header" style="background-color:#7f7f7f;">
          <?php if ($this->Identity->get('id') == $detail['id']) : ?>
            <h4 class="modal-title">Edit Profile Photo</h4>
          <?php endif; ?>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <!-- Modal body -->
        <div class="modal-body"  style="background-color:#7f7f7f;">
          <?php if ($userID == $detail['id']) : ?>
                <?= $this->Form->create($photo, ['url' => ['controller' => 'Users', 'action' => 'profilepic', $userID], 'type' => 'file', 'id' => 'profileForm']) ?>
          <?php endif; ?>
          <div class="post_photo">
          <?=$this->Html->image('upload/' . h($detail['profile_path']), ['class' => 'img-fluid', 'id' => 'profile']);?>
        </div>
          <?php if ($userID == $detail['id']) : ?>
                <?= $this->Form->control(
                    'update_profile',
                    ['type' => 'file',
                    'class' => 'form-control mt-2',
                    'id' => 'imgInp' ]
                ) ?>
          <?php endif; ?>
        </div>
        <?php if ($userID == $detail['id']) : ?>
          <!-- Modal footer -->
          <div class="modal-footer"  style="background-color:#7f7f7f;">
              <?= $this->Form->button(__('Submit'), ['class' => 'form-control btn btn-secondary btn-md mt-2', 'id' => 'btnProfile']) ?>
              <?= $this->Form->end() ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>


  <!-- BANNER PHOTO-->
  <div class="modal" id="banner">
    <div class="modal-dialog modal-lg modal-dialog-centered" >
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header" style="background-color:#7f7f7f;">
          <?php if ($userID == $detail['id']) : ?>
            <h4 class="modal-title">Edit Banner Photo</h4>
          <?php endif; ?>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body"  style="background-color:#7f7f7f;">
          <?php if ($userID == $detail['id']) : ?>
                <?= $this->Form->create($photo, ['url' => ['controller' => 'Users', 'action' => 'banner', $userID], 'type' => 'file', 'id' => 'bannerForm']) ?>
          <?php endif; ?>

          <div class="post_photo">
          <?= $this->Html->image(
              'upload/' . h($detail['banner_path']),
              ['alt' => 'Banner', 'class' => 'img-fluid', 'id' => 'banners']
          ); ?>
        </div>
          <?php if ($userID == $detail['id']) : ?>
                <?= $this->Form->control(
                    'update_banner',
                    ['type' => 'file',
                    'class' => 'form-control mt-2',
                    'id' => 'imgInpbanner']
                ) ?>
          <?php endif; ?>
        </div>
        <?php if ($userID == h($detail['id'])) : ?>
          <div class="modal-footer"  style="background-color:#7f7f7f;">
              <?= $this->Form->button(__('Submit'), ['class' => 'form-control btn btn-secondary btn-md mt-2', 'id' => 'btnBanner']) ?>
              <?= $this->Form->end() ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class = "modal" id ="image-error">
    <div class="modal-dialog modal-dialog-centered" >
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header" style="background-color:#7f7f7f;">
          <?php if ($this->Identity->get('id') == $detail['id']) : ?>
            <h4 class="modal-title">Image Error!</h4>
          <?php endif; ?>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <!-- Modal body -->
        <div class="modal-body"  style="background-color:#7f7f7f;">
          <div class="row">
            <div class="col-md-12 text-white">
              Image size should below 2MB only.
            </div>
          </div>
        </div>
          <!-- Modal footer -->
          <div class="modal-footer"  style="background-color:#7f7f7f;">
              <button type="button" class="form-control btn btn-secondary" data-bs-dismiss="modal">Ok</button>
          </div>
      </div>
    </div>
  </div>

  <?php if ($userID == $detail['id']): ?>
    <?= $this->Html->script('photo_viewer.js?v1.1');?>
  <?php endif; ?>

  <script type="text/javascript">
    $(document).ready(function(){

        <?php

        if (!empty($this->Flash->render('invalid-image'))) {
            echo '$("#item-error").modal("show");';
        }

        ?>

        $( document ).ready(function() {

            btnBanner.onclick = evt => {
                var btn_submit = $('#btnBanner');
                var loading = '<i class="fa fa-spinner fa-spin"></i>';
                btn_submit.html(loading);
                btn_submit.prop('disabled', true);
                $("#bannerForm").submit();
              }

              btnProfile.onclick = evt => {
                  var btn_submit = $('#btnProfile');
                  var loading = '<i class="fa fa-spinner fa-spin"></i>';
                  btn_submit.html(loading);
                  btn_submit.prop('disabled', true);
                  $("#profileForm").submit();
                }

          });



    });
</script>
