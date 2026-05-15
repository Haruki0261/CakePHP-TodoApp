<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Todo;
use Cake\I18n\Date;
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

    /**
     * 期限が基準日と同一（今日）の未完了 Todo は自動優先度 High。
     *
     * @return void
     */
    public function testAutoPriorityIsHighWhenDueDateIsToday(): void
    {
        $today = new Date('2026-05-14');
        $todo = new Todo([
            'completed' => false,
            'due_date' => $today,
        ]);

        $this->assertSame('High', $todo->getAutoPriorityLabel($today));
    }
}
