<?php

namespace Endless\SerpApi;

use Endless\SerpApi\GoogleSearch;

class GoogleSearchTest extends EngineTest
{
    public function testIfCanCreateGoogleSearchResource()
    {
        self::$serpApi->GoogleSearch;

        $this->assertTrue(true);
    }

    public function testIfReturnedGoogleSearch()
    {
        $search = $this->getMockBuilder(GoogleSearch::class)
            ->setMethods(['search'])
            ->getMock();

        $search->method('search')
            ->willReturn(json_decode(file_get_contents(__DIR__ . '/MockResponses/GoogleSearchResponse.json'), true));

        $results = $search->search([
            'q' => 'coffee'
        ]);

        $this->assertIsArray($results);
        $this->assertTrue(array_key_exists('search_metadata', $results));
        $this->assertTrue($results['search_metadata']['status'] == 'Success');
    }

    public function testIfResultsHasNextLinkPagination()
    {
        $search = $this->getMockBuilder(GoogleSearch::class)
            ->setMethods(['search'])
            ->getMock();

        $search->method('search')
            ->willReturn(json_decode(file_get_contents(__DIR__ . '/MockResponses/GoogleSearchResponse.json'), true));

        $results = $search->search([
            'q' => 'coffee'
        ]);
        
        $search->getLinks($results);

        $this->assertIsArray($results);
        $this->assertTrue(array_key_exists('serpapi_pagination', $results));
        $this->assertNotNull($search->getNextLink());
    }
}