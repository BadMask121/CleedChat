<?php
session_start();
require dirname(__DIR__) . '\vendor\autoload.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $Auth = new Authentication;
        if(isset($_POST['checkSession']) === TRUE && isset($_POST['sessionID']) != ""){

            $sessionID = $_POST['sessionID'];
            $userSessionID = ""; 
            $query = $Auth->select(

                array(
                    "sessionID" => $sessionID
                ),
                'Clients',
                [
                    'projection' => [
                        '_id' => 0,
                        'sessionID' => 1
                    ],
                    'limit' => 1

                ]
            );
                foreach ($query as $user ) {
                       if(!is_null($user['sessionID'])){ $userSessionID = $user['sessionID'];}
                }
                if($sessionID == $userSessionID){
                    echo json_encode(["status" => SUCCESS]);
                    exit;
                }
                echo json_encode(["status" => ERROR_E]);
                exit;
        }
    }
?>