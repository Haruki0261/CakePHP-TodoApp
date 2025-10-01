<?php
declare(strict_types=1);

namespace App\Controller;

use DateTime;
use App\Model\Table\TodosTable;


/**
 * Todos Controller
 *
 */
class TodosController extends AppController
{
    protected $todos;

    public function initialize(): void
    {
        parent::initialize();
        $this->todos = $this->getTableLocator()->get('Todos');

    }

    public function index()
    {
        $todos = $this->Todos->find('all')->orderByDesc('created');
        $this->set(compact('todos'));
    }

    public function view($id = null)
    {
        $todo = $this->Todos->get($id);
        $this->set(compact('todo'));
    }

    public function create()
    {
        $this->request->allowMethod(['post']);

        if ($this->request->is('post')) {
            $todo = $this->Todos->createTodo($this->request->getData());

            if ($todo) {
                $this->Flash->success(__('Todo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Unable to add the todo.'));
        }
    }

    public function edit($id = null)
    {
        $todo = $this->Todos->get($id);

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
        $this->request->allowMethod(['delete']);

        $todo = $this->Todos->get($id);

        if ($this->Todos->delete($todo)) {
            $this->Flash->success(__('Todo has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__('Unable to delete the todo.'));
    }
}
