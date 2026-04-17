<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tag->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tag->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tags form content">
            <?= $this->Form->create($tag) ?>
            <div class="form-group">
                <?= $this->Form->control('name', ['label' => 'タグ名', 'required' => true]) ?>
                <?= $this->Form->control('color', ['label' => '色', 'required' => true, 'type' => 'color']) ?>
            </div>
            <?= $this->Form->button('更新', ['type' => 'submit']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
