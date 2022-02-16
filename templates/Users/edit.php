
<style media="screen">
  .error-message {
    color: red;
    font-size: 12px;
  }
</style>
<div class="row justify-content-md-center p-3">
    <div class="col-md-10 card p-3" style="background-color:#999999;color:white;">
      <?php echo $this->Flash->render(); ?>
          <h2 class="text-center">Edit Profile</h1>
            <?= $this->Form->create($user) ?>
            <fieldset>
                <?php
                    echo $this->Form->control('full_name', ['class' => 'form-control mt-2']);
                    echo $this->Form->control('username', ['class' => 'form-control mt-2']);
                    echo $this->Form->control('age', ['class' => 'form-control mt-2']);
                    echo '<label for="gender">Gender</label>';
                    echo $this->Form->select('gender',['Male', 'Female'],['class' => 'form-control mt-2']);
                    echo $this->Form->control('email', ['class' => 'form-control mt-2']);
                    echo $this->Form->control('password', ['class' => 'form-control mt-2', 'value'=>'', 'required' => false]);
                    echo $this->Form->control('confirm_password', ['type'=>'password','class' => 'form-control mt-2','required' => false]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'form-control btn btn-secondary mt-2']) ?>
            <?= $this->Form->end() ?>

    </div>
</div>
