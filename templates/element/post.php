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
  <div class="col-md-12 error-massage d-none" id="image-size">
    Image should only below 5MB.
  </div>
  <?php if (!empty($this->Flash->render('empty-post'))) : ?>
    <div class="col-md-12 error-massage">
      This post field cannot be left empty.
    </div>
  <?php endif; ?>
  <?php if (!empty($this->Flash->render('maxLength'))) : ?>
    <div class="col-md-12 error-massage">
      This post field is maximum 140 character only.
    </div>
  <?php endif; ?>
  <div class="col-md-6 mt-1">
    <?= $this->Form->control('image_post', ['type' => 'file','class' => 'form-control mt-2 d-none', 'id' => 'upload', 'label' => false]) ?>
    <label for="upload" class="form-control btn btn-secondary btn-sm btn-block mt-1" id="upload_btn">ADD IMAGE</label>
  </div>
  <div class="col-md-6 mt-1">
    <?= $this->Form->button(__('MAKE A POST'), ['class' => 'form-control btn btn-secondary btn-sm mt-1']) ?>
  </div>
  <?= $this->Form->end() ?>
</div>

<script type="text/javascript">
$( document ).ready(function() {

  upload.onchange = evt => {

    var fi = document.getElementById('upload');

    if (fi.files.length > 0) {
            var fsize = fi.files.item(0).size;
            var mb = Math.round((fsize * 0.000001));
            if (mb >= 5) {
              $("#image-size").removeClass("d-none");
              $("#upload").val("");
            } else {
              $("#preview_content").removeClass("d-none");
              const [file] = upload.files
                if (file) {
                  preview.src = URL.createObjectURL(file)
                }
            }
          }
    }

  });
</script>
