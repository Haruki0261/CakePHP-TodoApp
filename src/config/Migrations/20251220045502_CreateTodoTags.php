<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateTodoTags extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('todo_tags');
        $table->addColumn('todo_id', 'integer', [
            'null' => false,
        ])
        ->addForeignKey('todo_id', 'todos', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']);
        $table->addColumn('tag_id', 'integer', [
            'null' => false,
        ])
        ->addForeignKey('tag_id', 'tags', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']);

        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);
        $table->create();
    }
}
