<?php

namespace Globe\Connect;

use Globe\Core\Base;

/*
* Voice API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Voice extends Base {
    /*
    * ask factory method
    *
    * @param    string  say     say object
    * @return   object  ask     ask object
    */
    public function ask($say) {
        return new Voice\Ask($say);
    }
    
    /*
    * call factory method
    *
    * @param    string  to      to address
    * @return   object  call    call object
    */
    public function call($to) {
        return new Voice\Call($to);
    }
    
    /*
    * choices factory method
    *
    * @param    string  value   choices value
    * @return   object  choices Choices object
    */
    public function choices($value) {
        return new Voice\Choices($value);
    }

    /*
    * conference factory method
    *
    * @param    string  id          conference id
    * @return   object  conference  Conference object
    */
    public function conference($id) {
        return new Voice\Conference($id);
    }

    /*
    * join prompt factory method
    *
    * @param    string  value       join prompt value
    * @return   object  JoinPrompt  JoinPrompt Object    
    */
    public function joinPrompt($value){
        return new Voice\JoinPrompt($value);
    }

    /*
    * leave prompt factory method
    *
    * @param    string  value       leave prompt value
    * @return   object  LeavePrompt LeavePrompt Object    
    */
    public function leavePrompt($value) {
        return new Voice\LeavePrompt($value);
    }

    /*
    * machine detection factory method
    *
    * @return   object  MachineDetection    MachineDetection object
    */
    public function machineDetection() {
        return new Voice\MachineDetection();
    }

    /*
    * message factory method
    *
    * @param    object  say     say object
    * @param    string  to      to address
    * @return   object  Message Message Object
    */
    public function message($say, $to) {
        return new Voice\Message($say, $to);
    }

    /*
    * on factory method
    *
    * @param    string  event   event
    * @return   object  On      On object
    */
    public function on($event) {
        return new Voice\On($event);
    }

    /*
    * record factory method
    *
    * @param    string  name    record name
    * @param    string  url     record url
    * @return   object  Record  Record object
    */
    public function record($name, $url) {
        return new Voice\Record($name, $url);
    }

    /*
    * redirect factory method
    *
    * @param    string  to          to address
    * @return   object  Redirect    redirect object
    */
    public function redirect($to) {
        return new Voice\Redirect($to);
    }
    
    /*
    * result factory method
    *
    * @param    string|json json    json result
    * @return   object      result  result object
    */
    public function result($json) {
        return new Voice\Result($json);
    }

    /*
    * say factory method
    *
    * @param    string      value   say value
    * @return   object      say     say object
    */
    public function say($value) {
        return new Voice\Say($value);
    }
    
    /* 
    * session factory method
    *
    * @param    string|json json    json session
    * @return   object      session session object
    */
    public function session($json) {
        return new Voice\Session($json);
    }
    
    /*
    * start recording factory method
    *
    * @param    string  url             recording url
    * @return   object  StartRecording  startrecording object
    */
    public function startRecording($url) {
        return new Voice\StartRecording($url);
    }
    
    /*
    * transfer factory method
    *
    * @param    sting   to          transfer address
    * @return   object  transfer    transfer object
    */
    public function Transfer($to) {
        return new Voice\Transfer($to);
    }
    
    /*
    * transcription factory method
    *
    * @param    sting   id              transcription id
    * @return   object  transcription   transcription object
    */
    public function Transcription($to) {
        return new Voice\Transcription($to);
    }
    /*
    * get object
    *
    * return    array   params  stored parameters
    */
    public function getObject() {
        return $this->params;
    }
    
    /*
    * to string magic method
    *
    * @return   string|json arr     json encoded parameters
    */
    public function __toString() {
        // get object
        $arr = $this->getObject();
        // encode object
        return json_encode($arr);
    }
    
    /*
    * call magic method
    *
    */
    public function __call($name, $value) {
        // check if method is an adder
        if(strpos($name, 'add') === 0 &&
            preg_match('/[A-Z]/', $name[3])) {
            
            // if param tropo is not set
            if(!isset($this->params['tropo'])) {
                // set it to array
                $this->params['tropo'] = array();
            }
            
            // compose name of parameter
            $name = preg_replace('/^add/', '', strtolower($name));
            
            // check if value with index 0 is an array
            if(!is_array($value[0])) {
                // if not
                if(is_object($value[0]) && method_exists($value[0], 'getObject')) {
                    // try to call getObject method
                    // then set it to value index 0
                    $value[0] = $value[0]->getObject();
                }
            }
            
            // add value to tropo object with name as a key
            $this->params['tropo'][] = array($name => $value[0]);
            // return this
            return $this;
        }
        
        // if method is not an adder
        // return parent __call
        return parent::__call($name, $value);
    }
    
    /*
    * assoc array checker
    *
    * @param    array   arr
    * @return   bool
    */
    protected function isAssoc(array $arr) {
        // if array is empty
        if (array() === $arr) {
            // return false
            return false;
        }
        
        // return
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
