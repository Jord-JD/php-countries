<?php

namespace JordJD\Countries\Tests;

use JordJD\Countries\Countries;
use JordJD\Countries\Country;
use PHPUnit\Framework\TestCase;

final class BasicUsageTest extends TestCase
{
    public function testGetAllCountries()
    {
        $countries = (new Countries())->all();

        $this->assertGreaterThanOrEqual(248, count($countries));

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
        }
    }

    public function testGetCountryByName()
    {
        $country = (new Countries())->getByName('United Kingdom');

        $this->assertInstanceOf(Country::class, $country);
        $this->assertEquals('GBR', $country->isoCodeAlpha3);
    }

    public function testGetNonExistantCountryByName()
    {
        $country = (new Countries())->getByName('Unified Kingdom of Jordania');

        $this->assertNull($country);
    }

    public function testGetCountryByIsoCode3Char()
    {
        $country = (new Countries())->getByIsoCode('USA');

        $this->assertInstanceOf(Country::class, $country);
        $this->assertEquals('United States', $country->name);
    }

    public function testGetCountryByIsoCode2Char()
    {
        $country = (new Countries())->getByIsoCode('US');

        $this->assertInstanceOf(Country::class, $country);
        $this->assertEquals('United States', $country->name);
    }

    public function testGetNonExistantCountryByIsoCode()
    {
        $country = (new Countries())->getByIsoCode('UKJ');

        $this->assertNull($country);
    }

    public function testGetCountriesByLanguages()
    {
        $countries = (new Countries())->getByLanguage('German');

        $this->assertCount(5, $countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertContains('German', $country->languages);
        }
    }
}
