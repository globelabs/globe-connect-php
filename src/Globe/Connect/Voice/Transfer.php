<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice Transfer API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Transfer extends Voice {
    /*
    * capture to and name when class is instanciated
    *
    * @param    string  to
    * @param    string  name
    */
    public function __construct($to) {
        $this->params['to'] = $to;
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
                $this->params[$k] = $v->getObject();
            }
        }
        
        // check if to is not set
        if(!isset($this->params['to']) || !$this->params['to']) {
            // throw an exception
            throw new \Exception('To is required');
        }
        
        // check if on is set
        //if(isset($this->params['on']) && is_array($this->params['on'])) {
        //    $this->params['on'] = !$this->isAssoc($this->params['on']) ? implode(',', $this->params['on']) : $this->params['on'];
        //}
        
        // return params
        return $this->params;
    }
}
