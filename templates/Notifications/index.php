<div class="row justify-content-md-center p-2">
  <div class="col-md-12 card p-5" style="background-color:#999999;color:white;">
      <div class="row justify-content-md-center">
        <div class="col-md-4 text-center">
          <h3>Notifications</h3>
        </div>
      </div>
        <?php if ($notifications->count()) : ?>
            <?php foreach ($notifications as $noti) : ?>
            <div class="row">
              <div class="col-md-12 card p-2" style="background-color:#999999;color:white;">
                <?php if ($this->Identity->get('id') == $noti->user_id) : ?>
                    <?php foreach ($user as $users) : ?>
                        <?php if ($users->id == $noti->user_from) : ?>
                        <table>
                          <tr>
                            <td style="width:60px;height:60px" rowspan="2" class="follow_profile">
                              <?= $this->Html->image('upload/' . h($users->profile_path), ['alt' => 'Microblog', 'url' => ['controller' => 'Users', 'action' => 'profile', h($users->id)]])?>
                            </td>
                            <td>
                              <?= $this->Html->link(
                                  $users->full_name,
                                  ['controller' => 'Users', 'action' => 'profile', h($users->id)],
                                  ['style' => 'color:inherit;text-decoration:none;']
                              ); ?>
                              <?php $split = explode('.', h($noti->notification)) ?>
                                <?php if ($split[0] == 'Followed you') : ?>
                                    <?= $this->Html->link(
                                        h($split[0]) . ' at ' . date('m-d-Y h:i A', strtotime(h($noti->created))),
                                        ['controller' => 'Users', 'action' => 'profile', h($users->id)],
                                        ['style' => 'color:inherit;text-decoration:none;']
                                    ); ?>
                                <?php else : ?>
                                      <?= $this->Html->link(
                                          h($split[0]) . ' at ' . date('m-d-Y h:i A', strtotime(h($noti->created))),
                                          ['controller' => 'Posts', 'action' => 'view', h($split[1])],
                                          ['style' => 'color:inherit;text-decoration:none;']
                                      ); ?>
                                <?php endif; ?>
                            </td>
                          </tr>
                        </table>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
            <hr>
            <?php endforeach; ?>
        <?php else : ?>
            <div class=" justify-content-md-center mt-3 card p-3"  style="background-color:#999999;color:white;">
              <div class="col-md-12 text-center">
                No Latest Notifications
              </div>
            </div>
        <?php endif; ?>


  </div>
    <?= $this->element('pagination') ?>
</div>
