<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice Say API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Say extends Voice {
    /*
    * capture value when class is instanciated
    *
    * @param    string  value
    */
    public function __construct($value) {
        $this->params['value'] = $value;
    }
    
    /*
    * get object
    *
    * @return   array   say
    */
    public function getObject() {
        // loop params
        foreach($this->params as $k => $v){
            // check if value is an object
            // and has getObject method
            if(is_object($this->params[$k]) && method_exists($v, 'getObject')) {
                // store it to params
                $this->params[$k] = $v->getObject();
            }
        }
        
        // check if value is not set
        if(!isset($this->params['value']) || !$this->params['value']) {
            // throw exception
            throw new \Exception('Value is required');
        }
        
        // check if event is not set
        if(!isset($this->params['event']) || !is_array($this->params['event'])) {
            // return params
            return $this->params;
        }
        
        // initialize say array
        $say = array();
        // loop event
        for($i = 0; $i < count($this->params['event']); $i++) {
            // store to say array
            if(is_object($this->params['event'][$i]) && method_exists($this->params['event'][$i], 'getObject')) {
                $say[$i] = $this->params['event'][$i]->getObject();
                continue;
            }

            $say[$i] = $this->params['event'][$i];
        }
        
        // append value to say variables
        $say[] = array('value' => $this->params['value']);
        // return say
        return $say;
    }
}
