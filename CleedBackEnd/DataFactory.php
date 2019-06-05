<?php

error_reporting(E_ALL);
require __DIR__ . '\vendor\autoload.php';
require __DIR__ . '\vendor\usefulconstant.php';

class DataFactory 
{   
    

    /**
     * 
     * 
     *
     * @var classname defines a class that should be generated
     */

    public static function get($classname = '' , array $args = null){
        switch ($classname) {
            case DATABASE_CONNECTOR:
                return new DatabaseConnector();
                break;
            case C_MONGODB: 
                return new C_MongoDB($args);
                break;  
            case C_MYSQLI: 
                return new C_Mysqli($args);
                break; 
            case AUTHENTICATION:
                return new Authentication;
                break;     
            
            default:
            return false;
                break;
        }
    }

    private static function tolower($str){
        return strtolower($str);
    }
}

