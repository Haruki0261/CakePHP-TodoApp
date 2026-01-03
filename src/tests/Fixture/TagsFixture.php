<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TagsFixture
 */
class TagsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'color' => 'Lorem',
                'created' => '2025-12-21 00:47:29',
                'modified' => '2025-12-21 00:47:29',
            ],
        ];
        parent::init();
    }
}
