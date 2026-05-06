<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TodosTable Test Case
 */
class TodosTableTest extends TestCase
{
    /**
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Todos',
    ];

    /**
     * @return void
     */
    public function testToggleCompletedFlipsFlag(): void
    {
        $Todos = $this->getTableLocator()->get('Todos');
        $before = $Todos->get(1);
        $this->assertFalse($before->completed);

        $after = $Todos->toggleCompleted(1);
        $this->assertNotFalse($after);
        $this->assertTrue($after->completed);

        $persisted = $Todos->get(1);
        $this->assertTrue($persisted->completed);

        $Todos->toggleCompleted(1);
        $this->assertFalse($Todos->get(1)->completed);
    }

    /**
     * @return void
     */
    public function testToggleCompletedThrowsWhenMissing(): void
    {
        $this->expectException(RecordNotFoundException::class);
        $Todos = $this->getTableLocator()->get('Todos');
        $Todos->toggleCompleted(99_999);
    }
}
