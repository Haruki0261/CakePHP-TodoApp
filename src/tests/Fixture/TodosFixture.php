<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TodosFixture
 */
class TodosFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'title' => 'First todo',
                'content' => 'Content one',
                'completed' => false,
                'created' => '2025-09-21 10:00:00',
                'modified' => '2025-09-21 10:00:00',
            ],
            [
                'id' => 2,
                'title' => 'Second todo',
                'content' => 'Done',
                'completed' => true,
                'created' => '2025-09-21 11:00:00',
                'modified' => '2025-09-21 11:00:00',
            ],
            [
                'id' => 3,
                'title' => 'Third todo',
                'content' => 'Still open',
                'completed' => false,
                'created' => '2025-09-21 12:00:00',
                'modified' => '2025-09-21 12:00:00',
            ],
        ];
        parent::init();
    }
}
