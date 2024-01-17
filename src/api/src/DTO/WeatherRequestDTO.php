<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


class WeatherRequestDTO {

    #[Assert\NoSuspiciousCharacters]
    private ?string $cityName;

    #[Assert\Range(
        notInRangeMessage: 'The latitude must be between {{ min }} and {{ max }}',
        min: -90,
        max: 90,
    )]
    private ?float $latitude;

    #[Assert\Range(
        notInRangeMessage: 'The longitude must be between {{ min }} and {{ max }}',
        min: -180,
        max: 180,
    )]
    private ?float $longitude;

    public function fromArray(array $data): void {
        $this->cityName = $data['cityName'] ?? null;
        $this->latitude = $data['latitude'] ?? null;
        $this->longitude = $data['longitude'] ?? null;
    }

    #[Assert\Callback()]
    public function validate(ExecutionContextInterface $context): void {
        if(!$this->cityName && !$this->latitude && !$this->longitude) {
            $context
                ->buildViolation('At least one of the parameters must be set')
                ->atPath('cityName')
                ->addViolation()
            ;
        }

        if($this->cityName && $this->latitude && $this->longitude) {
            $context
                ->buildViolation('Please set only one of these: [cityName] or [latitude, longitude]')
                ->atPath('cityName')
                ->addViolation()
            ;
        }

        if($this->latitude && !$this->longitude || !$this->latitude && $this->longitude) {
            $context
                ->buildViolation('Latitude and latitude must be set together')
                ->atPath('latitude')
                ->addViolation()
            ;
        }
    }

}
