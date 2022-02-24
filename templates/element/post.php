<style media="screen">
   .error-massage {
     color: red;
     font-size: 12px;
   }
</style>

<div class="col-md-12">
  <?= $this->Form->create($post, ['url' => ['controller' => 'Posts','action' => 'add'], 'type' => 'file', 'novalidate' => true]) ?>
  <?= $this->Form->control('post', ['type' => 'textarea', 'rows' => 3, 'class' => 'form-control mt-2','label' => false,
   'style' => 'min-width: 100%; background-color:#999999;color:white;',
   'placeholder' => 'WRITE A POST',
   'required' => false,
   'maxlength' => false,
  ]) ?>
</div>
<div class="row p-2">
  <div class="col-md-12 post_photo d-none" id="preview_content">
    <img src="" class="img-fluid mt-2" id="preview" />
  </div>
  <?php if (!empty($this->Flash->render('invalid'))) : ?>
    <div class="col-md-12 error-massage">
      Invalid Image Format
    </div>
  <?php endif; ?>
  <?php if (!empty($this->Flash->render('large-image'))) : ?>
    <div class="col-md-12 error-massage">
      Image should only below 5MB.
    </div>
  <?php endif; ?>
  <?php if (!empty($this->Flash->render('empty-post'))) : ?>
    <div class="col-md-12 error-massage">
      This post field cannot be left empty.
    </div>
  <?php endif; ?>
  <div class="col-md-6 mt-1">
    <?= $this->Form->control('image_post', ['type' => 'file','class' => 'form-control mt-2 d-none', 'id' => 'upload', 'label' => false]) ?>
    <label for="upload" class="form-control btn btn-secondary btn-sm btn-block mt-1">ADD IMAGE</label>
  </div>
  <div class="col-md-6 mt-1">
    <?= $this->Form->button(__('MAKE A POST'), ['class' => 'form-control btn btn-secondary btn-sm mt-1']) ?>
  </div>
  <?= $this->Form->end() ?>
</div>

<script type="text/javascript">
$( document ).ready(function() {

  upload.onchange = evt => {
    $("#preview_content").removeClass("d-none");
    const [file] = upload.files
      if (file) {
        preview.src = URL.createObjectURL(file)
      }
    }

  });
</script>
