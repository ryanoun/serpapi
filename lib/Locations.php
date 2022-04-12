<?php

namespace Endless\SerpApi;

class Locations extends SerpApiRequest
{    
    /**
     * get
     *
     * @param  mixed $urlParams
     * @param  mixed $url
     * @param  mixed $dataKey
     * @return mixed
     */
    public function get($urlParams = array(), $url = null, $dataKey = null)
    {
        $config = SerpApi::$config;
        
        return parent::get($urlParams, $config['apiUrl'] . '/locations.json', $dataKey);
    }
}