<div class="col-md-12">
  <?= $this->Form->create(null, ['url' => ['controller' => 'Posts','action' => 'add'], 'type'=> 'file']) ?>
  <?= $this->Form->control ('post',['type' => 'textarea', 'rows'=>3, 'class' => 'form-control mt-2','label' => false, 'style'=>'min-width: 100%; background-color:#999999;color:white;', 'placeholder'=>'WRITE A POST']) ?>
</div>
<div class="row p-2">
  <div class="col-md-12">
    <img src="" class="img-fluid mt-2 d-none" id="preview" />
  </div>
  <div class="col-md-6 mt-1">
    <?= $this->Form->control ('image_post',['type' => 'file','class' => 'form-control mt-2 d-none', 'id'=>'upload', 'label'=>false]) ?>
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
    $("#preview").removeClass("d-none");
    const [file] = upload.files
      if (file) {
        preview.src = URL.createObjectURL(file)
      }
    }

  });
</script>
