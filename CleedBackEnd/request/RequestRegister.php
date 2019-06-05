    <?php
    session_start();
    require dirname(__DIR__) . '\vendor\autoload.php';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $Auth = new Authentication;
            if(array_key_exists("email",$_POST) && array_key_exists("password",$_POST) && array_key_exists("fullname",$_POST)){

            
                if($_POST['email'] !="" && $_POST['password'] !="" && $_POST['fullname'] !="" ){

                    $fullname = $_POST['fullname'];
                    $email = $_POST['email'];
                    $password = $_POST['password']; 

                    //validate email on serverside
                    if(!Utility::validateEmail($email)){
                        echo json_encode(ERROR_EMAIL);
                        exit;
                    }
                    if(strlen($password) < 6 ){
                        echo json_encode(ERROR_PASSWORD);
                        exit;
                    }

                    /**
                     * 
                     * assigna random String to an encrypted version of PKEY
                     * and assign a encrypted private key;
                     */
                    $privateKey = Utility::encrypt( PKEY, Utility::encrypt($password , PKEY));

                    // assign an encrypted version of inputed password using @var privateKey
                    $encPassword = Utility::encrypt($password , $privateKey);

                    /**
                     * 
                     * @var consumerKey encrypts a version of our @var encpassword with @var privatekey
                     * to get a unique consumerKey  for Api Authorisation 
                     */
                    $consumerKey =  Utility::encrypt($encPassword , $privateKey);



                    /**
                     * @var consumerSecret uses a combination of @var consumerKey and @var encpassword (as PrivateKey)
                     * to get a unique consumerSecret for Api Authorisation 
                     */
                    $consumerSecret = Utility::encrypt($consumerKey , $encPassword);


                    /**
                     * assign @var callbackUrl = null 
                    */
                    $callbackUrl = null;

                    $checkUser = $Auth->selectUser(
                        array(
                            "email" => $email
                        ),
                        'Clients',
                        [
                            'projection' => [
                                '_id' => 1,
                                'email'=> 1
                            ]
                        ]
                    );

                    foreach ($checkUser as $users) {                        
                        if( sizeof($users) - 1 >= 1){
                            echo json_encode(ERROR_REGISTERED);
                            exit;
                        }
                    }

                    
                     /**
                      * @var register signs up users
                      */
                    $register = $Auth->register([
                    "fullname"        => $fullname,
                    "email"           => $email,
                    "password"        => $encPassword,
                    "consumer_key"    => $consumerKey,
                    "consumer_secret" => $consumerSecret,
                    "private_key"     => $privateKey,
                    "callback_url"    => $callbackUrl,
                    "created_date"    =>  date(DATE_RFC822)
                    ] , "Clients");



                    //check if inserted
                    if($register){
                           $_SESSION['user'] = "active";
                           $_SESSION['email'] = $email;
                        echo json_encode(SUCCESS);
                    }else{
                        echo json_encode(ERROR_E);
                    }
                }
            }
        }
    ?>