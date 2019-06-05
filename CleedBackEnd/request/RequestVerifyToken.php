<?php
session_start();
require dirname(__DIR__) . '\vendor\autoload.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $Auth = new Authentication;
        if(isset($_POST['accessToken']) && isset($_POST['verifyToken'])){
            if($_POST['accessToken'] != "" && $_POST['verifyToken'] !== false  ){
               
               $token = $_POST['accessToken'];
               $query = $Auth->verifyToken($token);

               if($query){
                   echo json_encode(["status" => SUCCESS]);
               }else{
                   echo json_encode(["status" => ERROR_E]);
               }

            }else{
                echo json_encode(["status" => ERROR_E]);
            }
        }
    }
?>