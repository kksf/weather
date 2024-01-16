<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class WeatherRequestDTO {

    #[Assert\Expression(
        expression: "empty(this.latitude) && empty(this.longitude) && empty(this.cityName)",
        message: "Either cityName or latitude and longitude must be set"
    )]
    #[Assert\NoSuspiciousCharacters]
    private string $cityName;

    #[Assert\Range(
        notInRangeMessage: 'The latitude must be between {{ min }}&deg; and {{ max }}&deg;',
        min: -90,
        max: 90,
    )]
    private float $latitude;

    #[Assert\Range(
        notInRangeMessage: 'The longitude must be between {{ min }}&deg; and {{ max }}&deg;',
        min: -180,
        max: 180,
    )]
    private float $longitude;
}
