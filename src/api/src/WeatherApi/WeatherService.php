<?php
namespace App\WeatherApi;

use App\DTO\OpenWeatherMapRequestDTO;
use App\DTO\WeatherRequestDTO;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService {

    private HttpClientInterface $httpClient;

    public function __construct(
        private readonly string $weatherUrlCurrent,
        private readonly string $weatherUrlForecast,
        private readonly string $weatherApiKey,
    ) {
        $this->httpClient = HttpClient::create();
    }

    public function getWeatherCurrent(WeatherRequestDTO $weatherRequestDTO): array {
        return $this->send(
            $this->weatherUrlCurrent,
            $this->WeatherRequestDTOToOpenWeatherMapRequestDTO($weatherRequestDTO)->toArrayNotEmptyOnly()
        );
    }

    public function getWeatherForecast(WeatherRequestDTO $weatherRequestDTO): array {
        return $this->send(
            $this->weatherUrlForecast,
            $this->WeatherRequestDTOToOpenWeatherMapRequestDTO($weatherRequestDTO)->toArrayNotEmptyOnly()
        );
    }

    private function send(string $url, array $params) : array {
        $url = $url . '?' . http_build_query($params);
        $response = $this->httpClient->request('GET', $url);

        return $response->toArray();
    }

    private function WeatherRequestDTOToOpenWeatherMapRequestDTO(WeatherRequestDTO $weatherRequestDTO): OpenWeatherMapRequestDTO {
        $openWeatherMapRequestDTO = new OpenWeatherMapRequestDTO();
        $openWeatherMapRequestDTO
            ->setQ($weatherRequestDTO->getCityName())
            ->setLat($weatherRequestDTO->getLatitude())
            ->setLon($weatherRequestDTO->getLongitude())
            ->setUnits('metric')
            ->setLang('bg')
            ->setAppid($this->weatherApiKey)
        ;

        return $openWeatherMapRequestDTO;
    }


}
