<?php

namespace Globe\Connect;

use Globe\Core\Base;
use Globe\Core\Curl;

/*
* Subscriber API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/
class Subscriber extends Base {
    const BALANCE_URL = 'https://devapi.globelabs.com.ph/location/v1/queries/balance?access_token=%s&address=%s';
    const RELOAD_URL = 'https://devapi.globelabs.com.ph/location/v1/queries/reload_amount?access_token=%s&address=%s';
    /*
    * capture token when class is instanciated
    *
    * @param    string  token   access token
    */
    public function __construct($token) {
        $this->params['token'] = $token;
    }

    /*
    * get reload amount
    *
    * @return   string(json)    response    curl response
    */
    public function getReloadAmount() {
        // check if address is set
        if(!isset($this->params['address'])) {
            // throw exception if address is not set
            throw new \Exception('`address` is required.');
        }
        
        // prepare request url
        $url = sprintf(self::RELOAD_URL, $this->params['token'], $this->params['address']);
        
        // intialize curl
        $curl = new Curl();
        // prepare get request
        $curl->get($url);
        // return curl response
        return $curl->exec();
    }
    
    /*
    * get subscriber balance
    *
    * @return   string(json)    response    curl response
    */
    public function getSubscriberBalance() {
        // check if address is set
        if(!isset($this->params['address'])) {
            // throw exception if address is not set
            throw new \Exception('`address` is required.');
        }
        
        // prepare request url
        $url = sprintf(self::BALANCE_URL, $this->params['token'], $this->params['address']);
        
        // intialize curl
        $curl = new Curl();
        // prepare get request
        $curl->get($url);
        // return curl response
        return $curl->exec();
    }
}
