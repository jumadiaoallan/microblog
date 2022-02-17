<div class="row justify-content-md-center">
  <?= $this->element('post') ?>
</div>

<div class="row justify-content-md-center mt-3 card p-3" style="background-color:#999999;color:white;">
  <div class="col-md-12">
    <table>
      <tr>
        <td rowspan="2" class="p-2"><?= $this->Html->image('icon.PNG', array('alt' => 'Microblog', 'border' => '1', 'width'=>'40px')); ?></td>
        <td>John Doe</td>
      </tr>
      <tr>
        <td> <sup><?=  date('m-d-Y h:m'); ?></sup></td>
      </tr>
    </table>
  </div>
  <div class="col-md-12">
    <span class="text-red">Post Description: </span>
    <p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    <span>
      <?= $this->Html->image('logo.PNG', array('alt' => 'Microblog', 'border' => '1', 'width'=>'300px', 'class'=> 'img-fluid mx-auto d-block')); ?>
    </span>
  </div>
  <div class="col-md-12">
    <div class="row">
      <div class="col-sm-4 mt-2">
        <button type="button" name="button" class="form-control btn btn-sm btn-secondary">LIKE</button>
      </div>
      <div class="col-sm-4 mt-2">
        <button type="button" name="button" class="form-control btn btn-sm btn-secondary">COMMENT</button>
      </div>
      <div class="col-sm-4 mt-2">
        <button type="button" name="button" class="form-control btn btn-sm btn-secondary">SHARE</button>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="row justify-content-md-center mt-2 p-3 card"  style="background-color:#999999;color:white;">
      <div class="col-md-6">
        <table>
          <tr>
            <td rowspan="2" class="p-2"><?= $this->Html->image('icon.PNG', array('alt' => 'Microblog', 'border' => '1', 'width'=>'40px')); ?></td>
            <td>Juan Dela Cruz</td>
          </tr>
          <tr>
            <td> <sup><?=  date('m-d-Y h:m'); ?></sup></td>
          </tr>
        </table>
      </div>
      <div class="col-md-12">
          <p style="text-align: justify;" class="p-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          <hr>
      </div>
      <div class="row">
        <div class="col-md-2 offset-md-10">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="text-decoration-none">Edit</a>
          <a href="#" class="float-end text-decoration-none">Delete</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-md-center mt-2 p-2">
    <div class="col-md-12">
      <textarea name="name" rows="3" cols="150" class="form-control" style="min-width: 100%; background-color:#999999;color:white;" placeholder="WRITE A COMMENT"></textarea>
    </div>
    <div class="col-md-3 offset-md-9">
      <button type="button" class="form-control btn btn-secondary btn-sm mt-2" name="button">SUBMIT</button>
    </div>
  </div>


</div>







<!-- hi, <?= $username = $this->Identity->get('email') ?>
<div class="users index content">
    <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('username') ?></th>
                    <th><?= $this->Paginator->sort('full_name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('age') ?></th>
                    <th><?= $this->Paginator->sort('profile_path') ?></th>
                    <th><?= $this->Paginator->sort('banner_path') ?></th>
                    <th><?= $this->Paginator->sort('gender') ?></th>
                    <th><?= $this->Paginator->sort('verified') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->username) ?></td>
                    <td><?= h($user->full_name) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= $this->Number->format($user->age) ?></td>
                    <td><?= h($user->profile_path) ?></td>
                    <td><?= h($user->banner_path) ?></td>
                    <td><?= h($user->gender) ?></td>
                    <td><?= h($user->verified) ?></td>
                    <td><?= h($user->created) ?></td>
                    <td><?= h($user->modified) ?></td>
                    <td><?= h($user->deleted) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div> -->
