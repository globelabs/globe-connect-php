<?php

namespace Globe\Connect;

use Globe\Core\Base;
use Globe\Core\Curl;

/*
* Location API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/
class Location extends Base {
    const LOCATION_URL = 'https://devapi.globelabs.com.ph/location/v1/queries/location?access_token=%s&address=%s&requestedAccuracy=%s';
    
    protected $required = array('address', 'requested_accuracy');

    /*
    * capture token when class is instanciated
    *
    * @param    string  token   access token
    */
    public function __construct($token) {
        $this->params['token'] = $token;
        // set requested accuracy to 10 as default
        $this->params['requested_accuracy'] = 10;
    }

    /*
    * get user location
    *
    * return    string(json)    response
    */
    public function getLocation() {
        // loop required fields
        foreach($this->required as $v) {
            // check if required fields are set
            if(!isset($this->params[$v])) {
                // throw exception if a required field is not set
                throw new \Exception('`'. $v .'` is required');
            }
        }
        
        // prepare requestl url
        $url = sprintf(self::LOCATION_URL, $this->params['token'], $this->params['address'], $this->params['requested_accuracy']);
        
        // intialize custom curl
        $curl = new Curl();
        // prepare get request
        $curl->get($url);
        // return curl response
        return $curl->exec();
    }
}
