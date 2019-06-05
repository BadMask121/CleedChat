<?php
session_start();
require dirname(__DIR__) . '\vendor\autoload.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $Auth = new Authentication;
        if(array_key_exists("email",$_POST) && array_key_exists("password",$_POST)){
              if($_POST['email'] !="" && $_POST['password'] !="" ){

                    $email = $_POST['email'];
                    $password = $_POST['password'];
                 
                    $privatekey = null; 
                    $publicPassword = null; 

                    //validate email on serverside
                    if(!Utility::validateEmail($email)){
                        echo json_encode(ERROR_EMAIL);
                        exit;
                    }
                    if(strlen($password) < 6 ){
                        echo json_encode(ERROR_PASSWORD);
                        exit;
                    }
                    
                    
                    $checkUser = $Auth->selectUser(
                        array(
                            "email"   => $email
                        ),
                         'Clients',
                        [
                            'projection' => [
                                '_id'         => 1,
                                'email'       => 1,
                                'private_key' => 1,
                                'password' => 1
                            ],
                            'limit'      => 1

                        ]
                    );

                    foreach ($checkUser as $user ) {
                        $privatekey = $user['private_key'];
                        $publicPassword = $user['password'];
                    }

                    /**
                     * checks if the @var password encrypted with @var privateKey again
                     * will be equl to the @var publicPassword
                     */      

                        $decrypt = Utility::encrypt($password , $privatekey);
                        if( !is_null($decrypt) && !is_null($publicPassword)){
                            if($decrypt === $publicPassword){
                                
                                $_SESSION['user'] = "active";
                                $_SESSION['email'] = $email;
                                echo json_encode(SUCCESS);
                            }else{
                                echo json_encode(ERROR_E);
                            }
                        }else{
                            echo json_encode(ERROR_E);
                        }
                }
        }
    }
?>