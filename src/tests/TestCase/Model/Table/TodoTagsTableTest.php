<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TodoTagsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TodoTagsTable Test Case
 */
class TodoTagsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TodoTagsTable
     */
    protected $TodoTags;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.TodoTags',
        'app.Todos',
        'app.Tags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TodoTags') ? [] : ['className' => TodoTagsTable::class];
        $this->TodoTags = $this->getTableLocator()->get('TodoTags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TodoTags);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\TodoTagsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\TodoTagsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
