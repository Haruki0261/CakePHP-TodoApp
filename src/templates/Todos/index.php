<!DOCTYPE html>
<html>
<head>
    <title>Todo App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->Html->css('todos-index') ?>
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
                <div class="tag-search-field">
                    <div class="tag-search-row">
                        <input
                            type="text"
                            class="tag-search-input"
                            id="tag-search-input"
                            autocomplete="off"
                            placeholder="タグを入力（2文字以上）"
                            aria-label="タグ入力"
                        >
                        <button
                            type="button"
                            class="tag-search-submit"
                            id="tag-search-button"
                            aria-label="タグを検索"
                        >
                            検索
                        </button>
                    </div>
                    <p class="tag-search-status" id="tag-search-status" role="status" aria-live="polite"></p>
                </div>
                <div class="tag-selector" id="tag-selector">
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
    <?php
    $tagSearchUrl = $this->Url->build(['controller' => 'Tags', 'action' => 'searchByKeyword']);
    ?>
    <script>
    /**
     * Todo 一覧のタグ検索 UI を初期化する。
     * キーワードでタグを API 検索し、#tag-selector 内のチェックボックス一覧を差し替える。
     * 検索実行時点で選択されていたタグは、検索結果に含まれる場合のみ選択状態を維持する。
     */
    (function () {
        const tagSearchApiUrl = <?= json_encode($tagSearchUrl, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
        const searchInput = document.getElementById('tag-search-input');
        const searchButton = document.getElementById('tag-search-button');
        const statusElement = document.getElementById('tag-search-status');
        const tagSelector = document.getElementById('tag-selector');
        if (!searchInput || !searchButton || !tagSelector) {
            return;
        }

        /**
         * 現在オンになっているタグ用チェックボックスの値を、ルックアップ用オブジェクトに集める。
         * 検索後に DOM を再描画するとき、どの ID をチェックし直すか判断するために使う。
         *
         * @returns {Object<string, boolean>} タグ ID（文字列）をキーに、選択中なら true
         */
        function getCheckedTagIdLookup() {
            const checkedTagIdLookup = {};
            tagSelector.querySelectorAll('input[name="tags[]"]:checked').forEach(function (checkbox) {
                checkedTagIdLookup[checkbox.value] = true;
            });
            return checkedTagIdLookup;
        }

        /**
         * 渡されたタグ配列を、#tag-selector 内にチェックボックス付きラベルとして描画する。
         * 描画前にコンテナを空にするため、既存の選択 UI はすべて置き換わる。
         *
         * @param {Array<{id: number|string, name: string}>} tags 表示するタグ
         * @param {Object<string, boolean>} checkedTagIdLookup ここにキーがある ID のチェックボックスは checked にする
         */
        function renderTagCheckboxes(tags, checkedTagIdLookup) {
            tagSelector.innerHTML = '';
            tags.forEach(function (tag) {
                const tagId = String(tag.id);
                const label = document.createElement('label');
                label.className = 'tag-button';
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'tags[]';
                checkbox.value = tagId;
                checkbox.style.display = 'none';
                if (checkedTagIdLookup[tagId]) {
                    checkbox.checked = true;
                }
                const nameSpan = document.createElement('span');
                nameSpan.className = 'tag-label';
                nameSpan.textContent = tag.name;
                label.appendChild(checkbox);
                label.appendChild(nameSpan);
                tagSelector.appendChild(label);
            });
        }

        /**
         * 検索の進捗・結果メッセージをステータス要素に表示する。要素が無い場合は何もしない。
         *
         * @param {string} [message] 表示する文言。省略または空ならメッセージを消す
         */
        function setStatusMessage(message) {
            if (statusElement) {
                statusElement.textContent = message || '';
            }
        }

        /**
         * 検索ボタン押下: 入力が 2 文字未満ならバリデーション表示。それ以外はタグ検索 API を呼び、
         * 返却されたタグ一覧でチェックボックスを再描画する。通信中はボタンを無効化する。
         */
        searchButton.addEventListener('click', function () {
            const query = (searchInput.value || '').trim();
            setStatusMessage('');
            if (query.length < 2) {
                setStatusMessage('検索するには2文字以上入力してください。');
                return;
            }
            
            const checkedTagIdLookup = getCheckedTagIdLookup();
            setStatusMessage('検索中…');
            searchButton.disabled = true;
            const querySeparator = tagSearchApiUrl.indexOf('?') >= 0 ? '&' : '?';
            const searchRequestUrl = tagSearchApiUrl + querySeparator + 'query=' + encodeURIComponent(query);
            fetch(searchRequestUrl, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                /**
                 * HTTP ステータスを確認し、成功時はレスポンス本文を JSON にパースした Promise を返す。
                 *
                 * @param {Response} response fetch の応答
                 */
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status);
                    }
                    return response.json();
                })
                /**
                 * API の JSON からタグ配列を取り出し、チェックボックス一覧を更新する。
                 * 件数に応じてステータス文言を切り替える。
                 *
                 * @param {Object} responseData パース済みのレスポンスオブジェクト（tags 配列を想定）
                 */
                .then(function (responseData) {
                    const foundTags = responseData.tags && Array.isArray(responseData.tags) ? responseData.tags : [];
                    renderTagCheckboxes(foundTags, checkedTagIdLookup);
                    if (foundTags.length === 0) {
                        setStatusMessage('該当するタグがありません。');
                    } else {
                        setStatusMessage(foundTags.length + ' 件のタグが見つかりました。');
                    }
                })
                /**
                 * ネットワークエラーや HTTP エラー時にユーザー向けメッセージを表示する。
                 */
                .catch(function () {
                    setStatusMessage('検索に失敗しました。もう一度お試しください。');
                })
                /**
                 * 成功・失敗に関わらず検索ボタンを再度有効にする。
                 */
                .finally(function () {
                    searchButton.disabled = false;
                });
        });

        /**
         * 検索入力で Enter を押したとき、フォーム送信ではなく検索ボタンと同じ動きにする。
         *
         * @param {KeyboardEvent} event
         */
        searchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                searchButton.click();
            }
        });

    })();
    </script>
</body>
</html>
