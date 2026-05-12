<?php
declare(strict_types=1);

namespace App\Service\Weather;

use Cake\Http\Client;

/**
 * Fetches current WMO weather_code from Open-Meteo forecast API (no API key required).
 *
 * @link https://open-meteo.com/en/docs
 */
final class OpenMeteoCurrentWeatherCodeProvider implements CurrentWeatherCodeProviderInterface
{
    private const FORECAST_ENDPOINT = 'https://api.open-meteo.com/v1/forecast';

    public function __construct(
        private readonly float $latitude,
        private readonly float $longitude,
        private readonly Client $httpClient,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getWeatherCode(): ?int
    {
        try {
            $response = $this->httpClient->get(self::FORECAST_ENDPOINT, [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'current' => 'weather_code',
                'timezone' => 'auto',
            ]);

            if (!$response->isOk()) {
                return null;
            }

            $decoded = $response->getJson();
            if (!is_array($decoded)) {
                return null;
            }

            $code = $decoded['current']['weather_code'] ?? null;
            if ($code === null || !is_numeric($code)) {
                return null;
            }

            return (int)$code;
        } catch (\Throwable) {
            return null;
        }
    }
}
