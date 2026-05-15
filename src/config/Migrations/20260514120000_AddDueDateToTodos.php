<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddDueDateToTodos extends BaseMigration
{
    /**
     * Change Method.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('todos');
        $table->addColumn('due_date', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
