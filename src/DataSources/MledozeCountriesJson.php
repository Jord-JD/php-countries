<?php

namespace JordJD\Countries\DataSources;

use JordJD\Countries\Country;
use JordJD\Countries\Interfaces\DataSourceInterface;
use RuntimeException;

class MledozeCountriesJson implements DataSourceInterface
{
    private $countryData;

    public function __construct(?array $paths = null)
    {
        $paths = $paths ?: [
            __DIR__.'/../../vendor/mledoze/countries/dist/countries.json',
            __DIR__.'/mledoze/countries/dist/countries.json',
        ];

        foreach ($paths as $path) {
            if (!is_file($path)) {
                continue;
            }

            $contents = file_get_contents($path);
            $decoded = $contents === false ? null : json_decode($contents);

            if (is_array($decoded)) {
                $this->countryData = $decoded;
                break;
            }
        }

        if (!$this->countryData) {
            throw new RuntimeException('Unable to retrieve valid Mledoze Countries JSON data. Run composer install or update.');
        }
    }

    public function all()
    {
        $countries = [];

        foreach ($this->countryData as $item) {
            $country = new Country();
            $country->name = $item->name->common;
            $country->officialName = $item->name->official;
            $country->topLevelDomains = isset($item->tld) ? $item->tld : [];
            $country->isoCodeAlpha2 = $item->cca2;
            $country->isoCodeAlpha3 = $item->cca3;
            $country->isoCodeNumeric = isset($item->ccn3) ? $item->ccn3 : null;
            $country->languages = array_values((array) $item->languages);
            $country->languageCodes = array_keys((array) $item->languages);
            $country->currencyCodes = $this->getCurrencyCodes($item);
            $country->callingCodes = $this->getCallingCodes($item);
            $country->capitals = isset($item->capital) ? array_values((array) $item->capital) : [];
            $country->capital = isset($country->capitals[0]) ? $country->capitals[0] : null;
            $country->region = isset($item->region) ? $item->region : null;
            $country->subregion = isset($item->subregion) ? $item->subregion : null;
            $country->latitude = isset($item->latlng[0]) ? $item->latlng[0] : null;
            $country->longitude = isset($item->latlng[1]) ? $item->latlng[1] : null;
            $country->areaInKilometres = isset($item->area) ? $item->area : null;
            $country->nationality = $this->getNationality($item);

            $countries[] = $country;
        }

        return $countries;
    }

    private function getCurrencyCodes($item)
    {
        if (isset($item->currencies)) {
            return array_keys((array) $item->currencies);
        }

        return isset($item->currency) ? array_values((array) $item->currency) : [];
    }

    private function getCallingCodes($item)
    {
        if (isset($item->idd->root)) {
            $root = ltrim($item->idd->root, '+');
            $suffixes = isset($item->idd->suffixes) ? (array) $item->idd->suffixes : [];

            if (!$suffixes) {
                return [$root];
            }

            return array_map(function ($suffix) use ($root) {
                return $root.$suffix;
            }, $suffixes);
        }

        return isset($item->callingCode) ? array_values((array) $item->callingCode) : [];
    }

    private function getNationality($item)
    {
        if (isset($item->demonyms->eng->m)) {
            return $item->demonyms->eng->m;
        }

        return isset($item->demonym) ? $item->demonym : null;
    }
}
