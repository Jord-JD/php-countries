<?php

namespace JordJD\Countries\DataSources;

use JordJD\Countries\Country;
use JordJD\Countries\Interfaces\DataSourceInterface;
use Exception;

class MledozeCountriesJson implements DataSourceInterface
{
    private $countryData;

    public function __construct()
    {
        $paths = [];
        $paths[] = __DIR__.'/mledoze/countries/dist/countries.json';

        if (!$this->countryData) {
            foreach ($paths as $path) {
                if (file_exists($path)) {
                    $this->countryData = json_decode(file_get_contents($path));
                    break;
                }
            }
        }

        if (!$this->countryData) {
            throw new Exception('Unable to retrieve MledozeCountries JSON data file. Have you ran composer update?');
        }
    }

    public function all()
    {
        $countries = [];

        foreach ($this->countryData as $countryDataItem) {
            $country = new Country();
            $country->name = $countryDataItem->name->common;
            $country->officialName = $countryDataItem->name->official;
            $country->topLevelDomains = $countryDataItem->tld;
            $country->isoCodeAlpha2 = $countryDataItem->cca2;
            $country->isoCodeAlpha3 = $countryDataItem->cca3;
            $country->isoCodeNumeric = $countryDataItem->ccn3;
            $country->languages = array_values((array) $countryDataItem->languages);
            $country->languageCodes = array_keys((array) $countryDataItem->languages);
            $country->currencyCodes = $countryDataItem->currency;
            $country->callingCodes = $countryDataItem->callingCode;
            $country->capital = reset($countryDataItem->capital);
            $country->capitals = $countryDataItem->capital;
            $country->region = $countryDataItem->region;
            $country->subregion = $countryDataItem->subregion;
            $country->latitude = isset($countryDataItem->latlng[0]) ? $countryDataItem->latlng[0] : null;
            $country->longitude = isset($countryDataItem->latlng[1]) ? $countryDataItem->latlng[1] : null;
            $country->areaInKilometres = $countryDataItem->area;
            $country->nationality = isset($countryDataItem->demonym) ? $countryDataItem->demonym : null;

            $countries[] = $country;
        }

        return $countries;
    }
}
