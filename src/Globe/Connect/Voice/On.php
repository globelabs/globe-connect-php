<?php
namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice On API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class On extends Voice {
    /*
    * capture event and say when class is initialized
    *
    * @param    string  event
    * @param    object  say
    */
    public function __construct($event) {
        $this->params['event'] = $event;
    }
        
    /*
    * get object
    *
    * @return   array   params   stored parameters
    */
    public function getObject() {
        // loop params
        foreach($this->params as $k => $v){
            // check if value is an object
            // and has getObject method
            if(is_object($this->params[$k]) && method_exists($v, 'getObject')) {
                // store it to params
                $this->params[$k] = $v->getObject();
            }
        }
        
        // check if event is set
        if(!isset($this->params['event']) || !$this->params['event']) {
            // throw and exception
            throw new \Exception('Event is required');
        }

        return $this->params;
    }
}
