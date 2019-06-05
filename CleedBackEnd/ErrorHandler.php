<?php

class ErrorHandler extends Exception{

    
    public $e_debug = false;

    public function E_getMessage(Exception $e){
        return $e->getMessage();
    }
}