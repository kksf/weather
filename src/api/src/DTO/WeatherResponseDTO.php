<?php
namespace App\DTO;


use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class WeatherResponseDTO {
    private bool $success;
    private ?array $errorMessages;
    private ?array $data;

    public function isSuccess(): bool {
        return $this->success;
    }

    public function setSuccess(bool $success): WeatherResponseDTO {
        $this->success = $success;
        return $this;
    }

    public function getErrorMessages(): ?array {
        return $this->errorMessages;
    }

    public function setErrorMessages(ConstraintViolationList|array|null $errorMessages): WeatherResponseDTO {
        if($errorMessages && $errorMessages[0] instanceof ConstraintViolation) {
            foreach ($errorMessages as $errorMessage) {
                $this->errorMessages[] = $errorMessage->getMessage();
            }

            return $this;
        }

        $this->errorMessages = $errorMessages;

        return $this;
    }

    public function getData(): ?array {
        return $this->data;
    }

    public function setData(?array $data): WeatherResponseDTO {
        $this->data = $data;
        return $this;
    }

    public function toArray(): array {
        if($this->success) {
            return [
                'success' => $this->success,
                'data' => $this->data,
            ];
        }

        return [
            'success' => $this->success,
            'errorMessages' => $this->errorMessages,
        ];
    }





}
