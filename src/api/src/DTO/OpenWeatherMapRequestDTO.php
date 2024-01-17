<?php

namespace App\DTO;

class OpenWeatherMapRequestDTO
{
    /**
     * *City name**.
     * *Example: London*.
     * You can call by city name, or by city name and country code.
     * The API responds with a list of results that match a searching word.
     * For the query value, type the city name and optionally the country code divided by a comma; use ISO 3166 country codes.
     *
     * @var string|null $q
     */
    private ?string $q;

    /**
     * *City ID**.
     * *Example: `2172797`*.
     * You can call by city ID. The API responds with the exact result.
     * The List of city IDs can be downloaded [here](http://bulk.openweathermap.org/sample/).
     * You can include multiple cities in this parameter &mdash; just separate them by commas.
     * The limit of locations is 20.
     * Note: A single ID counts as a one API call. So, if you have city IDs, its treated as 3 API calls.
     *
     * @var string|null $id
     */
    private ?string $id;

    /**
     * *Latitude**.
     * *Example: 35*.
     * The latitude coordinate of the location of your interest. Must use with `lon`.
     *
     * @var string|null $lat
     */
    private ?string $lat;

    /**
     * *Longitude**.
     * *Example: 139*.
     * Longitude coordinate of the location of your interest. Must use with `lat`.
     *
     * @var string|null $lon
     */
    private ?string $lon;

    /**
     * *Zip code**. * Search by zip code.
     * *Example: 95050,us*.
     * Please note that if the country is not specified, the search uses USA as a default.
     *
     * @var string|null $zip
     */
    private ?string $zip;

    /**
     * *Units**.
     * *Example: imperial*.
     * Possible values: `metric`, `imperial`.
     * When you do not use the `units` parameter, the format is `standard` by default.
     *
     * @var string|null $units
     */
    private ?string $units;

    /**
     * *Language**.
     * *Example: en*.
     * You can use lang parameter to get the output in your language.
     * We support the following languages that you can use with the corresponded lang values:
     *  Arabic - `ar`,
     *  Bulgarian - `bg`,
     *  Catalan - `ca`, etc...
     *
     * @var string|null $lang
     */
    private ?string $lang;

    /**
     * *Mode**.
     * *Example: html*.
     * Determines the format of the response. Possible values are `xml` and `html`.
     * If the mode parameter is empty, the format is `json` by default.
     *
     * @var string|null $Mode
     */
    private ?string $mode;

    /**
     * *API Key**.
     * *Example: 52a17d91b3ed0697b05a7dd6fdc708c4*.
     * API Keys are associated with developer accounts.
     *
     * @var string|null $appid
     */
    private ?string $appid;

    public function setQ(?string $q): OpenWeatherMapRequestDTO {
        $this->q = $q;
        return $this;
    }

    public function setId(?string $id): OpenWeatherMapRequestDTO {
        $this->id = $id;
        return $this;
    }

    public function setLat(?string $lat): OpenWeatherMapRequestDTO {
        $this->lat = $lat;
        return $this;
    }

    public function setLon(?string $lon): OpenWeatherMapRequestDTO {
        $this->lon = $lon;
        return $this;
    }

    public function setZip(?string $zip): OpenWeatherMapRequestDTO {
        $this->zip = $zip;
        return $this;
    }

    public function setUnits(?string $units): OpenWeatherMapRequestDTO {
        $this->units = $units;
        return $this;
    }

    public function setLang(?string $lang): OpenWeatherMapRequestDTO {
        $this->lang = $lang;
        return $this;
    }

    public function setMode(?string $mode): OpenWeatherMapRequestDTO {
        $this->mode = $mode;
        return $this;
    }

    public function setAppid(?string $appid): OpenWeatherMapRequestDTO {
        $this->appid = $appid;
        return $this;
    }

    public function toArrayNotEmptyOnly(): array {
        $out = [];

        $properties = get_object_vars($this);
        foreach ($properties as $property => $value) {
            if($value) {
                $out[$property] = $value;
            }
        }

        return $out;
    }


}