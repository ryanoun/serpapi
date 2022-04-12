<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/17/16 3:14 PM UTC+06:00
 *
 */

namespace Endless\SerpApi;

use Endless\SerpApi\Exception\SerpApiException;

class SerpApi
{    
    /**
     * engines
     *
     * @var array
     */
    protected $engines = array(
        'GoogleSearch',
        'HomeDepotSearch',
    );
        
    /**
     * resources
     *
     * @var array
     */
    protected $resources = array(
        'Account',
        'Locations',
        'SearchArchive',
    );
    
    public static $config = array();

    public static $microtimeOfLastApiCall;

    public static $timeAllowedForEachApiCall = .5;
       
   /**
    * __construct
    *
    * @param  mixed $config
    * @return void
    */
   public function __construct($config = array())
   {
       if (! empty($config)) {
           SerpAPI::config($config);
       }
   }
      
   /**
    * __get
    *
    * @param  mixed $resourceName
    * @return void
    */
   public function __get($resourceName)
   {
       return $this->$resourceName();
   }
      
   /**
    * __call
    *
    * @param  mixed $function
    * @param  mixed $arguments
    * @return void
    */
   public function __call($function, $arguments)
   {
        $functions = array_merge($this->engines, $this->resources);

        if (! in_array($function, $functions)) {
            $message = "Invalid engine / resource name $function. Please check the API Reference to get the appropriate engine / resource name.";
            
            throw new SerpApiException($message);
        }
        
        $engineClassName = __NAMESPACE__ . "\\$function";
        $resourceID = !empty($arguments) ? $arguments[0] : null;
        $resource = new $engineClassName($resourceID);

        return $resource;
    }
      
   /**
    * config
    *
    * @param  mixed $config
    * @return SerpAPI
    */
   public static function config($config)
   {
       self::$config = array();
       
        foreach ($config as $key => $value) {
            self::$config[$key] = $value;
        }
        
        if (isset($config['Curl']) && is_array($config['Curl'])) {
            CurlRequest::config($config['Curl']);
        }
        
        return new SerpAPI;
   }
}