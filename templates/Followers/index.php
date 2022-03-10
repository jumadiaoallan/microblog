<div class="row justify-content-md-center p-3" style="background-color:#999999;color:white;">
  <div class="col-md-12 card">
    <?php
    $fields = $following->toArray();
        $div = '';

        $count = 0;
    foreach ($fields as $f) {
        foreach ($user as $followed_user) {
            if ($_GET['type'] == 'follower') {
                if ($f['follower_user'] == $followed_user->id) {
                    if ($count % 2 == 0) {
                        $div .= '<div class="row p-3" style="background-color:#999999;color:white;"><div class="row">' . "\n";
                    }
                    $div .= '<div class="col-sm-6">';

                    $div .= '<table>';
                    $div .= '<tr>';
                    $div .= '<td class="follow_profile" style="width:60px;height:60px;">' . $this->Html->image('upload/' . $followed_user->profile_path, ['alt' => 'Microblog', 'url' => ['controller' => 'Users', 'action' => 'profile', $followed_user->id]]) . '</td>';
                    $div .= '<td>' . $this->Html->link(
                        h($followed_user->first_name) . " " . h($followed_user->last_name),
                        ['controller' => 'Users', 'action' => 'profile', $followed_user->id],
                        ['style' => 'color:inherit;text-decoration:none;']
                    ) . '</td>';
                    $div .= '</table>';
                    $div .= '<hr>';

                    $div .= '</div>' . "\n";

                    if ($count % 2 != 0) {
                        $div .= '</div></div>';
                    }

                    $count++;
                }
            } else {
                if ($f['following_user'] == $followed_user->id) {
                    if ($count % 2 == 0) {
                        $div .= '<div class="row p-3" style="background-color:#999999;color:white;"><div class="row">' . "\n";
                    }
                    $div .= '<div class="col-sm-6">';

                    $div .= '<table>';
                    $div .= '<tr>';
                    $div .= '<td class="follow_profile p-1" style="width:60px;height:60px;">' . $this->Html->image('upload/' . $followed_user->profile_path, ['alt' => 'Microblog', 'url' => ['controller' => 'Users', 'action' => 'profile', $followed_user->id]]) . '</td>';
                    $div .= '<td> &nbsp;' . $this->Html->link(
                        h($followed_user->first_name) . " " . h($followed_user->last_name),
                        ['controller' => 'Users', 'action' => 'profile', $followed_user->id],
                        ['style' => 'color:inherit;text-decoration:none;']
                    ) . '</td>';
                    $div .= '</table>';
                    $div .= '<hr>';

                    $div .= '</div>' . "\n";

                    if ($count % 2 != 0) {
                        $div .= '</div></div>';
                    }

                    $count++;
                }
            }
        }
    }

    if ($count % 2 != 0) {
        // close last DIV if an odd number of fields
        $div .= '</div></div>';
    }
        echo $div;

    ?>

  </div>
    <div class="row">
      <div class="col-md-2 offset-10">
        <span class="float-end"><?= $this->Paginator->params()['current'];?> out of <?= $this->Paginator->params()['count'];?></span>
      </div>
    </div>
</div>
<nav aria-label="pagination" class="float-end mt-3">
  <ul class="pagination">
    <?= $this->Paginator->prev('<<')?>
    <?= !$this->Paginator->numbers() ? '<li class="page-item"><a href="#" class="page-link">1</a></li>' : $this->Paginator->numbers() ?>
    <?= $this->Paginator->next('>>')?>
  </ul>
</nav>
