<?php

namespace Globe\Connect;

use Globe\Core\Base;
use Globe\Core\Curl;
/*
* Payment API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/
class Payment extends Base {
    
    const CHARGE_URL = 'https://devapi.globelabs.com.ph/payment/v1/transactions/amount?access_token=%s';
    const REFCODE_URL = 'https://devapi.globelabs.com.ph/payment/v1/transactions/getLastRefCode?app_id=%s&app_secret=%s';
    
    protected $paymentRequired = array('end_user_id', 'amount', 'description', 'reference_code', 'transaction_operation_status');
    protected $lastRefRequired = array('app_key', 'app_secret');

    /*
    * capture token when class is instanciated
    *
    * @param    string  token   access token
    */
    public function __construct($token) {
        $this->params['token'] = $token;
    }
    
    /*
    * send payment request
    *
    * @return   string  response    curl response
    */
    public function sendPaymentRequest() {
        // initialize payload
        $payload = array();
        // loop required fields
        foreach($this->paymentRequired as $v) {
            // check if required fields are set
            if(!isset($this->params[$v])) {
                // throw exception if a required field is not set
                throw new \Exception('`' . $v . '` is required');
            }
            
            // compose payload
            $payload[$v] = $this->params[$v];
        }
        
        // prepare request url
        $url = sprintf(self::CHARGE_URL, $this->params['token']);
        // convert payload to query string
        $payload = http_build_query($payload);
        
        // intiailize curl
        $curl = new Curl();
        // prepare post request
        $curl->post($url, $payload);
        // return curl response
        return $curl->exec();
    }

    /*
    * get last payment reference code
    *
    * @return   string(json)    response    curl response
    */
    public function getLastReferenceCode() {
        // loop all required fields
        foreach($this->lastRefRequired as $v) {
            // check if required fields are set
            if(!isset($this->params[$v])) {
                // throw exception if a required field is not set
                throw new \Exception('`' . $v . '` is required');
            }
            
            // prepare request url
            $url = sprintf(self::REFCODE_URL, $this->params['app_key'], $this->params['app_secret']);

            // intiailize curl
            $curl = new Curl();
            // prepare get request
            $curl->get($url);
            // return curl response
            return $curl->exec();
        }
    }
}
