<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Table\TagsTable;
use App\Utility\LikeEscape;

class TagsService
{
    private TagsTable $Tags;

    public function __construct(TagsTable $Tags)
    {
        $this->Tags = $Tags;
    }

    public function getTagsByName(string $name): array
    {
        return $this->Tags->getTagsByName(LikeEscape::escape($name));
    }
}
