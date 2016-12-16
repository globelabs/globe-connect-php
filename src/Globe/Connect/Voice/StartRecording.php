<?php

namespace Globe\Connect\Voice;

use Globe\Connect\Voice;

/*
* Voice StartRecording API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class StartRecording extends Voice {
    /*
    * capture url when class is instantiated
    *
    * @param    string  url
    */
    public function __construct($url) {
        $this->params['url'] = $url;
    }

    /*
    * get object
    *
    * @return   array   param
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

        // check if url is not set
        if(!isset($this->params['url']) || !$this->params['url']) {
            // thow an exception
            throw new \Exception('Url is required');
        }
        
        // return params
        return $this->params;
    }
}
