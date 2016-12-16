<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice Message API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Message extends Voice {
    /*
    * capture say and to when class is initialized
    *
    * @param    object  say     say object
    * @param    string  to      to address
    */
    public function __construct($say, $to) {
        $this->params['say'] = $say;
        $this->params['to'] = $to;
    }
    
    /*
    * get object
    *
    * @return   array   params  stored parameters
    */
    public function getObject() {
        // loop params
        foreach($this->params as $k => $v){
            // check if value is an object
            // and value has getObject method
            if(is_object($this->params[$k]) && method_exists($v, 'getObject')) {
                // store it to params
                $this->params[$k] = $v->getObject();
            }
        }
        
        // check if say is set
        if(!isset($this->params['say']) || !$this->params['say']) {
            // throw an exception
            throw new \Exception('Say is required');
        }
        
        // check if to is set
        if(!isset($this->params['to']) || !$this->params['to']) {
            // throw an exception
            throw new \Exception('To is required');
        }
        
        // check if name is set
        if(!isset($this->params['name']) || !$this->params['name']) {
            // throw an exception
            throw new \Exception('Name is required');
        }
        
        // return params
        return $this->params;
    }
}
