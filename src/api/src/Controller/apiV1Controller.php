<?php

namespace App\Controller;

use App\WeatherApi\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
        return new JsonResponse([
            'action' => 'index',
            'routes' => [
                'login' => '/api/v1/login',
                'now' => '/api/v1/now',
                'forecast' => '/api/v1/forecast',
            ]
        ]);
    }

    #[Route('/api/v1/login', name: 'login')]
    public function login(): Response {
        return new JsonResponse(['action' => 'login']);
    }

    #[Route('/api/v1/now', name: 'now')]
    public function now(Request $request): Response {
        dd($request->query->all());
        //dd($this->container->get('request_stack')->getMainRequest()->query->all());

        return new JsonResponse($this->weatherService->getWeatherCurrent([]));
    }

    #[Route('/api/v1/forecast', name: 'forecast')]
    public function forecast(): Response {
        return new JsonResponse(['action' => 'forecast']);
    }

}