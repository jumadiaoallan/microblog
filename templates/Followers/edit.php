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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $follower->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $follower->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Followers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="followers form content">
            <?= $this->Form->create($follower) ?>
            <fieldset>
                <legend><?= __('Edit Follower') ?></legend>
                <?php
                    echo $this->Form->control('following_user');
                    echo $this->Form->control('follower_user');
                    echo $this->Form->control('deleted', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
