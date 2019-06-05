<?php
    //php composer autoload
    require dirname(__DIR__) . '\vendor\autoload.php';
class Authentication extends DatabaseConnector{
    
    

    private $conn ;
    private $database;
    /***
     * 
     * Database Connector Accepts one argument
     * as a database connector type for constructor
     *  available connector are
     * 
     *  @params MongoDB
     *  @params Mysqli 
     * 
     * must be case senstive
     * Default Database Connector is MongoDB
     */
    function __construct(){
        parent::__construct('MongoDB');
        DatabaseConnector::selectDatabase(DB_DATABASE);

        $this->conn = DatabaseConnector::getDataBaseConnection();
        $this->database = DatabaseConnector::getDatabase();
    }


    /**
     * Login adaptor function
     *
     * @return boolean
     */
    public function login(array $data , $table){
        if( !is_array($data) && is_null($table))
            return false;
    } 


    /**
     * 
     * 
     * registers a new user
     * @param array $data
     * @param [type] $table
     * @param boolean $option
     * @return void
     */
    public function register( array $data , $table , $option = false){
        if(!is_array($data) && is_null($table))
            return false;
        
            if(  $this->insert($data,$table , $option))
                return true;

        return false;
    }



    /**
     * Updates Users Details
     *
     * @param array $data
     * @param [type] $table
     * @param boolean $option
     * @return void
     */
   public function updateUser( array $condition , array $replacement,  $table , array $option){
       if(!is_array($condition) && is_null($table))
            return false;
            if( $result = $this->update($condition , $replacement , $table , $option))
                return $result;

        return false;
    }
    

    /**
     * 
     * Delete Users From Database
     *
     * @param array $data
     * @param [type] $table
     * @return void
     */
    public function deleteUser( array $data , $table ){
       if(!is_array($data) && is_null($table))
            return false;
        
            if(  $this->delete($data,$table))
                return true;

        return false;
    }
    

    /**
     * 
     * Select user from database
     *
     * @param array $data
     * @param [type] $table
     * @param boolean $option assign true if you want to select many users for MongoDB only
     * @return void
     */
    public function selectUser( array $data , $table , array $option = []){
       if(!is_array($data) && is_null($table))
            return false;
        
            if(  $result = $this->select($data,$table , $option))
                return $result;

        return false;
    }


    /**
     * update user Session ID using sessionID parsing from cookie available in table
     *
     * @param [type] $sessionId
     * @param [type] $newValue
     * @return void
     */
    public function updateSession($sessionId , $newValue){
        if(is_null($sessionId) && is_null($newValue))
            return false;


        $query = $this->updateUser(

                    array(
                        "sessionID" => $sessionId
                    ),
                    array(
                        "sessionID" => $newValue
                    ),
                    'Clients',
                    [   
                        true,
                        array(
                            '$upsert' => false
                        )
                    ]
               );  

               if($query['Modified'] >= 1){
                    return $query['Modified'];
               }

        return -1;
    }


    /**
     * update SessionID from Clients table using userId
     *
     * @param [type] $userId
     * @param [type] $newValue
     * @return void
     */
     public function updateSessionByUserId($userId , $newValue){
        if(is_null($userId) && is_null($newValue))
            return false;


        $query = $this->updateUser(

                    array(
                        "_id" => $this->generateId($userId)
                    ),
                    array(
                        "sessionID" => $newValue
                    ),
                    'Clients',
                    [   
                        true,
                        array(
                            '$upsert' => true
                        )
                    ]
               );  
               
               if($query['Modified'] >= 1){
                    return $query['Modified'];
               }

        return -1;
    }

    
    /**
     * verifies token is it exists on database
     *
     * @param [type] $token
     * @return void
     */
    public function verifyToken($token){
        if(is_null($token))
            return false;

        $tokenV = "";

           $query = $this->select(

                array(
                    "consumer_key" => $token
                ),
                'Clients',
                [
                    'projection' => [
                        '_id' => 0,
                        'consumer_key' => 1
                    ],
                    'limit' => 1

                ]
            );
                foreach ($query as $user ) {
                    $tokenV = $user['consumer_key'];
                }
                if($token == $tokenV){
                    return true;
                }

        return false;
    }
    

    /**
     * submit widget form before start chatting
     *
     * @param array $data
     * @param [type] $table
     * @return void
     */
    public function submitChatForm(array $data , $table , arrray $option){
        if(!is_array($data))
            return false;

        $query = $this->register($data , $table, $option);

          foreach ($query as $users) {                        
                        if( sizeof($users) - 1 >= 1){
                            return true;   
                        }
                    }
        return false;
    }

    /**
     * 
     * generate Id for use
     * @param [type] $id
     * @return void
     */
    public function generateUserId($id){
        return $this->generateId($id); 
    }

}

// $insert = $d->insert(
//     array(
//         ["_id"=> 28,"name"=>"joe"],
//         ["_id"=> 91,"name"=>"james"]
//     ),
//     'Clients',
//     true
// );


// $update =  $d->delete(
//     [
//         '_id' => 901
//     ],
//         'Clients'
// );


// $f = $d->select(
//     array(
        
//     ),
//     'Clients',
//     [
//         'sort' => [
//             'name' => 1
//         ],
//         'projection' => [
//             '_id' => 1,
//             'name'=> 1
//         ],
//         'limit' => 0
//     ]

// );

// foreach ($f as $key) {
//     var_dump($key);
// }

// var_dump($update);



?>