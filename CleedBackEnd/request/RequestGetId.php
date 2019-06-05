<?php
session_start();
require dirname(__DIR__) . '\vendor\autoload.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $Auth = new Authentication;

        /**
         * 
         * getUserID by Email from database
         */
        if(isset($_POST['requestID']) && isset($_POST['email'])){
            if($_POST['requestID'] == true && $_POST['email'] != "" ){
                $email = $_POST['email'];
                $query = $Auth->select(

                    array(
                        "email" => $email
                    ),
                    'Clients',
                    [
                        'projection' =>[
                            '_id' => 1
                        ],
                        'limit' => 1
                    ]
                );

                foreach ($query as $doc) {
                    $id = (string) $doc['_id'];
                    echo json_encode([ "status" => SUCCESS ,  "id" => $id  ]);
                }
            }else{
                echo json_encode(ERROR_E);
            }
        }
    }
?>