
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
            <?= $this->Form->create($user, ['novalidate' => true]) ?>
            <fieldset>
                <?php
                    echo $this->Form->control('full_name', ['class' => 'form-control mt-2',
                    'style' => 'background-color:#999999;color:white;',
                    'required' => false,
                    'maxlength' => false ]);
                    echo $this->Form->control('username', ['class' => 'form-control mt-2',
                    'style' => 'background-color:#999999;color:white;',
                    'required' => false,
                    'maxlength' => false ]);
                    echo $this->Form->control('birthday', ['class' => 'form-control mt-2',
                    'style' => 'background-color:#999999;color:white;',
                    'required' => false,
                    'maxlength' => false ]);
                    $now = Cake\I18n\FrozenTime::parse(date('Y-m-d'));
                    $age = date_diff($user->birthday, $now);
                    echo '<label for="age">Age</label>';
                    echo '<input type = "number" value=' . $age->format('%r%y') . ' readonly class = "form-control" style = "background-color:#999999;color:white;">';
                    echo $this->Form->control('gender', [
                          'type' => 'select',
                          'options' => [
                               'Select' => ['Male', 'Female'],
                          ],
                          'class' => 'form-control',
                          'style' => 'background-color:#999999;color:white;',
                          'required' => false,
                          'maxlength' => false,
                      ]);
                    echo $this->Form->control('email', ['class' => 'form-control mt-2',
                          'readonly' => true,
                          'style' => 'background-color:#999999;color:white;',
                          'required' => false,
                          'maxlength' => false ]);
                    echo $this->Form->control('password', ['class' => 'form-control mt-2',
                         'value' => '',
                         'style' => 'background-color:#999999;color:white;',
                         'required' => false,
                         'maxlength' => false ]);
                    echo $this->Form->control('confirm_password', ['type' => 'password','class' => 'form-control mt-2',
                         'style' => 'background-color:#999999;color:white;',
                         'required' => false,
                         'maxlength' => false ]);
                    ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'form-control btn btn-secondary mt-2']) ?>
            <?= $this->Form->end() ?>

    </div>
</div>
