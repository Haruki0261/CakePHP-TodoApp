<?php
declare(strict_types=1);

namespace App\Utility;

class LikeEscape
{
    public static function escape(string $literal): string
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $literal);
    }
}
