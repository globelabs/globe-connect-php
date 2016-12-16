<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice Transcription API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Transcription extends Voice {
    /*
    * capture milliseconds when class is instanciated
    *
    * @param    string  milliseconds
    */
    public function __construct($id) {
        $this->params['id'] = $id;
    }
    
    /*
    * get object
    *
    * @return   array   params
    */
    public function getObject() {
        // loop params
        foreach($this->params as $k => $v){
            // check if value is an object
            // and has getObject method
            if(is_object($this->params[$k]) && method_exists($v, 'getObject')) {
                // store to params
                $this->params[$k] = $v->getObject();
            }
        }
        
        // check if id is not set
        if(!isset($this->params['id']) || !$this->params['id']) {
            // throw an exception
            throw new \Exception('ID is required');
        }
        
        // return params
        return $this->params;
    }
}
