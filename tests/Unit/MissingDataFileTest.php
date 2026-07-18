<?php

namespace JordJD\Countries\Tests;

use JordJD\Countries\DataSources\MledozeCountriesJson;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class MissingDataFileTest extends TestCase
{
    public function testMissingDataFileHasAClearError()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unable to retrieve valid Mledoze Countries JSON data.');

        new MledozeCountriesJson([__DIR__.'/data/does-not-exist.json']);
    }
}
