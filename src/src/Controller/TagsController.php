<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\TagsService;

/**
 * Tags Controller
 *
 * @property \App\Model\Table\TagsTable $Tags
 */
class TagsController extends AppController
{
    private TagsService $tagsService;

    public function initialize(): void
    {
        parent::initialize();
        $this->Tags = $this->fetchTable('Tags');
        $this->tagsService = new TagsService($this->Tags);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Tags->find();
        $tags = $this->paginate($query);

        $this->set(compact('tags'));
    }

    /**
     * Tag 検索クエリを Todos の index に引き渡す。
     *
     * @return \Cake\Http\Response|null
     */
    public function search()
    {
        $tag = $this->request->getQuery('Tag');
        if (is_string($tag) && $tag !== '') {
            return $this->redirect([
                'controller' => 'Todos',
                'action' => 'index',
                '?' => ['Tag' => $tag],
            ]);
        }

        return $this->redirect(['controller' => 'Todos', 'action' => 'index']);
    }

    /**
     * 名前の部分一致でタグ候補を JSON で返す（補完 API 用）。
     *
     * @return \Cake\Http\Response|null|void
     */
    public function searchByKeyword()
    {
        $queryParams = $this->request->getQuery('query');

        if (!is_string($queryParams) || $queryParams === '') {
            $tags = [];
        } else {
            $tags = array_map(
                static fn ($tag) => ['id' => $tag->id, 'name' => $tag->name],
                $this->tagsService->getTagsByName($queryParams)
            );
        }

        $this->set(compact('tags'));
        $this->viewBuilder()
            ->setClassName('Json')
            ->setOption('serialize', ['tags']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tag = $this->Tags->newEmptyEntity();
        if ($this->request->is('post')) {
            $tag = $this->Tags->newEntity($this->request->getData());
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag could not be saved. Please, try again.'));
        }
        $this->set(compact('tag'));
    }

    /**
     * 編集メソッド
     *
     * @param int $id Tag id.
     *
     * @return \Cake\Http\Response|void
     */
    public function edit(int $id)
    {
        $tag = $this->Tags->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tag = $this->Tags->patchEntity($tag, $this->request->getData());
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag could not be saved. Please, try again.'));
        }
        $this->set(compact('tag'));
    }

    /**
     * 削除メソッド
     *
     * @param int $id Tag id.
     *
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        if ($this->Tags->delete($tag)) {
            $this->Flash->success(__('The tag has been deleted.'));
        } else {
            $this->Flash->error(__('The tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
