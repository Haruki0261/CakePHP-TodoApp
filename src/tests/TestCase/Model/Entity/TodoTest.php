<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Todo;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Todo Test Case
 */
class TodoTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetCompletionLabelReturnsNotDoneWhenIncomplete(): void
    {
        $todo = new Todo(['completed' => false]);

        $this->assertSame('未完了', $todo->getCompletionLabel());
    }

    /**
     * @return void
     */
    public function testGetCompletionLabelReturnsDoneWhenComplete(): void
    {
        $todo = new Todo(['completed' => true]);

        $this->assertSame('完了', $todo->getCompletionLabel());
    }
}
