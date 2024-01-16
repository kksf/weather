<?php

namespace App\Controller;

use App\WeatherApi\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class apiV1Controller extends AbstractController
{
    private WeatherService $Weather;

    public function __construct(
        private WeatherService $weatherService,
    ) {}

    #[Route(['/api/v1', '/api', '/'], name: 'index')]
    public function index(): JsonResponse {
//        $Weather = new \Weather($this->httpClient);

//        $response = $this->httpClient->request(
//            'GET',
//            'https://api.github.com/repos/symfony/symfony-docs'
//        );
//
//        $a = $this->container->get('parameter_bag')->get('weather.url.current');
//        return new JsonResponse($a);
        return new JsonResponse($this->Weather->send());



    }

    #[Route('/api/v1/login', name: 'login')]
    public function login(): Response {
        return new JsonResponse(['action' => 'login']);
    }

    #[Route('/api/v1/now', name: 'now')]
    public function now(): Response {
        return new JsonResponse(['action' => 'now']);
    }

    #[Route('/api/v1/forecast', name: 'forecast')]
    public function forecast(): Response {
        return new JsonResponse(['action' => 'forecast']);
    }

}