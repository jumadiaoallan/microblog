<?php $userID = h($this->Identity->get('id'))?>

<div class = "modal" id ="item-error">
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
            Please upload only jpg, jpeg or png.
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
        <?= $this->Form->create($post, ['id' => 'edit_form', 'type' => 'file']) ?>
         <?= $this->Form->control('post', ['type' => 'textarea',
            'id' => 'edit_post' ,
            'rows' => 3,
            'class' => 'form-control mt-2',
            'label' => false,
            'style' => 'min-width: 100%; background-color:#999999;color:white;',
            'required' => false,
            'maxlength' => false ]) ?>
        <div class="post_photo" id="edit_preview">
        <img src="" id="image_edit" class="img-fluid mt-2" />
      </div>
        <div class="row mt-2">
          <?= $this->Form->control('id', ['type' => 'hidden', 'id' => 'id']) ?>
          <?= $this->Form->control('image_post', ['type' => 'file','class' => 'form-control mt-2 d-none', 'id' => 'post_edit', 'label' => false]) ?>
          <?= $this->Form->control('remove_image', ['type' => 'hidden','class' => 'form-control mt-2', 'id' => 'remove_image', 'label' => false]) ?>
          <div class="col-md-12">
            <label for="post_edit" class="form-control btn btn-secondary btn-sm btn-block mt-1" id="btn">EDIT IMAGE</label>
          </div>
          <div class="col-md-12 d-none" id="btn_remove">
            <span class="form-control btn btn-secondary btn-sm btn-block mt-1" onclick="remove_image()">REMOVE IMAGE</span>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer"  style="background-color:#7f7f7f;">
        <?= $this->Form->button(__('Submit'), ['class' => 'form-control btn btn-secondary btn-md mt-2', 'id' => 'editPostSubmit']) ?>
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
        <?= $this->Form->create(null, ['id' => 'delete_form']) ?>
          <label>Are you sure want to delete this post?</label>
        <div class="row p-2" style="background-color:#7f7f7f;">
          <div class="col-6">
            <button type="submit" class="form-control btn btn-secondary" name="submit" data-bs-dismiss="modal" id="delete_post">Yes</button>
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
            <?= $this->Form->create(null, ['id' => 'comment_edit']) ?>
              <?= $this->Form->control('comment', ['type' => 'textarea', 'rows' => 3, 'class' => 'form-control mt-2','label' => false, 'style' => 'min-width: 100%; background-color:#999999;color:white;', 'id' => 'editC']) ?>
            <div class="row p-2" style="background-color:#7f7f7f;">
              <div class="col-6">
                <button type="submit" class="form-control btn btn-secondary" id="editcommentbtn">SAVE CHANGES</button>
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
          <!-- <form> -->
            <label>Are you sure want to delete this comment?</label>
          <div class="row p-2" style="background-color:#7f7f7f;">
            <div class="col-6">
              <input type="hidden" id="comment_ids" value="">
              <button type="submit" class="form-control btn btn-secondary" data-bs-dismiss="modal" onclick="deleteComment()">Yes</button>
            </div>
            <div class="col-6">
              <span class="form-control btn btn-secondary" data-bs-dismiss="modal">No</span>
            </div>
          </div>
          <!-- </form> -->
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
        <?= $this->Form->create(null, ['url' => ['controller' => 'Posts','action' => 'share'], 'novalidate' => true, 'id' => 'shareForm']) ?>
        <?= $this->Form->control('post', ['type' => 'textarea',
         'rows' => 3,
         'class' => 'form-control mt-2',
         'label' => false,
         'style' => 'min-width: 100%; background-color:#999999;color:white;',
         'placeholder' => 'WRITE A POST',
         'required' => false,
         'maxlength' => false ]) ?>
        <div class="row justify-content-md-center mt-3 card p-3" style="background-color:#999999;color:white;">
          <div class="col-md-12">
            <table style="width:100%;">
              <tr>
                <td style=" width:50px;" rowspan="2" class="p-2 post_profile">
                  <?= $this->Html->image('upload/icon.PNG', [ 'id' => 'sprofile']); ?>
                </td>
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
                 <?= $this->Html->image('upload/logo.PNG', ['border' => '1', 'class' => 'img-fluid d-none', 'id' => 'simage']); ?>
              </center>
            </span>
          </div>
          </div>
        <div class="row p-2" style="background-color:#7f7f7f;">
          <div class="col-6">
            <?= $this->Form->control('user_id', ['type' => 'hidden', 'value' => h($this->Identity->get('id'))]) ?>
            <?= $this->Form->control('post_id', ['type' => 'hidden', 'id' => 'post_id']) ?>
            <button type="submit" class="form-control btn btn-secondary" id="btnShare">SHARE POST</button>
          </div>
          <div class="col-6" id="btnShareCancel">
            <span class="form-control btn btn-secondary" data-bs-dismiss="modal">CANCEL</span>
          </div>
        </div>
        <?= $this->Form->end()?>
      </div>
      </div>
    </div>
    </div>

    <script type="text/javascript">


      $( document ).ready(function() {

          editPostSubmit.onclick = evt => {
              var btn_submit = $('#editPostSubmit');
              var loading = '<i class="fa fa-spinner fa-spin"></i>';
              btn_submit.html(loading);
              btn_submit.prop('disabled', true);
              $("#edit_form").submit();
            }

            editcommentbtn.onclick = evt => {
                var btn_submit = $('#editcommentbtn');
                var loading = '<i class="fa fa-spinner fa-spin"></i>';
                btn_submit.html(loading);
                btn_submit.prop('disabled', true);
                $("#comment_edit").submit();
              }

            btnShare.onclick = evt => {
                var btn_submit = $('#btnShare');
                var loading = '<i class="fa fa-spinner fa-spin"></i>';
                btn_submit.html(loading);
                btn_submit.prop('disabled', true);
                $("#shareForm").submit();
              }

        });

    </script>
