<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice Wait API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Wait extends Voice {
    /*
    * capture milliseconds when class is instanciated
    *
    * @param    string  milliseconds
    */
    public function __construct($milliseconds) {
        $this->params['milliseconds'] = $milliseconds;
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
        
        // check if milliseconds is not set
        if(!isset($this->params['milliseconds']) || !$this->params['milliseconds']) {
            // throw an exception
            throw new \Exception('Milliseconds is required');
        }
        
        // return params
        return $this->params;
    }
}
