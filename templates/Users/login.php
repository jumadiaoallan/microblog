
  <div class="row justify-content-md-center">
    <div class="col-6 card p-3" style="background-color:#999999;color:white;">
          <center>
          <?php echo $this->Html->image('logo.PNG', ['alt' => 'Microblog', 'border' => '1', 'width' => '250px', 'class' => 'mb-2']); ?>
          </center>
          <?= $this->Form->create($user, ['url' => ['controller' => 'Users','action' => 'login'], 'novalidate' => true, 'id' => 'loginForm']) ?>
          <fieldset>
              <?= $this->Form->control('email', ['class' => 'form-control','style' => 'background-color:#999999;color:white;', 'required' => false, 'maxlength' => false]) ?>
              <?= $this->Form->control('password', ['class' => 'form-control','style' => 'background-color:#999999;color:white;', 'required' => false]) ?>
          </fieldset>
          <div class="row mt-2">
            <div class="col-6">
              <?= $this->Form->button(__('Login'), ['class' => 'form-control btn btn-secondary btn-md', 'id' => 'login']); ?>
            </div>
            <div class="col-6">
              <?= $this->Html->link(
                  'Register',
                  '/users/add',
                  ['class' => 'form-control btn btn-secondary', 'id' => 'register']
              ); ?>
            </div>
          </div>
          <?= $this->Form->end() ?>
    </div>
  </div>
<script type="text/javascript">

  $( document ).ready(function() {

  register.onclick = evt => {
      var btn_submit = $('#register');
      var loading = '<i class="fa fa-spinner fa-spin"></i>';
      btn_submit.html(loading);
    }

  login.onclick = evt => {
      var btn_submit = $('#login');
      var loading = '<i class="fa fa-spinner fa-spin"></i>';
      btn_submit.html(loading);
      btn_submit.prop('disabled', true);
      $("#loginForm").submit();
    }

  });

</script>
