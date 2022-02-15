<div class="row justify-content-md-center">
  <div class="col-md-12">
      <?= $this->Html->image('upload/'.h($detail['banner_path']), array('alt' => 'Banner', 'border' => '1', 'class'=>'img-fluid', 'style'=>'width:100%;cursor:pointer', 'data-bs-toggle'=>'modal', 'data-bs-target'=>'#banner')); ?>
  </div>
  <div class="col-md-12" style="margin-top:-15%;">
    <center>
    <?= $this->Html->image('upload/'.h($detail['profile_path']), array('alt' => 'Profile', 'border' => '1', 'class'=>'img-fluid rounded-circle', 'width'=>'20%', 'data-bs-toggle'=>'modal', 'data-bs-target'=>'#profiles', 'style'=>'cursor:pointer')); ?>
    </center>
  </div>
  <div class="col-md-12 text-center mt-2 text-white">
    <h4><?= h($detail['full_name']) ?></h4>
      <?php if ($this->Identity->get('id') == $detail['id']): ?>
        <?=$this->Html->link(
              'Edit Profile',
              ['controller' => 'Users', 'action' => 'edit', h($detail['id'])],['style'=> 'text-decoration:none; color:white;font-size:12px;']
          )?>
      <?php endif; ?>
  </div>
  <div class="col-md-12 text-center text-white">

  <?php $follow =  $followers?>

  <?php $following = array_search($this->Identity->get('id'), array_column($follow, 'follower_user')) + 1 ?>
  <?php $followingDetails = array_search($this->Identity->get('id'), array_column($follow, 'follower_user')) ?>

  <?php if (count($follow) != 0): ?>
    <?php if ($this->Identity->get('id') != $detail['id']): ?>

    <?php if (isset($follow[$followingDetails]['follower_user'])): ?>

        <div class="row justify-content-md-center">
          <div class="col-md-3 col-sm-3 mb-2">
            <button onclick="follow(this)" class="form-control btn btn-secondary" id="btnFollow" data-followedid="<?=h($follow[$followingDetails]['id'])?>" data-following ="<?= h($detail['id'])?>" data-follower = "<?= h($this->Identity->get('id'))?>"><?= $follow[$followingDetails]['deleted'] == null && $follow[$followingDetails]['follower_user'] == $this->Identity->get('id')?"Following":"Follow"?></button>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>
    <?php else: ?>
      <?php if ($this->Identity->get('id') != $detail['id']): ?>
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
  "Followers: ".h($followers),
  ['controller' => 'Followers', 'action' => 'index',h($detail['id']), '?' => ['type' => 'follower']],
  ['style' => 'color:inherit;text-decoration:none;font-size:12px;']); ?>

  <?= $this->Html->link(
  "Following: ".h($following),
  ['controller' => 'Followers', 'action' => 'index', h($detail['id']), '?' => ['type' => 'following']],
  ['style' => 'color:inherit;text-decoration:none;font-size:12px;']); ?>
  </div>
</div>

<div class="row justify-content-md-center">
  <?php if ($this->Identity->get('id') == $detail['id']): ?>
    <?= $this->element('post') ?>
  <?php endif; ?>
</div>
  <div id = "comment_section">
    <?= $this->element('post-view') ?>
  </div>


  <?= $this->element('modal') ?>

  <?= $this->Html->script('photo_viewer');?>
