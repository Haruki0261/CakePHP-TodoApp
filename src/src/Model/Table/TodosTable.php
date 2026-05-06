<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Todos Model
 */
class TodosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('todos');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->hasMany('TodoTags', [
            'foreignKey' => 'todo_id',
        ]);

        $this->belongsToMany('Tags', [
            'through' => 'TodoTags',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('content')
            ->requirePresence('content', 'create')
            ->notEmptyString('content');

        $validator
            ->boolean('completed')
            ->allowEmptyString('completed');

        return $validator;
    }

    /**
     * Create a new todo
     *
     * @param array $data Todo data
     * @return \Cake\Datasource\EntityInterface|false
     */
    public function createTodo(array $data)
    {
        $todo = $this->newEmptyEntity();

        $data['completed'] = $data['completed'] ?? false;

        $todo = $this->patchEntity($todo, $data);

        if ($this->save($todo)) {
            return $todo;
        }

        return false;
    }

    public function deleteTodo(int $id)
    {
        $todo = $this->get($id);

        return $this->delete($todo);
    }

    /**
     *
     * @param int $id 
     * @return \App\Model\Entity\Todo|false The saved entity, or false on save failure
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When the id does not exist
     */
    public function toggleCompleted(int $id)
    {
        $todo = $this->get($id);
        $todo->completed = !$todo->completed;

        if ($this->save($todo, ['validate' => false])) {
            return $todo;
        }

        return false;
    }
}
