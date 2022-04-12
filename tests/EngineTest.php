<?php

namespace Endless\SerpApi;

use Endless\SerpApi\SerpApi;
use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{
    protected static $serpApi;
    
    public static function setUpBeforeClass(): void
    {
        $config = array(
            'apiUrl' => getenv('SERPAPI_APIURL'),
            'apiKey' => getenv('SERPAPI_KEY')
        );

        self::$serpApi = SerpApi::config($config);
    }

    /**
     * @inheritDoc
     */
    public static function tearDownAfterClass(): void
    {
        self::$serpApi = null;
    }
}