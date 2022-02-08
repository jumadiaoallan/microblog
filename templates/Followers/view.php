<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Follower $follower
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Follower'), ['action' => 'edit', $follower->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Follower'), ['action' => 'delete', $follower->id], ['confirm' => __('Are you sure you want to delete # {0}?', $follower->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Followers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Follower'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="followers view content">
            <h3><?= h($follower->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($follower->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Following User') ?></th>
                    <td><?= $this->Number->format($follower->following_user) ?></td>
                </tr>
                <tr>
                    <th><?= __('Follower User') ?></th>
                    <td><?= $this->Number->format($follower->follower_user) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($follower->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($follower->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($follower->deleted) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
