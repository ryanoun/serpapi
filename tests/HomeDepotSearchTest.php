<?php

namespace Endless\SerpApi;

use Endless\SerpApi\HomeDepotSearch;

class HomeDepotSearchTest extends EngineTest
{
    public function testIfCanCreateHomeDepotSearchResource()
    {
        self::$serpApi->HomeDepotSearch;

        $this->assertTrue(true);
    }

    public function testIfReturnedHomeDepotSearch()
    {
        $search = $this->getMockBuilder(GoogleSHomeDepotSearchearch::class)
            ->setMethods(['search'])
            ->getMock();

        $search->method('search')
            ->willReturn(json_decode(file_get_contents(__DIR__ . '/MockResponses/HomeDepotSearchResponse.json'), true));

        $results = $search->search([
            'q' => 'samsung fridge'
        ]);

        $this->assertIsArray($results);
        $this->assertTrue(array_key_exists('search_metadata', $results));
        $this->assertTrue($results['search_metadata']['status'] == 'Success');
    }

    public function testIfResultsHasNextLinkPagination()
    {
        $search = $this->getMockBuilder(HomeDepotSearch::class)
            ->setMethods(['search'])
            ->getMock();

        $search->method('search')
            ->willReturn(json_decode(file_get_contents(__DIR__ . '/MockResponses/HomeDepotSearchResponse.json'), true));

        $results = $search->search([
            'q' => 'samsung fridge'
        ]);
        
        $search->getLinks($results);

        $this->assertIsArray($results);
        $this->assertTrue(array_key_exists('serpapi_pagination', $results));
        $this->assertNotNull($search->getNextLink());
    }
}