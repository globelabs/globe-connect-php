<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice Ask API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Ask extends Voice {
    /*
    * capture say when class is initialize
    *
    * @param    object  say     say object
    */
    public function __construct($say) {
        $this->params['say'] = $say;
    }
    
    /*
    * get object
    *
    * @return   array   params      array of parameters
    */
    public function getObject() {
        // loop parameters
        foreach($this->params as $k => $v){
            // check if value is an object
            // and if getObject method exists
            if(is_object($this->params[$k]) && method_exists($v, 'getObject')) {
                // call get object and store it to params
                $this->params[$k] = $v->getObject();
            }
        }
        
        // check if choices is set
        if(!isset($this->params['choices']) || !$this->params['choices']) {
            // throw exception
            throw new \Exception('Choices is required');
        }
        
        // check if say is set
        if(!isset($this->params['say']) || !$this->params['say']) {
            // throw exception
            throw new \Exception('Say is required');
        }
        
        // return params
        return $this->params;
    }
}
