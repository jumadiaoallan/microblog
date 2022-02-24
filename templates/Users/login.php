
  <div class="row justify-content-md-center">
    <div class="col-6 card p-3" style="background-color:#999999;color:white;">
          <center>
          <?php echo $this->Html->image('logo.PNG', ['alt' => 'Microblog', 'border' => '1', 'width' => '250px', 'class' => 'mb-2']); ?>
          </center>
          <?= $this->Form->create($user, ['url' => ['controller' => 'Users','action' => 'login'], 'novalidate' => true]) ?>
          <fieldset>
              <?= $this->Form->control('email', ['class' => 'form-control','style' => 'background-color:#999999;color:white;', 'required' => false, 'maxlength' => false]) ?>
              <?= $this->Form->control('password', ['class' => 'form-control','style' => 'background-color:#999999;color:white;', 'required' => false]) ?>
          </fieldset>
          <div class="row mt-2">
            <div class="col-6">
              <?= $this->Form->button(__('Login'), ['class' => 'form-control btn btn-secondary btn-md']); ?>
            </div>
            <div class="col-6">
              <?= $this->Html->link(
                  'Register',
                  '/users/add',
                  ['class' => 'form-control btn btn-secondary']
              ); ?>
            </div>
          </div>
          <?= $this->Form->end() ?>
    </div>
  </div>
