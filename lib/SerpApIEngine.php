<?php

namespace Endless\SerpApi;

use Endless\SerpApi\SerpApi;
use Endless\SerpApi\SerpApiPagination;
use Endless\SerpApi\Exception\SerpApiException;

abstract class SerpApiEngine
{
    use SerpApiPagination;
    
    protected $engine;
    
    protected $httpHeaders = array();
    
    public static $lastHttpResponseHeaders = array();
    
    protected $resourceUrl;
    
    public $id;
        
    /**
     * __construct
     *
     * @param  mixed $id
     * @return void
     */
    public function __construct($id = null)
    {
        $config = SerpApi::$config;
        
        if (is_null($this->engine) || empty($this->engine)) {
            throw new SerpApiException('Invalid engine name. Please check the API Reference to get the appropriate engine name.');
        }
        
        $this->resourceUrl = $config['apiUrl'];
    }
        
    /**
     * generateUrl
     *
     * @param  mixed $urlParams
     * @param  mixed $customAction
     * @return void
     */
    public function generateUrl($urlParams = array(), $customAction = null)
    {
        $urlParams['api_key'] = SerpApi::$config['apiKey'];
        $urlParams['engine'] = $this->engine;
        
        return $this->resourceUrl . ($customAction ? "/$customAction" : '') . (!empty($urlParams) ? '?' . http_build_query($urlParams) : '');
    }
        
    /**
     * search
     *
     * @param  mixed $query
     * @return void
     */
    public function search($query)
    {
        $url = $this->generateUrl($query, 'search.json');
        
        return $this->get(array(), $url);
    }
        
    /**
     * get
     *
     * @param  mixed $urlParams
     * @param  mixed $url
     * @param  mixed $dataKey
     * @return void
     */
    public function get($urlParams = array(), $url = null, $dataKey = null)
    {
        if (!$url) $url  = $this->generateUrl($urlParams);

        $response = HttpRequestJson::get($url, $this->httpHeaders);

        return $this->processResponse($response, $dataKey);
    }
        
    /**
     * processResponse
     *
     * @param  mixed $responseArray
     * @param  mixed $dataKey
     * @return void
     */
    public function processResponse($responseArray, $dataKey = null)
    {
        self::$lastHttpResponseHeaders = CurlRequest::$lastHttpResponseHeaders;

        $lastResponseHeaders = CurlRequest::$lastHttpResponseHeaders;

        $this->getLinks($responseArray);

        return $responseArray;
    }
}