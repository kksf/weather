<?php

namespace App\Controller;

use App\DTO\WeatherRequestDTO;
use App\DTO\WeatherResponseDTO;
use App\WeatherApi\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class apiV1Controller extends AbstractController
{
    private WeatherService $Weather;

    public function __construct(
        private WeatherService $weatherService,
        private ValidatorInterface $validator,
    ) {}

    #[Route(['/api/v1', '/api', '/'], name: 'index')]
    public function index(): JsonResponse {
        return new JsonResponse([
            'action' => 'index',
            'routes' => [
                'now' => '/api/v1/now',
                'forecast' => '/api/v1/forecast',
            ]
        ]);
    }

    #[Route('/api/v1/now', name: 'now')]
    public function now(Request $request): Response {
        $WeatherResponse = new WeatherResponseDTO();
        $WeatherRequest = new WeatherRequestDTO();
        $WeatherRequest->fromArray($request->query->all());
        $errors = $this->validator->validate($WeatherRequest);

        if(count($errors) > 0) {
            $WeatherResponse->setSuccess(false)->setErrorMessages($errors);

            return new JsonResponse($WeatherResponse->toArray());
        }

        try {
            $weather = $this->weatherService->getWeatherCurrent($WeatherRequest);
        } catch(\Throwable $e) {
            $WeatherResponse->setSuccess(false)->setErrorMessages([$e->getMessage()]);

            return new JsonResponse($WeatherResponse->toArray());
        }

        return new JsonResponse($WeatherResponse->setSuccess(true)->setData($weather)->toArray());
    }

    #[Route('/api/v1/forecast', name: 'forecast')]
    public function forecast(Request $request): Response {
        $WeatherResponse = new WeatherResponseDTO();
        $WeatherRequest = new WeatherRequestDTO();
        $WeatherRequest->fromArray($request->query->all());
        $errors = $this->validator->validate($WeatherRequest);

        if(count($errors) > 0) {
            $WeatherResponse->setSuccess(false)->setErrorMessages($errors);

            return new JsonResponse($WeatherResponse->toArray());
        }

        try {
            $weather = $this->weatherService->getWeatherForecast($WeatherRequest);
        } catch(\Throwable $e) {
            $WeatherResponse->setSuccess(false)->setErrorMessages([$e->getMessage()]);

            return new JsonResponse($WeatherResponse->toArray());
        }

        return new JsonResponse($WeatherResponse->setSuccess(true)->setData($weather)->toArray());
    }

}