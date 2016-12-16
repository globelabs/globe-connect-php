<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice Conference API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Conference extends Voice {
    /*
    * capture id when class is initialized
    *
    * @param    string  id  conference id
    */
    public function __construct($id) {
        $this->params['id'] = $id;
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
            // and value has getObject method
            if(is_object($this->params[$k]) && method_exists($v, 'getObject')) {
                // store it to params
                $this->params[$k] = $v->getObject();
            }
        }
        
        // check if id is set
        if(!isset($this->params['id']) || !$this->params['id']) {
            // throw an exception
            throw new \Exception('Id is required');
        }

        // check name if set
        if(!isset($this->params['name']) || !$this->params['name']) {
            // throw an exception
            throw new \Exception('Name is required');
        }

        // return params
        return $this->params;
    }
}
