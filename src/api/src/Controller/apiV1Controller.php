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
        $weatherParams = new WeatherRequestDTO();
        $weatherParams->fromArray($request->query->all());
        $errors = $this->validator->validate($weatherParams);

        $Response = new WeatherResponseDTO();
        if(count($errors) > 0) {
            $Response->setSuccess(false)->setErrorMessages($errors);

            return new JsonResponse($Response->toArray());
        }

        try {
            $weather = $this->weatherService->getWeatherCurrent($weatherParams);
        } catch(\Throwable $e) {
            $Response->setSuccess(false)->setErrorMessages([$e->getMessage()]);

            return new JsonResponse($Response->toArray());
        }

        return new JsonResponse($Response->setSuccess(true)->setData($weather)->toArray());
    }

    #[Route('/api/v1/forecast', name: 'forecast')]
    public function forecast(Request $request): Response {
        $weatherParams = new WeatherRequestDTO();
        $weatherParams->fromArray($request->query->all());
        $errors = $this->validator->validate($weatherParams);

        $Response = new WeatherResponseDTO();
        if(count($errors) > 0) {
            $Response->setSuccess(false)->setErrorMessages($errors);

            return new JsonResponse($Response->toArray());
        }

        try {
            $weather = $this->weatherService->getWeatherForecast($weatherParams);
        } catch(\Throwable $e) {
            $Response->setSuccess(false)->setErrorMessages([$e->getMessage()]);

            return new JsonResponse($Response->toArray());
        }

        return new JsonResponse($Response->setSuccess(true)->setData($weather)->toArray());
    }

}