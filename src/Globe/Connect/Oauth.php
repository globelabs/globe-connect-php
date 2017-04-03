<?php
namespace Globe\Connect;

use Globe\Core\Base;
use Globe\Core\Curl;
/*
* Oauth Api
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/
class Oauth extends Base {
    
    const SUBS_URL  = 'https://developer.globelabs.com.ph/dialog/oauth?app_id=%s';
    const TOKEN_URL = 'https://developer.globelabs.com.ph/oauth/access_token?app_id=%s&app_secret=%s&code=%s';
    
    /* 
    * capture key and secret when class is instanciated
    *
    * @param    string  key     app id
    * @param    string  secret  app secret
    */
    public function __construct($key, $secret) {
        $this->params['key'] = $key;
        $this->params['secret'] = $secret;
    }
    
    /*
    * get authentication url
    *
    * @return   string  url     authentication url
    */
    public function getRedirectUrl() {
        // return url
        return sprintf(self::SUBS_URL, $this->params['key']);
    }

    /*
    * get access token
    *
    * @return   string  token   access token
    */
    public function getAccessToken() {
        // check if code is set
        if(!isset($this->params['code'])) {
            // throw exception if code is not set
            throw new \Exception('`code` is required');
        }
        
        // prepare request url
        $url = sprintf(self::TOKEN_URL, $this->params['key'], $this->params['secret'], $this->params['code']);
        
        // intialize custom curl
        $curl = new Curl();
        // prepare get request
        $curl->post($url);
        // return curl response
        return $curl->exec();
    }
}
