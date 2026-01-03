<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TodoTags Model
 *
 * @property \App\Model\Table\TodosTable&\Cake\ORM\Association\BelongsTo $Todos
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\TodoTag newEmptyEntity()
 * @method \App\Model\Entity\TodoTag newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\TodoTag> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TodoTag get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\TodoTag findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\TodoTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\TodoTag> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TodoTag|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\TodoTag saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\TodoTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TodoTag>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TodoTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TodoTag> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TodoTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TodoTag>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TodoTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TodoTag> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TodoTagsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('todo_tags');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Todos', [
            'foreignKey' => 'todo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tags', [
        'foreignKey' => 'tag_id',
            'joinType' => 'INNER',
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
            ->integer('todo_id')
            ->notEmptyString('todo_id');

        $validator
            ->integer('tag_id')
            ->notEmptyString('tag_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['todo_id'], 'Todos'), ['errorField' => 'todo_id']);
        $rules->add($rules->existsIn(['tag_id'], 'Tags'), ['errorField' => 'tag_id']);

        return $rules;
    }

    public function createTodoTag(int $todoId, int $tag)
    {
        $todoTag = $this->newEmptyEntity();
        $todoTag->todo_id = $todoId;
        $todoTag->tag_id = $tag;

        $this->save($todoTag);
    }
}
