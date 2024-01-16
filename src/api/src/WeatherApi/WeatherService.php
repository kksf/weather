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

    public function getWeatherCurrent(array $params): array {
        $weatherParams = new WeatherParams();
        $weatherParams->fromArray($params);
        $weatherParams->set(WeatherParams::API_KEY, $this->urlWeatherApiKey);

        return $this->send($this->urlWeatherCurrent, $weatherParams->getAllPopulated());
    }

    private function send(string $url, array $params) : array {
        $url = $url . '?' . http_build_query($params);
        $response = $this->httpClient->request('GET', $url);

        return $response->toArray();
    }


}
