<?php
declare(strict_types=1);

namespace App\Service\Weather;

/**
 * Provides the current WMO weather code (Open-Meteo style), or null if unavailable.
 */
interface CurrentWeatherCodeProviderInterface
{
    public function getWeatherCode(): ?int;
}
