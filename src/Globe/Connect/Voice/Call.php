<?php
namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice Call API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Call extends Voice {
    /*
    * capture to when class is initialized
    *
    * @param    string  to  call address
    */
    public function __construct($to) {
        $this->params['to'] = $to;
    }
    
    /*
    * get object
    *
    * @return   array   params  array of parameters
    */
    public function getObject() {
        // loop params
        foreach($this->params as $k => $v){
            // check if params is an object
            // and if getMethod exist
            if(is_object($this->params[$k]) && method_exists($v, 'getObject')) {
                // call get object and store it to params
                $this->params[$k] = $v->getObject();
            }
        }
        
        // check if to is set
        if(!isset($this->params['to']) || !$this->params['to']) {
            // throw exception
            throw new \Exception('To is required');
        }
        
        // return params
        return $this->params;
    }
}
