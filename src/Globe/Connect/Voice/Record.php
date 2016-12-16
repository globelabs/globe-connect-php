<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice Record API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Record extends Voice {
    /*
    * capture name and url when class is initialized
    */
    public function __construct($name, $url) {
        $this->params['name'] = $name;
        $this->params['url'] = $url;
    }
    
    /*
    * get object
    *
    * @return   array   params  stored parameters
    */
    public function getObject() {
        // loop params
        foreach($this->params as $k => $v){
            // check if value is object
            // and has getObject method
            if(is_object($this->params[$k]) && method_exists($v, 'getObject')) {
                // store to params
                $this->params[$k] = $v->getObject();
            }
        }
        
        // check if name is set
        if(!isset($this->params['name']) || !$this->params['name']) {
            // throw an exception
            throw new \Exception('Name is required');
        }
        
        // check if url is set
        if(!isset($this->params['url']) || !$this->params['url']) {
            // throw an exception
            throw new \Exception('Url is required');
        }
        
        // return params
        return $this->params;
    }
}
