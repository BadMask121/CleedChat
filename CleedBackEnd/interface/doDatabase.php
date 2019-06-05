<?php

interface doDatabase{
          public function insert(array $object = null , $table , array $options = null );
          public function getDatabaseConnection();
          public function getDataBase();
          public function getLastInsertId();
          public function select(array $object = null , $table , array $options = [] );

          const MONGO = "MongoDB";
          const MYSQLI = "Mysqli";
}
header('Content-type:application/json;charset=utf-8');


$data = file_get_contents(dirname(__DIR__) . '\config.json');
$data = get_object_vars(json_decode($data));



$PKEY          = Utility::mtrne(10) ."-".Utility::nrand(6)."-".Utility::mtrne(10)."-".Utility::mtrne(10);   
define('PKEY',$PKEY);

define('DB_INSTANCE', $data['DB_INSTANCE']);
define('DB_HOST'    , $data['DB_HOST']);
define('DB_PORT'    , $data['DB_PORT']);
define('DB_USERNAME', $data['DB_USERNAME']);
define('DB_PASSWORD', $data['DB_PASSWORD']);
define('DB_DATABASE', $data['DB_DATABASE']);


const SUCCESS = "success";


const ERROR_E = "failed";
const ERROR_EMAIL = "errorEmail";
const ERROR_PASSWORD = "errorPassword";
const ERROR_REGISTERED = "errorRegistered";