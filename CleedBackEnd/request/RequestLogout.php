<?php
session_start();
require dirname(__DIR__) . '\vendor\autoload.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $Auth = new Authentication;
    if(isset($_POST['logoutSession']) == TRUE && isset($_POST['sessionID'])){
        if($_POST['sessionID'] != ""){
            $sessionID = $_POST['sessionID'];
            $query = $Auth->updateSession($sessionID, null);
            if($query >= 1){
                echo json_encode(["status" => SUCCESS]);
            }else{
                echo json_encode(["status" => ERROR_E]);
            }
        }
        else{
                echo json_encode(["status"=>ERROR_E]);
                exit;
            }
        }

    }

?>