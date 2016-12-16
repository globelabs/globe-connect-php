<?php

namespace Globe\Core;

/*
* Base class for Globe API
*
* @vendor   Globe
* @package  Globe Api
* @author   Clark Galgo <cgalgo@openovate.com>
*/

class Base {
    protected $params = [];
    /*
    * meant for setter and getter
    *
    * @return       object      this
    */
    public function __call($name, $value) {
        // check if setter
        if(strpos($name, 'set') === 0 &&
            preg_match('/[A-Z]/', $name[3])) {
            
            // process variable name and value
            return $this->setVariable($name, $value[0]);
        }

        
        if(strpos($name, 'get') === 0 &&
            preg_match('/[A-Z]/', $name[3])) {
            
            return $this->getVariable($name);
        }

        throw new \Exception('Cannot call method '.$name);
    }
    
    /*
    * variable setter
    *
    * @param    string  name    variable name
    * @param    string  value   variable value
    * @return   object  this
    */
    protected function setVariable($name, $value) {
        // remove set on variable name
        $name = preg_replace('/^set/', '', $name);
        // prepare variable name
        $name = $this->toVarName($name);
        // store value
        $this->params[$name] = $value;
        // return this
        return $this;
    }

    /*
    * variable getter
    *
    * @param    string  name
    * @return   string  value
    */
    protected function getVariable($name) {
        // remove get on variable name
        $name = preg_replace('/^get/', '', $name);
        // prepare variable name
        $name = $this->toVarName($name);
        // check if variable is set
        if(!isset($this->params[$name])) {
            // throw exception
            throw new \Exception('Undefined variable ' . $name);
        }
        
        // return variable value
        return $this->params[$name];
    }
    
    /*
    * convert string to variable name
    *
    * @param    string  name    string to convert to variable name
    * @return   string  name    variable name
    */
    protected function toVarName($name) {
        // add `_` to before every capilalize character
        $name = preg_replace('/[A-Z]/', '_\0', $name);
        // lower all characters
        $name = strtolower($name);
        // remove the first `_`
        $name = preg_replace('/^\_/', '', $name);
        
        // return constructed variable name
        return $name;
    }

    
}
