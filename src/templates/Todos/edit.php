<!DOCTYPE html>
<html>
<head>
    <title>Todo編集 - Todo App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-container {
            background: white;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        textarea {
            height: 120px;
            resize: vertical;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        input[type="checkbox"] {
            width: auto;
            transform: scale(1.2);
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #545b62;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 0.9em;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .back-link:before {
            content: "← ";
        }
        .actions {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <a href="/todos" class="back-link">一覧に戻る</a>

    <h1>Todo編集</h1>

    <div class="form-container">
        <?= $this->Form->create($todo, ['url' => ['action' => 'update', $todo->id]]) ?>

        <div class="form-group">
            <?= $this->Form->control('title', [
                'label' => 'タイトル',
                'class' => 'form-control',
                'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->control('content', [
                'type' => 'textarea',
                'label' => '内容',
                'class' => 'form-control'
            ]) ?>
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <?= $this->Form->control('completed', [
                    'type' => 'checkbox',
                    'label' => '完了済み'
                ]) ?>
            </div>
        </div>

        <div class="actions">
            <?= $this->Form->button('更新', ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
            <?= $this->Html->link('キャンセル', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</body>
</html>