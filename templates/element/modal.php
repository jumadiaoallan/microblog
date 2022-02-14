<!-- PROFILE PHOTO-->
<div class="modal" id="profiles">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color:#7f7f7f;">
        <?php if ($this->Identity->get('id') == $detail['id']): ?>
          <h4 class="modal-title">Edit Profile Photo</h4>
        <?php endif; ?>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body"  style="background-color:#7f7f7f;">
        <?php if ($this->Identity->get('id') == $detail['id']): ?>
          <?= $this->Form->create($photo , ['url' => ['controller' => 'Users','action' => 'profilepic', h($this->Identity->get('id'))], 'type'=> 'file']) ?>
        <?php endif; ?>
        <center>
        <?= $this->Html->image('upload/'.h($detail['profile_path']), array('alt' => 'profile', 'border' => '1', 'class'=>'img-fluid', 'id'=>'profile')); ?>
        </center>
        <?php if ($this->Identity->get('id') == $detail['id']): ?>
          <?= $this->Form->control('update_profile',['type' => 'file', 'class' => 'form-control mt-2', 'id'=>'imgInp' ,'accept'=> 'image/png, image/jpg, image/jpeg', 'required'=>true]) ?>
        <?php endif; ?>
      </div>
      <?php if ($this->Identity->get('id') == $detail['id']): ?>
        <!-- Modal footer -->
        <div class="modal-footer"  style="background-color:#7f7f7f;">
          <?= $this->Form->button(__('Submit'), ['class' => 'form-control btn btn-secondary btn-md mt-2']) ?>
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
        <?php if ($this->Identity->get('id') == $detail['id']): ?>
          <h4 class="modal-title">Edit Banner Photo</h4>
        <?php endif; ?>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body"  style="background-color:#7f7f7f;">
        <?php if ($this->Identity->get('id') == $detail['id']): ?>
            <?= $this->Form->create($photo , ['url' => ['controller' => 'Users','action' => 'banner', h($this->Identity->get('id'))], 'type'=> 'file']) ?>
        <?php endif; ?>

        <center>
        <?= $this->Html->image('upload/'.h($detail['banner_path']), array('alt' => 'Banner', 'border' => '1', 'class'=>'img-fluid', 'id'=>'banners')); ?>
        </center>
        <?php if ($this->Identity->get('id') == $detail['id']): ?>
          <?= $this->Form->control('update_banner',['type' => 'file', 'class' => 'form-control mt-2', 'id'=>'imgInpbanner' ,'accept'=> 'image/png, image/jpg, image/jpeg', 'required'=>true]) ?>
        <?php endif; ?>
      </div>
      <?php if (h($this->Identity->get('id')) == h($detail['id'])): ?>
        <div class="modal-footer"  style="background-color:#7f7f7f;">
          <?= $this->Form->button(__('Submit'), ['class' => 'form-control btn btn-secondary btn-md mt-2']) ?>
          <?= $this->Form->end() ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>


<!-- EDIT POST -->
<div class="modal" id="editPost">
  <div class="modal-dialog modal-lg modal-dialog-centered" >
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color:#7f7f7f;">
        <h4 class="modal-title">Edit Post</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body"  style="background-color:#7f7f7f;">
        <?= $this->Form->create($post , ['id'=>'edit_form', 'type' => 'file']) ?>
          <?= $this->Form->control ('post',['type' => 'textarea', 'id'=> 'edit_post' , 'rows'=>3, 'class' => 'form-control mt-2','label' => false, 'style'=>'min-width: 100%; background-color:#999999;color:white;']) ?>
        <center>
        <img src="" id="image_edit" class="img-fluid mt-2" alt="">
        </center>
        <div class="row mt-2">
          <div class="col-6">
            <?= $this->Form->control('id', ['type' => 'hidden', 'id'=>'id']) ?>
            <?= $this->Form->control ('image_post',['type' => 'file','class' => 'form-control mt-2 d-none', 'id'=>'post_edit', 'label'=>false]) ?>
            <label for="post_edit" class="form-control btn btn-secondary btn-sm btn-block mt-1" id="btn">EDIT IMAGE</label>
          </div>
          <div class="col-6">
            <span class="form-control btn btn-secondary btn-sm btn-block mt-1" onclick="$('#image_edit').attr('src', null);">REMOVE IMAGE</span>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer"  style="background-color:#7f7f7f;">
        <?= $this->Form->button(__('Submit'), ['class' => 'form-control btn btn-secondary btn-md mt-2']) ?>
        <?= $this->Form->end() ?>
      </div>

    </div>
  </div>
</div>


<!-- DELETE POST -->
<div class="modal" id="deletePost">
  <div class="modal-dialog modal-lg modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header" style="background-color:#7f7f7f;">
        <h4 class="modal-title">Delete Post</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body"  style="background-color:#7f7f7f;">
        <?= $this->Form->create(null , ['id'=>'delete_form']) ?>
          <label>Are you sure want to delete this post?</label>
        <div class="row p-2" style="background-color:#7f7f7f;">
          <div class="col-6">
            <button type="submit" class="form-control btn btn-secondary" name="submit">Yes</button>
          </div>
          <div class="col-6">
            <span class="form-control btn btn-secondary" data-bs-dismiss="modal">No</span>
          </div>
        </div>
        <?= $this->Form->end()?>
      </div>
      </div>
    </div>
    </div>


    <!-- EDIT COMMENT -->
    <div class="modal" id="editComment">
      <div class="modal-dialog modal-lg modal-dialog-centered" >
        <div class="modal-content">
          <div class="modal-header" style="background-color:#7f7f7f;">
            <h4 class="modal-title">Edit Comment</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body"  style="background-color:#7f7f7f;">
            <?= $this->Form->create(null , ['id'=>'comment_edit']) ?>
              <?= $this->Form->control ('comment',['type' => 'textarea', 'rows'=>3, 'class' => 'form-control mt-2','label' => false, 'style'=>'min-width: 100%; background-color:#999999;color:white;', 'id'=>'editC']) ?>
            <div class="row p-2" style="background-color:#7f7f7f;">
              <div class="col-6">
                <button type="submit" class="form-control btn btn-secondary">SAVE CHANGES</button>
              </div>
              <div class="col-6">
                <span class="form-control btn btn-secondary" data-bs-dismiss="modal">CANCEL</span>
              </div>
            </div>
            <?= $this->Form->end()?>
          </div>
          </div>
        </div>
        </div>

<!-- DELETE COMMENT -->
  <div class="modal" id="deleteComment">
    <div class="modal-dialog modal-lg modal-dialog-centered" >
      <div class="modal-content">
        <div class="modal-header" style="background-color:#7f7f7f;">
          <h4 class="modal-title">Delete Comment</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body"  style="background-color:#7f7f7f;">
          <form >
            <label>Are you sure want to delete this comment?</label>
          <div class="row p-2" style="background-color:#7f7f7f;">
            <div class="col-6">
              <input type="hidden" id="comment_ids" value="">
              <button type="submit" class="form-control btn btn-secondary" onclick="deleteComment()">Yes</button>
            </div>
            <div class="col-6">
              <span class="form-control btn btn-secondary" data-bs-dismiss="modal">No</span>
            </div>
          </div>
          </form>
        </div>
        </div>
      </div>
      </div>


<!-- Share Post -->
<div class="modal" id="sharePost">
  <div class="modal-dialog modal-lg modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header" style="background-color:#7f7f7f;">
        <h4 class="modal-title">Share Post</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body"  style="background-color:#7f7f7f;">
        <?= $this->Form->create(null, ['url' => ['controller' => 'Posts','action' => 'share']]) ?>
        <?= $this->Form->control ('post',['type' => 'textarea', 'rows'=>3, 'class' => 'form-control mt-2','label' => false, 'style'=>'min-width: 100%; background-color:#999999;color:white;', 'required'=>true, 'placeholder'=>'WRITE A POST']) ?>
        <div class="row justify-content-md-center mt-3 card p-3" style="background-color:#999999;color:white;">
          <div class="col-md-12">
            <table style="width:100%;">
              <tr>
                <td style=" width:42px;" rowspan="2" class="p-2"> <?= $this->Html->image('upload/icon.png', array('alt' => 'Microblog', 'border' => '1', 'width'=>'40px', 'id'=>'sprofile')); ?> </td>
                <td>
                  <span id="sname"> Allan  </span>
                </td>
              </tr>
              <tr>
                <td> <sup id="sdate"> date </sup></td>
              </tr>
            </table>
          </div>
          <div class="col-md-12">
            <p style="text-align: justify;" id="spost" >Test Post with Image</p>
            <span>
              <center>
                 <?= $this->Html->image('upload/logo.png', array('alt' => 'Microblog', 'border' => '1', 'class'=> 'img-fluid d-none', 'id'=>'simage')); ?>
              </center>
            </span>
          </div>
          </div>
        <div class="row p-2" style="background-color:#7f7f7f;">
          <div class="col-6">
            <?= $this->Form->control('user_id',['type'=>'hidden', 'value'=>h($this->Identity->get('id'))]) ?>
            <?= $this->Form->control('post_id',['type'=>'hidden', 'id'=>'post_id']) ?>
            <button type="submit" class="form-control btn btn-secondary">SHARE POST</button>
          </div>
          <div class="col-6">
            <span class="form-control btn btn-secondary" data-bs-dismiss="modal">CANCEL</span>
          </div>
        </div>
        <?= $this->Form->end()?>
      </div>
      </div>
    </div>
    </div>
