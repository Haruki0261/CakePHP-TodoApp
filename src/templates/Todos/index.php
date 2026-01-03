<!DOCTYPE html>
<html>
<head>
    <title>Todo App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .todo-form {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .todo-item {
            background: white;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .todo-item.completed {
            background: #e8f5e8;
            text-decoration: line-through;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        textarea {
            height: 80px;
            resize: vertical;
        }
        button {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .todo-title {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 5px;
        }
        .todo-content {
            color: #666;
            margin-bottom: 10px;
        }
        .todo-date {
            font-size: 0.9em;
            color: #999;
        }
        .todo-actions {
            margin-top: 10px;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9em;
            margin-right: 5px;
            display: inline-block;
        }
        .btn-edit {
            background: #28a745;
            color: white;
        }
        .btn-edit:hover {
            background: #1e7e34;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background: #c82333;
        }
        .tag-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .tag-button {
            display: inline-block;
            cursor: pointer;
            margin: 0;
        }
        .tag-label {
            background: #e0e0e0;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            transition: all 0.3s ease;
            user-select: none;
        }
        .tag-label:hover {
            background: #d0d0d0;
        }
        .tag-button input:checked + .tag-label {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Todo App</h1>

    <div class="todo-form">
        <h2>新しいTodoを追加</h2>
        <?= $this->Form->create(null, ['url' => ['action' => 'create']]) ?>
            <div class="form-group">
                <?= $this->Form->label('title', 'タイトル') ?>
                <?= $this->Form->text('title', ['required' => true]) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('tags', 'タグ') ?>
                <div class="tag-selector">
                    <?php foreach ($tags as $tag): ?>
                        <label class="tag-button">
                            <input type="checkbox" name="tags[]" value="<?= $tag['id'] ?>" style="display: none;">
                            <span class="tag-label"><?= h($tag['name']) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group">
                <?= $this->Form->label('content', '内容') ?>
                <?= $this->Form->textarea('content', ['required' => true]) ?>
            </div>

            <?= $this->Form->button('追加', ['type' => 'submit']) ?>
        <?= $this->Form->end() ?>
    </div>

    <div class="todos-list">
        <h2>Todo一覧</h2>
        <div>
            <a href="/tags/add">タグ追加</a>
        </div>
        <?php if (!empty($todos)): ?>
            <?php foreach ($todos as $todo): ?>
                <div class="todo-item <?= $todo->completed ? 'completed' : '' ?>">
                    <div class="todo-title">
                        <a href="/todos/view/<?= $todo->id ?>" style="color: inherit; text-decoration: none;">
                            <?= h($todo->title) ?>
                        </a>
                    </div>
                    <div class="todo-content"><?= h($todo->content) ?></div>
                    <div class="todo-date">作成日: <?= $todo->modified->format('Y-m-d H:i') ?></div>
                    <div class="todo-actions">
                        <a href="/todos/edit/<?= $todo->id ?>" class="btn btn-edit">編集</a>
                        <?= $this->Form->postLink('削除', ['action' => 'delete', $todo->id], ['class' => 'btn btn-delete']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>まだTodoが登録されていません。</p>
        <?php endif; ?>
    </div>
</body>
</html>
