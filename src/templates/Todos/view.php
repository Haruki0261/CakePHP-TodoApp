<!DOCTYPE html>
<html>
<head>
    <title>Todo詳細 - Todo App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->Html->css('todos-view') ?>
</head>
<body>
    <a href="/todos" class="back-link">一覧に戻る</a>
    <h1>Todo詳細</h1>
    <div class="todo-detail <?= $todo->completed ? 'completed' : '' ?>">
        <div class="todo-title"><?= h($todo->title) ?></div>
        <div class="todo-content"><?= h($todo->content) ?></div>

        <div class="todo-tags">
            <strong>タグ:</strong>
            <?php foreach ($todo->tags as $tag): ?>
                <span class="tag"><?= h($tag->name) ?></span>
            <?php endforeach; ?>
        </div>

        <div class="todo-meta">
            <div class="meta-item">
                <strong>ステータス:</strong>
                <span class="status <?= $todo->completed ? 'completed' : 'pending' ?>">
                    <?= $todo->completed ? '完了' : '未完了' ?>
                </span>
            </div>
            <div class="meta-item">
                <strong>作成日:</strong> <?= $todo->created->format('Y年m月d日 H:i') ?>
            </div>
            <div class="meta-item">
                <strong>更新日:</strong> <?= $todo->modified->format('Y年m月d日 H:i') ?>
            </div>
        </div>

        <div class="action-buttons">
            <a href="/todos/edit/<?= $todo->id ?>" class="btn btn-edit">編集</a>
        </div>
    </div>
</body>
</html>
