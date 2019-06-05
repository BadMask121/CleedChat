<?php
session_start();
require dirname(__DIR__) . '\vendor\autoload.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $Auth = new Authentication;
        if(array_key_exists("sessionID" , $_POST) && array_key_exists("userID" , $_POST)){

            if($_POST['userID'] != "" && $_POST['sessionID'] != "" ){
               $userID = $_POST['userID'];
               $sessionID = $_POST['sessionID'];

               $query = $Auth->updateSessionByUserId($userID, $sessionID);
               if($query >= 1){
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