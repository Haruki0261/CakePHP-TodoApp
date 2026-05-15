<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\Date;
use Cake\ORM\Entity;

/**
 * Todo Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property bool $completed
 * @property \Cake\I18n\Date|null $due_date
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class Todo extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'title' => true,
        'content' => true,
        'completed' => true,
        'due_date' => true,
        'created' => true,
        'modified' => true,
    ];

    /**
     * Human-readable completion label for display.
     *
     * @return string
     */
    public function getCompletionLabel(): string
    {
        return $this->completed ? '完了' : '未完了';
    }

    /**
     * 期限に基づく自動優先度ラベル（表示用）。
     *
     * @param \Cake\I18n\Date|null $today 基準日（省略時は今日）
     * @return string 未対応の組み合わせでは空文字
     */
    public function getAutoPriorityLabel(?Date $today = null): string
    {
        $today = $today ?? Date::today();

        if ($this->completed) {
            return '';
        }

        $due = $this->due_date;
        if (!$due instanceof Date) {
            return '';
        }

        if ($due->format('Y-m-d') === $today->format('Y-m-d')) {
            return 'High';
        }

        return '';
    }
}
