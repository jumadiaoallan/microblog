<style media="screen">
  .error-message {
    color: red;
    font-size: 12px;
  }
</style>
<div class="row justify-content-md-center justify-content-sm-center card mb-2 p-3"  style="background-color:#999999;color:white;">
  <center>
  <?php echo $this->Html->image('logo.PNG', ['alt' => 'Microblog', 'border' => '1', 'width' => '250px', 'class' => 'mb-2']); ?>
  </center>
            <?= $this->Form->create($user) ?>

                <div class="col-md-12 col-sm-12">
                  <?= $this->Form->control('full_name', ['class' => 'form-control mt-2' ,'style' => 'background-color:#999999;color:white;'])?>
                </div>
                <div class="col-md-12 col-sm-12">
                  <?= $this->Form->control('age', ['class' => 'form-control mt-2','style' => 'background-color:#999999;color:white;'])?>
                </div>
                <div class="col-md-12 col-sm-12">
                  <label for="gender">Gender</label>
                  <?= $this->Form->select(
                      'gender',
                      ['Male', 'Female'],
                      ['class' => 'form-control mt-2','style' => 'background-color:#999999;color:white;']
                  )?>
                </div>
                <div class="col-md-12 col-sm-12">
                  <?= $this->Form->control('username', ['class' => 'form-control mt-2','style' => 'background-color:#999999;color:white;'])?>
                </div>
                <div class="col-md-12 col-sm-12">
                  <?= $this->Form->control('email', ['class' => 'form-control mt-2','style' => 'background-color:#999999;color:white;'])?>
                </div>
                <div class="col-md-12 col-sm-12">
                  <?= $this->Form->control('password', ['class' => 'form-control mt-2','style' => 'background-color:#999999;color:white;'])?>
                </div>
                <div class="col-md-12 col-sm-12">
                  <?= $this->Form->control('confirm_password', ['type' => 'password', 'class' => 'form-control mt-2','style' => 'background-color:#999999;color:white;'])?>
                </div>
                <div class="row  mt-2">
                  <div class="col-md-6 col-sm-6">
                    <?= $this->Form->button(__('Submit'), ['class' => 'form-control btn btn-secondary btn-md']) ?>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <?= $this->Html->link('Already member?', '/users/login', ['class' => 'form-control btn btn-secondary']); ?>
                  </div>
                </div>


            <?= $this->Form->end() ?>
</div>
