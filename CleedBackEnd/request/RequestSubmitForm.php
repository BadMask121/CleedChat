<?php
session_start();
require dirname(__DIR__) . '\vendor\autoload.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $Auth = new Authentication;
        if(isset($_POST['formName']) && isset($_POST['formEmail']) && isset($_POST['formMessage'])){
            if($_POST['formName'] != "" && $_POST['formEmail'] !="" && $_POST['formMessage'] !=""){
               
               $formName = $_POST['formName'];
               $formEmail = $_POST['formEmail'];
               $formMessage = $_POST['formMessage'];

               $formData = array(
                    "formName" => $formName,
                    "formEmail" => $formEmail,
                    "formMessage" => $formMessage
               );
               $query = $Auth->submitChatForm(
                   $formData ,
                   'ClientsCustomers' , 
                        [
                            'projection' => [
                                '_id' => 1,
                                'email'=> 1
                            ]
                        ]
                    );

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