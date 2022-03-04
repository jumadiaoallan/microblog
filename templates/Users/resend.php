<div class="row justify-content-md-center">
  <div class="col-6 card p-3" style="background-color:#999999;color:white;">
        <center>
        <?php echo $this->Html->image('logo.PNG', ['alt' => 'Microblog', 'border' => '1', 'width' => '250px', 'class' => 'mb-2']); ?>
        </center>
        <?= $this->Form->create($find, ['url' => ['controller' => 'Users','action' => 'resend'], 'novalidate' => true, 'id' => 'resendForm']) ?>
        <fieldset>
            <?= $this->Form->control('email', ['class' => 'form-control',
            'style' => 'background-color:#999999;color:white;',
            'required' => false,
            'maxlength' => false,
            'value' => !empty($_SESSION['email']) ? $_SESSION['email'] : null ]) ?>
            <?php if (!empty($this->Flash->render('empty-email'))) : ?>
              <div class="col-md-12 text-danger" style="font-size:12px;">
                This field cannot be left empty
              </div>
            <?php endif; ?>
            <?php if (!empty($this->Flash->render('invalid-format'))) : ?>
              <div class="col-md-12 text-danger" style="font-size:12px;">
                The provided value is invalid
              </div>
            <?php endif; ?>
        </fieldset>
        <div class="row mt-2">
          <div class="col-12">
            <?= $this->Form->button(__('Resend Email Verification'), ['class' => 'form-control btn btn-secondary btn-md', 'id' => 'btnResend']); ?>
          </div>
        </div>
        <?= $this->Form->end() ?>
  </div>
</div>

<?php
  unset($_SESSION['email']);
 ?>
 <script type="text/javascript">
 $( document ).ready(function() {

   btnResend.onclick = evt => {
       var btn_submit = $('#btnResend');
       var loading = '<i class="fa fa-spinner fa-spin"></i>';
       btn_submit.html(loading);
       btn_submit.prop('disabled', true);
       $("#resendForm").submit();
     }


   });
 </script>
