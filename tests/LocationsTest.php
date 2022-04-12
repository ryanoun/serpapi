<?php

namespace Endless\SerpApi;

use Endless\SerpApi\Locations;

class LocationsTest extends EngineTest
{
    public function testIfCanCreateLocationsResource()
    {
        self::$serpApi->Locations;

        $this->assertTrue(true);
    }

    public function testIfReturnedLocations()
    {
        $locations = $this->getMockBuilder(Locations::class)
            ->setMethods(['get'])
            ->getMock();

        $locations->method('get')
            ->willReturn(json_decode(file_get_contents(__DIR__ . '/MockResponses/LocationsResponse.json'), true));

        $results = $locations->get();

        $this->assertIsArray($results);
        $this->assertGreaterThan(1, count($results));
        $this->assertTrue(array_key_exists('id', $results[0]));
    }
}