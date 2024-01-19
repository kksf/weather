<?php
namespace App\WeatherApi;

use App\DTO\OpenWeatherMapRequestDTO;
use App\DTO\WeatherRequestDTO;
use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Service\ResetInterface;

class WeatherService {

    private HttpClientInterface $httpClient;
    private FilesystemAdapter $cache;

    public function __construct(
        private readonly array $weatherConfig
    ) {
        $this->httpClient = HttpClient::create();
        $this->cache = new FilesystemAdapter();
    }

    public function getWeatherCurrent(WeatherRequestDTO $weatherRequestDTO): array {
        return $this->send(
            $this->weatherConfig['url']['current'],
            $this->WeatherRequestDTOToOpenWeatherMapRequestDTO($weatherRequestDTO)->toArrayNotEmptyOnly()
        );
    }

    public function getWeatherForecast(WeatherRequestDTO $weatherRequestDTO): array {
        return $this->send(
            $this->weatherConfig['url']['forecast'],
            $this->WeatherRequestDTOToOpenWeatherMapRequestDTO($weatherRequestDTO)->toArrayNotEmptyOnly()
        );
    }

    private function send(string $url, array $params) : array {
        $url = $url . '?' . http_build_query($params);

        $value = $this->cache->get(md5($url), function (ItemInterface $item) use ($url) : \Symfony\Contracts\HttpClient\ResponseInterface {
            $item->expiresAfter($this->weatherConfig['cacheTtl']);
            $this->cache->delete(md5($url));
            $response = $this->httpClient->request('GET', $url);

            return $response;
        });

        return $value->toArray();
    }

    private function WeatherRequestDTOToOpenWeatherMapRequestDTO(WeatherRequestDTO $weatherRequestDTO): OpenWeatherMapRequestDTO {
        $openWeatherMapRequestDTO = new OpenWeatherMapRequestDTO();
        $openWeatherMapRequestDTO
            ->setQ($weatherRequestDTO->getCityName())
            ->setLat($weatherRequestDTO->getLatitude())
            ->setLon($weatherRequestDTO->getLongitude())
            ->setUnits('metric')
            ->setLang('bg')
            ->setAppid($this->weatherConfig['apiKey'])
        ;

        return $openWeatherMapRequestDTO;
    }


}
