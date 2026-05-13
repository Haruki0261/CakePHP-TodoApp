<?php
declare(strict_types=1);

namespace App\Test\TestCase\Service\Weather;

use App\Service\Weather\OpenMeteoCurrentWeatherCodeProvider;
use Cake\Http\Client;
use Cake\Http\Client\Adapter\Mock as MockAdapter;
use Cake\Http\Client\Request;
use Cake\Http\Client\Response;
use PHPUnit\Framework\TestCase;

class OpenMeteoCurrentWeatherCodeProviderTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetWeatherCodeReturnsIntWhenResponseIsSuccessful(): void
    {
        $adapter = new MockAdapter();
        $adapter->addResponse(
            new Request('https://api.open-meteo.com/v1/forecast/%2A'),
            new Response(["HTTP/1.1 200 OK"], '{"current":{"weather_code":61}}'),
            []
        );
        $client = new Client([
            'adapter' => $adapter,
            'timeout' => 5,
        ]);

        $provider = new OpenMeteoCurrentWeatherCodeProvider(35.6895, 139.6917, $client);

        $this->assertSame(61, $provider->getWeatherCode());
    }

    /**
     * @return void
     */
    public function testGetWeatherCodeReturnsNullWhenHttpError(): void
    {
        $adapter = new MockAdapter();
        $adapter->addResponse(
            new Request('https://api.open-meteo.com/v1/forecast/%2A'),
            new Response(["HTTP/1.1 500 Internal Server Error"], ''),
            []
        );
        $client = new Client([
            'adapter' => $adapter,
            'timeout' => 5,
        ]);

        $provider = new OpenMeteoCurrentWeatherCodeProvider(35.6895, 139.6917, $client);

        $this->assertNull($provider->getWeatherCode());
    }

    /**
     * @return void
     */
    public function testGetWeatherCodeReturnsNullWhenBodyIsInvalidJson(): void
    {
        $adapter = new MockAdapter();
        $adapter->addResponse(
            new Request('https://api.open-meteo.com/v1/forecast/%2A'),
            new Response(["HTTP/1.1 200 OK"], 'not json'),
            []
        );
        $client = new Client([
            'adapter' => $adapter,
            'timeout' => 5,
        ]);

        $provider = new OpenMeteoCurrentWeatherCodeProvider(35.6895, 139.6917, $client);

        $this->assertNull($provider->getWeatherCode());
    }

    /**
     * @return void
     */
    public function testGetWeatherCodeReturnsNullWhenWeatherCodeMissing(): void
    {
        $adapter = new MockAdapter();
        $adapter->addResponse(
            new Request('https://api.open-meteo.com/v1/forecast/%2A'),
            new Response(["HTTP/1.1 200 OK"], '{"current":{}}'),
            []
        );
        $client = new Client([
            'adapter' => $adapter,
            'timeout' => 5,
        ]);

        $provider = new OpenMeteoCurrentWeatherCodeProvider(35.6895, 139.6917, $client);

        $this->assertNull($provider->getWeatherCode());
    }
}
