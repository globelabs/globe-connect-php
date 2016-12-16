<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice Session API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Session extends Voice {
    protected $json = NULL;
    
    /*
    * capture json when class is initialize
    *
    * @param    string|json json
    */
    public function __construct($json) {
        $this->json = $json;
    }
    
    /*
    * get object
    *
    * @return   array   obj
    */
    public function getObject() {
        // initialize obj array
        $obj = array();
        try {
            // try to decode data
            $json = json_decode($this->json, true);
        } catch (\Exception $e) {
            // throw an exception
            throw new \Exception('Invalid json data');
        }
        
        // check if session is not set
        if(!isset($json['session'])) {
            // throw exception 
            throw new \Exception('Invalid json data');
        }
        
        // store to obj
        $obj = $json['session'];
        
        $obj['to'] = NULL;
        $obj['from'] = NULL;
        $obj['header'] = NULL;
        $obj['parameters'] = NULL;
        
        // return obj
        return $obj;
    }
}
