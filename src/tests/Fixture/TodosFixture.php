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
        ];
        parent::init();
    }
}
