<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice LeavePrompt API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class LeavePrompt extends Voice {
    /*
    * capture value when class is initialized
    *
    * @param    string  value
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
            // check value if object
            // and has getObject method
            if(is_object($this->params[$k]) && method_exists($v, 'getObject')) {
                // store it to params
                $this->params[$k] = $v->getObject();
            }
        }
        
        // check if value is set
        if(!isset($this->params['value']) || !$this->params['value']) {
            // throw an exception
            throw new \Exception('Value is required');
        }
        
        // return params
        return $this->params;
    }
}
