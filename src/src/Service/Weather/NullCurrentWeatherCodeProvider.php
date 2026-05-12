<?php
declare(strict_types=1);

namespace App\Service\Weather;

/**
 * Placeholder until a real API client is registered.
 */
final class NullCurrentWeatherCodeProvider implements CurrentWeatherCodeProviderInterface
{
    public function getWeatherCode(): ?int
    {
        return null;
    }
}
