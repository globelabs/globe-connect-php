<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice Machine Detection API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class MachineDetection extends Voice {
    /*
    * get object
    *
    * @return   array   string  stored parameters
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

        // return params
        return $this->params;
    }
}
