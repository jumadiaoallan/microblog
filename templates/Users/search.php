<div class="row justify-content-md-center">
  <div class="col-md-12 card p-2"  style="background-color:#999999;color:white;">
    <?php
        $div = '';

        $count = 0;
    if ($result->count() != 0) {
        foreach ($result as $f) {
            if ($count % 2 == 0) {
                $div .= '<div class="row p-3"><div class="row">' . "\n";
            }
                  $div .= '<div class="col-sm-6">';

                  $div .= '<table>';
                  $div .= '<tr>';
                  $div .= '<td>' . $this->Html->image('upload/' . h($f->profile_path), ['alt' => 'Microblog', 'width' => '60px', 'url' => ['controller' => 'Users', 'action' => 'profile', h($f->id)]]) . '</td>';
                  $div .= '<td>' . $this->Html->link(
                      h($f->full_name),
                      ['controller' => 'Users', 'action' => 'profile', h($f->id)],
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

        if ($count % 2 != 0) {
            $div .= '</div></div>';
        }
    } else {
        $div .= '<div class=" justify-content-md-center mt-3 card p-3"  style="background-color:#999999;color:white;">
                      <div class="col-md-12 text-center">
                          No Result
                          </div>
                    </div>';
    }

        echo $div;
    ?>

</div>
<?= $this->element('pagination') ?>
