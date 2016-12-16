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
class Ussd extends Base {
    const SEND_USSD = 'https://devapi.globelabs.com.ph/ussd/v1/outbound/%s/send/requests?access_token=%s';
    const REPLY_USSD = 'https://devapi.globelabs.com.ph/ussd/v1/outbound/%s/reply/requests?access_token=%s';
    
    /*
    * capture token and shortcode when class is instanciated
    *
    * @param    string  token       access token
    * @param    string  shortcode   app shortcode
    */
    public function __construct($token, $shortcode) {
        $this->params['token'] = $token;
        $this->params['shortcode'] = $shortcode;
    }
    
    /*
    * send ussd request
    *
    * @return   string(json)    response    curl response
    */
    public function sendUssdRequest() {
        // check if address is set
        if(!isset($this->params['address'])) {
            // throw exception is address is not set
            throw new \Exception('`address` is required.');
        }
        
        // chec if ussd message is set
        if(!isset($this->params['ussd_message'])) {
            // throw exception if ussd message is not set
            throw new \Exception('`ussd_message` is required.');
        }
        
        // check if flash is set
        if(!isset($this->params['flash'])) {
            // throw exception if flash is not set
            throw new \Exception('`flash` is required.');
        }
        
        // prepare request payload
        $payload = array('outboundUSSDMessageRequest' => array(
            'outboundUSSDMessage'   => array(
                'message' => $this->params['ussd_message']),
            'address'               => $this->params['address'],
            'flash'                 => $this->params['flash']));
        
        // prepare request url
        $url = sprintf(self::SEND_USSD, $this->params['shortcode'], $this->params['token']);
        // payload must be json
        $payload = json_encode($payload);
        
        // initialize custom curl
        $curl = new Curl();
        // set request header as json
        $curl->setHeader(array('Content-type: application/json'));
        // prepare post request
        $curl->post($url, $payload);
        // return curl response
        return $curl->exec();
    }

    /*
    * reply ussd request
    *
    * @return   string(json)    response    curl response
    */
    public function replyUssdRequest() {
        // check if session id is set
        if(!isset($this->params['session_id'])) {
            // throw exception if session id is not set
            throw new \Exception('`session_id` is required.');
        }

        // check address if set
        if(!isset($this->params['address'])) {
            // throw exception if address is not set
            throw new \Exception('`address` is required.');
        }
        
        // check ussd message if set
        if(!isset($this->params['ussd_message'])) {
            // throw exception if ussd message is not set
            throw new \Exception('`ussd_message` is required.');
        }
        
        // check flash if set
        if(!isset($this->params['flash'])) {
            // throw exception if flash is not set
            throw new \Exception('`flash` is required.');
        }
        
        // prepare request url
        $url = sprintf(self::REPLY_USSD, $this->params['shortcode'], $this->params['token']);
        // preapare request payload
        $payload = array('outboundUSSDMessageRequest' => array(
            'outboundUSSDMessage'   => array(
                'message' => $this->params['ussd_message']),
            'address'               => $this->params['address'],
            'flash'                 => $this->params['flash'],
            'sessionID'             => $this->params['session_id']));
        
        // payload must be json
        $payload = json_encode($payload);
        
        // initialize custom curl
        $curl = new Curl();
        // prepare post request
        $curl->post($url, $payload);
        // set request header as json
        $curl->setHeader(array('Content-type: application/json'));
        // return curl response
        return $curl->exec();
    }
}
