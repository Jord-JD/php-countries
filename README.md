# 🌍 PHP Countries

[![Build Status](https://travis-ci.com/Jord-JD/php-countries.svg?branch=master)](https://travis-ci.com/Jord-JD/php-countries)
[![Coverage Status](https://coveralls.io/repos/github/Jord-JD/php-countries/badge.svg?branch=master)](https://coveralls.io/github/Jord-JD/php-countries?branch=master)
[![StyleCI](https://github.styleci.io/repos/144559506/shield?branch=master)](https://github.styleci.io/repos/144559506)
[![Packagist](https://img.shields.io/packagist/dt/jord-jd/php-countries.svg)](https://packagist.org/packages/jord-jd/php-countries/stats)

PHP Countries is a library that provides an elegant syntax to country data.

## Installation

You can install PHP Countries via Composer, as follows.

```
composer require jord-jd/php-countries
```

## Usage

To use PHP Countries, you must create a new `Countries` object.

```php
use DivineOmega\Countries\Countries;

$countries = new Countries;
```

You can then call various methods on this object, to get country data.

### Retrieving all countries

You can easily retrieve an array of all countries and iterate through them, as follows.

```php
foreach($countries->all() as $country) {
    var_dump($country->name.' - '.$country->officialName);
}
```

### Retrieving country by name

Country details can be retrieved from the country's official or common name.

```php
var_dump($countries->getByName('United Kingdom'));

/* 
object(DivineOmega\Countries\Country)#146 (17) {
  ["name"]=>
  string(14) "United Kingdom"
  ["officialName"]=>
  string(52) "United Kingdom of Great Britain and Northern Ireland"
  ["topLevelDomains"]=>
  array(1) {
    [0]=>
    string(3) ".uk"
  }
  ["isoCodeAlpha2"]=>
  string(2) "GB"
  ["isoCodeAlpha3"]=>
  string(3) "GBR"
  ["isoCodeNumeric"]=>
  string(3) "826"
  ["languages"]=>
  array(1) {
    [0]=>
    string(7) "English"
  }
  ["languageCodes"]=>
  array(1) {
    [0]=>
    string(3) "eng"
  }
  ["currencyCodes"]=>
  array(1) {
    [0]=>
    string(3) "GBP"
  }
  ["callingCodes"]=>
  array(1) {
    [0]=>
    string(2) "44"
  }
  ["capital"]=>
  string(6) "London"
  ["capitals"]=>
  array(1) {
    [0]=>
    string(6) "London"
  }
  ["region"]=>
  string(6) "Europe"
  ["subregion"]=>
  string(15) "Northern Europe"
  ["latitude"]=>
  int(54)
  ["longitude"]=>
  int(-2)
  ["areaInKilometres"]=>
  int(242900)
  ["nationality"]=>
    string(7) "British"
}
*/
```

### Retrieving country by ISO 3166-1 code

You can get the data for a country by its ISO 3166-1 code. The 2 character, 3 character and numeric variations are all accepted.

```php
var_dump($countries->getByIsoCode('USA'));

/*
object(DivineOmega\Countries\Country)#4693 (16) {
  ["name"]=>
  string(13) "United States"
  ["officialName"]=>
  string(24) "United States of America"
  // etc...
}
*/
```

### Retrieving country by language spoken

Providing a language, will return an array of all countries in which that language is spoken. You can provide a language name or code.

```php
var_dump($countries->getByLanguage('German'));

/*
array(5) {
  [0]=>
  object(DivineOmega\Countries\Country)#4913 (16) {
    ["name"]=>
    string(7) "Belgium"
    ["officialName"]=>
    // etc...
  }
  [1]=>
  object(DivineOmega\Countries\Country)#4883 (16) {
    ["name"]=>
    string(7) "Germany"
    ["officialName"]=>
    string(27) "Federal Republic of Germany"
    // etc...
  }
  [2]=>
  object(DivineOmega\Countries\Country)#4826 (16) {
    ["name"]=>
    string(13) "Liechtenstein"
    ["officialName"]=>
    string(29) "Principality of Liechtenstein"
    // etc...
  }
  [3]=>
  object(DivineOmega\Countries\Country)#4808 (16) {
    ["name"]=>
    string(10) "Luxembourg"
    ["officialName"]=>
    string(25) "Grand Duchy of Luxembourg"
    // etc...
  }
  [4]=>
  object(DivineOmega\Countries\Country)#4871 (16) {
    ["name"]=>
    string(7) "Namibia"
    ["officialName"]=>
    string(19) "Republic of Namibia"
    // etc...
  }
}
*/
```
