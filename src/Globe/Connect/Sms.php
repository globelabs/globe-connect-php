<?php
namespace Globe\Connect;

use Globe\Core\Base;
use Globe\Core\Curl;

/*
* SMS API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/
class Sms extends Base {
    const SEND_URL = 'https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/%s/requests?access_token=%s';
    const BINARY_URL = 'https://devapi.globelabs.com.ph/binarymessaging/v1/outbound/%s/requests?access_token=%s';
    
    protected $smsRequired = array('message', 'receiver_address');
    protected $binaryRequired = array('user_data_header', 'data_encoding_scheme', 'receiver_address', 'message');
    
    /*
    * capture shortcode and token when class is instanciated
    *
    * @param    string  sender  shortcode
    * @param    string  token   access token
    */
    public function __construct($sender, $token) {
        $this->params['sender'] = $sender;
        $this->params['token'] = $token;
    }
    
    /*
    * send sms
    *
    * @return   string(json)    response    curl response
    */
    public function sendMessage() {
        // prepare request url
        $url = sprintf(self::SEND_URL, $this->params['sender'], $this->params['token']);
        
        // loop sms required fields
        foreach($this->smsRequired as $v) {
            // check if required fields are set
            if(!isset($this->params[$v])) {
                // throw new exception if a required field is not set
                throw new \Exception('`'. $v .'` is required.');
            }
        }
        
        // prepare request payload
        $payload = array('outboundSMSMessageRequest' => array(
            'senderAddress' => $this->params['sender'],
            'outboundSMSTextMessage'    => array(
                'message'   => $this->params['message']),
            'address'       => $this->params['receiver_address']));
        
        // if client correlator is set
        if(isset($this->params['client_correlator'])) {
            // include client correlator to payload
            $payload['outboundSMSMessageRequest']['clientCorrelator'] = $this->params['client_correlator'];
        }
        
        // payload must be json
        $payload = json_encode($payload);
        
        // intialize custom curl
        $curl = new Curl();
        // set request header as json
        $curl->setHeader(array('Content-type: application/json'));
        // prepare post request
        $curl->post($url, $payload);
        // return curl response
        return $curl->exec();
    }

    /*
    * send binary message
    *
    * @return   string(json)    response    curl response
    */
    public function sendBinaryMessage() {
        // prepare request url
        $url = sprintf(self::BINARY_URL, $this->params['sender'], $this->params['token']);
        
        // loop binary required
        foreach($this->binaryRequired as $v) {
            // check if required fields are set
            if(!isset($this->params[$v])) {
                // throw exception if a required field is not set
                throw new \Exception('`'. $v .'` is required.');
            }
        }
        
        // prepare request payload
        $payload = array('outboundBinaryMessageRequest' => array(
            'userDataHeader'        => $this->params['user_data_header'],
            'dataEncodingScheme'    => $this->params['data_encoding_scheme'],
            'address'               => $this->params['receiver_address'],
            'outboundBinaryMessage' => array(
                'message'   => $this->params['message']),
            'senderAddress'         => $this->params['sender'],
            'access_token'          => $this->params['token']));
        
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
}
