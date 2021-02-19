<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppException
 *
 * @author Dani
 */
class AppException extends Exception{
    public function __construct($message, $code, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    
    public function __toString(){
        return __CLASS__.": [{$this->code}]: {$this->message}<br>";
    }
}
