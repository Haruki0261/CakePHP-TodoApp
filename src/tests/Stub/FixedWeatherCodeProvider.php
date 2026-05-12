<?php
declare(strict_types=1);

namespace App\Test\Stub;

use App\Service\Weather\CurrentWeatherCodeProviderInterface;

/**
 * Test double: always returns the configured WMO weather code (or null).
 */
final class FixedWeatherCodeProvider implements CurrentWeatherCodeProviderInterface
{
    private ?int $weatherCode;

    public function __construct(?int $weatherCode)
    {
        $this->weatherCode = $weatherCode;
    }

    public function getWeatherCode(): ?int
    {
        return $this->weatherCode;
    }
}
