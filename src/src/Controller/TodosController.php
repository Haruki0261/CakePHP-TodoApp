<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\TagsTable;
use App\Model\Table\TodoTagsTable;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Todos Controller
 *
 * @property \App\Model\Table\TodosTable $Todos
 */
class TodosController extends AppController
{
    private TagsTable $Tags;
    private TodoTagsTable $TodoTags;

    public function initialize(): void
    {
        parent::initialize();
        $this->Tags = $this->fetchTable('Tags');
        $this->TodoTags = $this->fetchTable('TodoTags');
    }

    public function index()
    {
        $todos = $this->Todos->find()->contain(['Tags'])->orderByDesc('created');
        $tags = $this->Tags->find()->orderByDesc('created')->toArray();

        $this->set(compact('todos', 'tags'));
    }

    public function create()
    {
        if ($this->request->is('post')) {
            $todo = $this->Todos->createTodo($this->request->getData());
            $tags = $this->request->getData('tags');

            foreach($tags as $tag) {
                $this->TodoTags->createTodoTag((int)$todo->id, (int)$tag);
            }

            $this->Flash->success(__('Todo has been saved.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function edit($id = null)
    {
        $todo = $this->Todos->get($id);

        $this->set(compact('todo'));
    }

    public function view($id = null)
    {
        $todo = $this->Todos->get($id, ['contain' => ['Tags']]);

        $this->set(compact('todo'));
    }

    public function update($id = null)
    {
        $this->request->allowMethod(['post']);

        $todo = $this->Todos->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $todo = $this->Todos->patchEntity($todo, $this->request->getData());

            if ($this->Todos->save($todo)) {
                $this->Flash->success(__('Todo has been updated.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Unable to update the todo.'));
        }

        $this->set(compact('todo'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $todo = $this->Todos->get($id);

        if ($this->Todos->deleteTodo($todo['id'])) {
            $this->Flash->success(__('Todo has been deleted.'));

        } else {
            $this->Flash->error(__('Unable to delete the todo.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Toggle completed flag for one todo (POST). Flash + redirect to index.
     *
     * @param string|int|null $id Todo id from route
     * @return \Cake\Http\Response|null
     */
    public function toggleComplete($id = null)
    {
        $this->request->allowMethod(['post', 'patch']);

        $id = $this->request->getParam('id') ?? $id;
        if ($id === null || $id === '' || !ctype_digit((string)$id)) {
            $this->Flash->error((string)__('Invalid todo id.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $todo = $this->Todos->toggleCompleted((int)$id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error((string)__('Todo not found.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($todo === false) {
            $this->Flash->error((string)__('Unable to update the todo.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->success((string)__('Todo has been updated.'));

        return $this->redirect(['action' => 'index']);
    }

}
