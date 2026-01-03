<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TodoTag Entity
 *
 * @property int $id
 * @property int $todo_id
 * @property int $tag_id
 * @property \Cake\I18n\DateTime $created
 *
 * @property \App\Model\Entity\Todo $todo
 * @property \App\Model\Entity\Tag $tag
 */
class TodoTag extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'todo_id' => true,
        'tag_id' => true,
        'created' => true,
        'todo' => true,
        'tag' => true,
    ];
}
