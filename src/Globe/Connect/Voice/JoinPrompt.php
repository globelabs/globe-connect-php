<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice JoinPrompt API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class JoinPrompt extends Voice {
    /*
    * capture value when class is initialized
    */
    public function __construct($value) {
        $this->params['value'] = $value;
    }

    /*
    * get object
    *
    * @return   array   params  stored parameters
    */
    public function getObject() {
        // loop params
        foreach($this->params as $k => $v){
            // check if params is an object
            // and if params has getObject method
            if(is_object($this->params[$k]) && method_exists($v, 'getObject')) {
                // store it params
                $this->params[$k] = $v->getObject();
            }
        }
        
        // check value if set
        if(!isset($this->params['value']) || !$this->params['value']) {
            // throw an exception
            throw new \Exception('Value is required');
        }
        
        // return params
        return $this->params;
    }
}
