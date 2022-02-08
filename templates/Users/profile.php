<div class="row justify-content-md-center">
  <div class="col-md-12">
    <?= $this->Html->image(h($detail[0]['banner_path']), array('alt' => 'Banner', 'border' => '1', 'class'=>'img-fluid', 'style'=>'width:100%;cursor:pointer', 'data-bs-toggle'=>'modal', 'data-bs-target'=>'#banner')); ?>
  </div>
  <div class="col-md-12" style="margin-top:-15%;">
    <center>
    <?= $this->Html->image('upload/'.$detail[0]['profile_path'], array('alt' => 'Profile', 'border' => '1', 'class'=>'img-fluid rounded-circle', 'width'=>'20%', 'data-bs-toggle'=>'modal', 'data-bs-target'=>'#profiles', 'style'=>'cursor:pointer')); ?>
    </center>
  </div>
  <div class="col-md-12 text-center mt-2 text-white">
    <h4><?= h($detail[0]['full_name']) ?></h4>
      <?php if ($this->Identity->get('id') == $detail[0]['id']): ?>
        <a href="http://localhost:8765/users/edit/<?= $detail[0]['id']  ?>" style="text-decoration:none; color:white;"><sup class="text-sm">Edit Profile</sup></a>
      <?php endif; ?>
  </div>
  <div class="col-md-12 text-center text-white">

  <?php if (!empty($followers)): ?>
    <?php foreach ($followers as $follower): ?>
      <?php if ($follower->following_user == $detail[0]['id']): ?>
        <div class="row justify-content-md-center">
          <div class="col-2 mb-2">
            <button onclick="follow(this)" class="form-control btn btn-secondary" id="btnFollow" data-followedid="<?=$follower->id?>" data-followedid="" data-following ="<?= $detail[0]['id']?>" data-follower = "<?= $this->Identity->get('id')?>"><?= $follower->deleted == null?"Following":"Follow"?></button>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>



  <?= $this->Html->link(
  "Followers: 1000",
  ['controller' => 'Followers', 'action' => 'index', 'followers', $detail[0]['id']],
  ['style' => 'color:inherit;text-decoration:none;font-size:12px;']); ?>
  
  <?= $this->Html->link(
  "Following: 1000",
  ['controller' => 'Followers', 'action' => 'index', 'followings', $detail[0]['id']],
  ['style' => 'color:inherit;text-decoration:none;font-size:12px;']); ?>
  </div>
</div>

<div class="row justify-content-md-center">
  <?php if ($this->Identity->get('id') == $detail[0]['id']): ?>
    <?= $this->element('post') ?>
  <?php endif; ?>
</div>
  <div id = "comment_section">
    <?= $this->element('post-view') ?>
  </div>


  <?= $this->element('modal') ?>
