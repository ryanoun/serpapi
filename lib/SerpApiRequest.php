<?php

namespace Endless\SerpApi;

use Endless\SerpApi\SerpApi;
use Endless\SerpApi\SerpApiPagination;

abstract class SerpApiRequest
{
    use SerpApiPagination;
    
    protected $httpHeaders = array();
    
    public static $lastHttpResponseHeaders = array();
    
    public $id;
        
    /**
     * __construct
     *
     * @param  mixed $id
     * @return void
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }
        
    /**
     * get
     *
     * @param  mixed $urlParams
     * @param  mixed $url
     * @param  mixed $dataKey
     * @return void
     */
    public function get($urlParams = array(), $url = null, $dataKey= null)
    {
        $urlParams['api_key'] = SerpApi::$config['apiKey'];

        $url = $url . (!empty($urlParams) ? '?' . http_build_query($urlParams) : '');

        $response = HttpRequestJson::get($url, $this->httpHeaders);

        return $this->processResponse($response, $dataKey);
    }
        
    /**
     * processResponse
     *
     * @param  mixed $responseArray
     * @param  mixed $dataKey
     * @return array
     */
    private function processResponse($responseArray, $dataKey= null)
    {
        self::$lastHttpResponseHeaders = CurlRequest::$lastHttpResponseHeaders;

        $lastResponseHeaders = CurlRequest::$lastHttpResponseHeaders;
        
        $this->getLinks($responseArray);
        
        return $responseArray;
    }
}