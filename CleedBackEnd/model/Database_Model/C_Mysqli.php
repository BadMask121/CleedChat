<?php
    //php composer autoload
    require dirname(dirname(__DIR__)) . '\vendor\autoload.php';

class C_Mysqli {


    /**
     * 
     *
     * @var conn stores connection from @class DatabaseConnector 
     *  and use @var conn for operations in C_Mysqli
     */
    private $conn = null;
    function __construct($args){
        
        $conn = $args[0];


        if(!is_null($conn))
        $this->conn = $conn;
    }



}

