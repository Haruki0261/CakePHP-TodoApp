<?php
declare(strict_types=1);

namespace App\Service\Weather;

/**
 * Maps WMO weather codes to motivation copy for the todo index.
 */
final class WeatherMotivationMessageBuilder
{
    public function build(?int $wmoCode): string
    {
        if ($wmoCode === null) {
            return '今日の天気を取得できませんでした。';
        }

        return match (true) {
            $wmoCode === 0 => '今日は晴れなので、外でのタスクも捗りますよ！',
            default => '今日も無理せず、できるタスクから進めましょう。',
        };
    }
}
