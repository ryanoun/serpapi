<?php

namespace Endless\SerpApi;

trait SerpApiPagination
{
    private $nextLink = null;
    
    private $prevLink = null;
        
    /**
     * getLinks
     *
     * @param  mixed $responseArray
     * @return void
     */
    public function getLinks($responseArray)
    {
        if (array_key_exists('serpapi_pagination', $responseArray)) {
            $this->prevLink = $this->getLink($responseArray, 'previous_link');
            $this->nextLink = $this->getLink($responseArray, 'next_link');
        }
    }
        
    /**
     * getLink
     *
     * @param  mixed $responseArray
     * @param  mixed $type
     * @return mixed
     */
    public function getLink($responseArray, $type = 'next_link') 
    {
        if (array_key_exists($type, $responseArray['serpapi_pagination'])) {
            return $responseArray['serpapi_pagination'][$type];
        }
        
        return null;
    }
        
    /**
     * getPrevLink
     *
     * @return string
     */
    public function getPrevLink()
    {
        return $this->prevLink;
    }
    
    /**
     * getNextLink
     *
     * @return string
     */
    public function getNextLink()
    {
        return $this->nextLink;
    }
        
    /**
     * getPaginationUrlParams
     *
     * @param  mixed $url
     * @return string
     */
    public function getPaginationUrlParams($url) 
    {
        if ($url) {
            $parts = parse_url($url);
            return $parts['query'];
        }
        return '';
    }
        
    /**
     * getNextPageParams
     *
     * @return string
     */
    public function getNextPageParams()
    {
        $nextPageParams = [];
        parse_str($this->getPaginationUrlParams($this->getNextLink()), $nextPageParams);
        return $nextPageParams;
    }
    
    /**
     * getPrevPageParams
     *
     * @return string
     */
    public function getPrevPageParams()
    {
        $nextPageParams = [];
        parse_str($this->getPaginationUrlParams($this->getPrevLink()), $nextPageParams);
        return $nextPageParams;
    }
}