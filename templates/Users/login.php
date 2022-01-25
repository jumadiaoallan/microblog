  <div class="row justify-content-md-center">
    <div class="col-6 card p-3">
          <center>
          <?php echo $this->Html->image('logo.png', array('alt' => 'Microblog', 'border' => '1', 'width'=>'250px', 'class'=>'mb-2')); ?>
          </center>
          <?= $this->Form->create() ?>
          <fieldset>
              <?= $this->Form->control('email', ['class' => 'form-control']) ?>
              <?= $this->Form->control('password', ['class' => 'form-control']) ?>
          </fieldset>
          <?= $this->Form->button(__('Login'), ['class' => 'form-control btn btn-primary btn-md btn-block mt-2']); ?>
          <?= $this->Form->end() ?>
    </div>
  </div>
