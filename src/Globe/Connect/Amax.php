<?php

namespace Globe\Connect;

use Globe\Core\Base;
use Globe\Core\Curl;

/*
* Amax API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/
class Amax extends Base {
    const REWARD_URL = 'https://devapi.globelabs.com.ph/rewards/v1/transactions/send';

    protected $required = array('token', 'address', 'promo');
    
    /*
    * capture key and secret when class is being instanciated
    *
    * @param    string  key     app id
    * @param    string  secret  app secret
    */
    public function __construct($key,  $secret) {
        $this->params['key'] = $key;
        $this->params['secret'] = $secret;
    }
    
    /*
    * send amax reward
    *
    * @return   string(json)    response
    */
    public function sendReward() {
        // loop all required fields
        foreach($this->required as $v) {
            // check if all required fields are set
            if(!isset($this->params[$v])) {
                // throw exception if a required field is not set
                throw new \Exception('`' . $v . '` is required.');
            }
        }
        
        // prepare request payload
        $payload = array('outboundRewardRequest' => array(
            'app_id'        => $this->params['key'],
            'app_secret'    => $this->params['secret'],
            'reward_token'  => $this->params['token'],
            'address'       => $this->params['address'],
            'promo'         => $this->params['promo']));
        
        // request payload should be a json string
        $payload = json_encode($payload);
        
        // initialize custom curl
        $curl = new Curl();
        // prepare post request
        $curl->post(self::REWARD_URL, $payload);
        // set request json header
        $curl->setHeader(array('Content-type: application/json'));
        // return curl response
        return $curl->exec();
    }
}

