<?php
namespace Globe\Core;

/*
* Custom curl class for Globe Api requests
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Curl extends Base {
    protected $ins;
    
    /*
    * Construct
    */
    public function __construct() {
        // initialize curl
        $this->ins = curl_init();
    }
    
    /*
    * get request
    *
    * @param    string  url     request url
    * @param    string  payload request payload
    * @return   object  this
    */
    public function get($url, $payload = NULL) {
        // check if payload is set
        if($payload) {
            // append payload to the url
            $url .= '?' . $payload;
        }
        
        // set request url
        curl_setopt($this->ins, CURLOPT_URL, $url);
        // return this
        return $this;
    }
    
    /*
    * post request
    *
    * @param    string  url     request url
    * @param    string  payload request payload
    * @return   object  this
    */
    public function post($url, $payload = NULL) {
        // set request url
        curl_setopt($this->ins, CURLOPT_URL, $url);
        // set request as post
        curl_setopt($this->ins, CURLOPT_POST, true);
        
        // check if payload is set
        if($payload) {
            // set payload to curl
            curl_setopt($this->ins, CURLOPT_POSTFIELDS, $payload);
        }
        
        // return this
        return $this;
    }
    
    /*
    * execute curl
    *
    * @return       string(json)    response
    */
    public function exec() {
        // set curl return transfer
        curl_setopt($this->ins, CURLOPT_RETURNTRANSFER, true);
        
        // check if header is set
        if(isset($this->params['header']) && is_array($this->params['header'])) {
            // set header to curl
            curl_setopt($this->ins, CURLOPT_HTTPHEADER, $this->params['header']);
        }
        
        // dont verify ssl
        curl_setopt($this->ins, CURLOPT_SSL_VERIFYPEER, false);
        // execute curl request
        $res = curl_exec($this->ins);
        
        // return response
        return $res;
    }


}
