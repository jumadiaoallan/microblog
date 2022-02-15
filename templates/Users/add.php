<div class="row justify-content-md-center mb-2">
    <div class="col-12 card p-3" style="background-color:#999999;color:white;">
            <center>
            <?php echo $this->Html->image('logo.PNG', array('alt' => 'Microblog', 'border' => '1', 'width'=>'250px', 'class'=>'mb-2')); ?>
            </center>
            <?= $this->Form->create($user) ?>
            <fieldset>
                <?php
                    echo $this->Form->control('full_name', ['class' => 'form-control mt-2']);
                    echo $this->Form->control('age', ['class' => 'form-control mt-2']);
                    echo '<label for="gender">Gender</label>';
                    echo $this->Form->select(
                            'gender',
                            ['Male', 'Female'],
                            ['class' => 'form-control mt-2']
                        );
                    echo $this->Form->control('username', ['class' => 'form-control mt-2']);
                    echo $this->Form->control('email', ['class' => 'form-control mt-2']);
                    echo $this->Form->control('password', ['class' => 'form-control mt-2']);
                    echo $this->Form->control ('confirm_password',['type' => 'password', 'class' => 'form-control mt-2']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'form-control btn btn-secondary btn-md mt-2']) ?>
            <?= $this->Form->end() ?>
    </div>
</div>
