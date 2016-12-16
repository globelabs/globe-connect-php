<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice Redirect API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Redirect extends Voice {
    /*
    * capture to when class is instanciated
    *
    * @param    string  to  to address
    */
    public function __construct($to) {
        $this->params['to'] = $to;
    }

    /*
    * get object
    *
    * @return   array   param   stored parameters
    */
    public function getObject() {
        // loop params
        foreach($this->params as $k => $v){
            // check if value is an object
            // and getObject method exists
            if(is_object($this->params[$k]) && method_exists($v, 'getObject')) {
                // store to params
                $this->params[$k] = $v->getObject();
            }
        }
        
        // check if params is set
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
