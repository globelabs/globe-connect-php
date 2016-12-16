<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice  Result API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Result extends Voice {
    protected $json = NULL;
    
    /*
    * capture json when class is instanciated
    *
    * @param    string|json     json
    */
    public function __construct($json) {
        $this->json = $json;
    }

    /*
    * get object
    *
    * @return   array   result
    */
    public function getObject() {
        // init obj variable
        $obj = array();
        
        try {
            // try to decode it
            // should throw exception if data is not a valid json string
            $json = json_decode($this->json, true);
        } catch(\Exception $e) {
            // throw exception
            throw new \Exception('Invalid json data');
        }
        
        // if result is not set
        if(!isset($json['result']) || !is_array($json['result'])) {
            // throw an exception
            throw new \Exception('Invalid json data');
        }
        
        // return result
        return $json['result'];
    }
}
