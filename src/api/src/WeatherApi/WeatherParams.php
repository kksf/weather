<?php
namespace App\WeatherApi;

class WeatherParams {
    /**
     * *City name**.
     * *Example: London*.
     * You can call by city name, or by city name and country code.
     * The API responds with a list of results that match a searching word.
     * For the query value, type the city name and optionally the country code divided by a comma; use ISO 3166 country codes.
     *
     * @var string $q
     */
    const string CITY_NAME = 'q';

    /**
     * *City ID**.
     * *Example: `2172797`*.
     * You can call by city ID. The API responds with the exact result.
     * The List of city IDs can be downloaded [here](http://bulk.openweathermap.org/sample/).
     * You can include multiple cities in this parameter &mdash; just separate them by commas.
     * The limit of locations is 20.
     * Note: A single ID counts as a one API call. So, if you have city IDs, its treated as 3 API calls.
     *
     * @var string $id
     */
    const string CITY_ID = 'id';

    /**
     * *Latitude**.
     * *Example: 35*.
     * The latitude coordinate of the location of your interest. Must use with `lon`.
     *
     * @var string $lat
     */
    const string LATITUDE = 'lat';

    /**
     * *Longitude**.
     * *Example: 139*.
     * Longitude coordinate of the location of your interest. Must use with `lat`.
     *
     * @var string $lon
     */
    const string LONGITUDE = 'lon';

    /**
     * *Zip code**. * Search by zip code.
     * *Example: 95050,us*.
     * Please note that if the country is not specified, the search uses USA as a default.
     *
     * @var string $zip
     */
    const string ZIP_CODE = 'zip';

    /**
     * *Units**.
     * *Example: imperial*.
     * Possible values: `metric`, `imperial`.
     * When you do not use the `units` parameter, the format is `standard` by default.
     *
     * @var string $units
     */
    const string UNITS = 'units';

    /**
     * *Language**.
     * *Example: en*.
     * You can use lang parameter to get the output in your language.
     * We support the following languages that you can use with the corresponded lang values:
     *  Arabic - `ar`,
     *  Bulgarian - `bg`,
     *  Catalan - `ca`, etc...
     *
     * @var string $lang
     */
    const string LANGUAGE = 'lang';

    /**
     * *Mode**.
     * *Example: html*.
     * Determines the format of the response. Possible values are `xml` and `html`.
     * If the mode parameter is empty, the format is `json` by default.
     *
     * @var string $Mode
     */
    const string MODE = 'mode';

    /**
     * *API Key**.
     * *Example: 52a17d91b3ed0697b05a7dd6fdc708c4*.
     * API Keys are associated with developer accounts.
     *
     * @var string $appid
     */
    const string API_KEY = 'appid';

    /**
     * @var array $params
     */
    private array $params = [
        self::CITY_NAME => null,
        self::CITY_ID   => null,
        self::LATITUDE  => null,
        self::LONGITUDE => null,
        self::ZIP_CODE  => null,
        self::UNITS     => null,
        self::LANGUAGE  => null,
        self::MODE      => null,
        self::API_KEY   => null,
    ];

    /**
     * Populate params from array.
     *
     * @param array $data
     * @return void
     */
    public function hydrateFromArray(array $data) : void {
        foreach ($data as $param => $value) {
            $this->params[$param] = $value;
        }
    }

    /**
     * Get all params with non-null values.
     *
     * @return array
     */
    public function getAllPopulated() : array {
        return array_filter($this->params, fn($value) => $value !== null);
    }

}
