<?php
namespace App\WeatherApi;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService {

    private HttpClientInterface $httpClient;

    public function __construct(
        private readonly string $urlWeatherCurrent,
        private readonly string $urlWeatherForecast,
        private readonly string $urlWeatherApiKey,
    ) {
        $this->httpClient = HttpClient::create();
    }

    public function getWeatherCurrent(): array {
        return $this->send($this->urlWeatherCurrent);
    }

    private function send(string $url) : array {
        $response = $this->httpClient->request('GET', $url);

        return $response->toArray();
    }


}
