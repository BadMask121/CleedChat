<?php

    //php composer autoload
    require dirname(dirname(__DIR__)) . '\vendor\autoload.php';



    /**
     * 
     * Adaptor Class for MongoDB 
     */
class C_MongoDB extends DatabaseConnector{


    /**
     * 
     *
     * @var conn stores object connection from @class DatabaseConnector 
     *  and use @var conn for operations in C_MongoDB 
     */
    private $conn = null;


    /**
     * 
     * @var database stores object of selected MongoDB database
     */
    private $database = null;


    //set lastInsertId
    protected $getLastInsertedId;


    function __construct($args){
        $conn = $args[0];
        if(!is_null($conn))
        $this->conn = $conn;
    }


    
    /** @method  createDatabase(@param db_name) creates a new database
     * 
      */
    public function createDatabase($db_name){
        if(is_null($db_name) || $this->db_exist($db_name)) //if database doesnt exist return false
           return false;

        $this->database = $this->conn->$db_name->createCollection("test");
        return true;
    }

    /** @method  selectDatabase(@param db_name) uses a database nam
     * 
      */
    public function selectDatabase($db_name){
        if(is_null($db_name) || !$this->db_exist($db_name) )
            return false;
            
        $this->database = $this->conn->$db_name;
        return $this->database;
    }




    /**
     * 
     * 
     *
     * @param [type] $collectionName
     * @param array $options contains conditions for the collections e.g capped collections settings
     * @return false if database hasnt not been selected
     * @return true creates Collections if database is selected
     *  
     */
    public function createCollection($collectionName, array $options = null){
        if(is_null($this->database) || !$this->db_exist($this->database))
            return false;


        !is_null($options) ? $this->database->createCollection($collectionName,$options) : $this->database->createCollection($collectionName);
     
        return true;
    }




    /**
     *
     *
     * @param array $object is the data to be inserted into database 
     * @param [type] $collection to be inserted into
     * @param boolean $insertMany true is inserted object should be many
     * @return void
     * 
     * 
     */
    public function insert(array $object = null, $collection = null , $insertMany = false ){
        if(is_null($collection) && is_null($object) || !$this->db_exist($this->database))
            return false;
        
        $insertMany ?  
        $res = $this->database->$collection->insertMany($object) :
        $res = $this->database->$collection->insertOne($object);
        
        if($res->getInsertedCount() >= 1 ){

            $end;

            $insertMany ? 
                 $end = $res->getInsertedIds():
                 $end = $res->getInsertedId() ;
            
            $insertMany ?
                $this->getLastInsertedId =  end($end) :
                $this->getLastInsertedId =  $end;
            
            $insertMany ?
                reset($end) :
                null ;
            
            return true;
        }

        return false;
    }

    /**
     * search mongodb documents for the array elements
     *
     * @return found elements
     */
    public function find(array $object , $collection = null , array $options = [] ){
        if(is_null($collection) && is_null($object) || !$this->db_exist($this->database))
            return false;

        $document = $this->database->$collection->find($object , $options) ;
        return $document;
    }

    
    /**
     * Update data on Collection
     *
     * @param array $object
     * @param array $replacement
     * @param [type] $collection
     * @param mixed $many to update more than one matched field
     * @return void
     */
    public function update(array $object , array $replacement,  $collection = null , array $option){
        if(is_null($collection) && is_null($object) || !$this->db_exist($this->database))
            return false;

        $option[0] ? 
        $document = $this->database->$collection->updateMany($object , [ 
            '$set' => $replacement
        ],$option[1]) :
        $document = $this->database->$collection->updateOne($object , [ 
            '$set' => $replacement
        ],$option[1]) 
        ;

        return [
            "Match" => $document->getMatchedCount(),
            "Modified" => $document->getModifiedCount()
        ];
    }
    
    /**
     * delete data on Collection
     *
     * @param array $object
     * @param [type] $collection
     * @param  $many to delete more than one matched field
     * @return void
     */
    public function delete(array $object = null ,  $collection = null , $many = false){
        if(is_null($collection) && is_null($object) || !$this->db_exist($this->database))
            return false;
 
        $many ? 
        $document = $this->database->$collection->deleteMany($object) :
        $document = $this->database->$collection->deleteOne($object) 
        ;

        return [
            "Deleted" => $document->getDeletedCount()
        ];
    }



    //ensureIndex function for MongoDB indexing
    public function ensureIndex(array $object , $collection){
        if(!is_array($object))
            return false;
        $document = $this->database->$collection->ensureIndex($object);
        return true;
    }  
    //returns last inserted Id
    public function getLastInsertedId(){
        return $this->getLastInsertedId;
    }


    //returns the seletec database object
    public function getDatabase(){
        return $this->database;
    }
    /**
     * 
     * generate MongoDb ObjectId for use
     * @param [type] $id
     * @return void
     */
    public function generateObjectId($id = null){
        return new MongoDB\BSON\ObjectID( $id ); 
    }


    /**
     * 
     * 
     *
     * @param [type] $db_name
     * @return false if database $db_name doesnt exist
     * @return true if database with the @param $db_name is found
     */
    private function db_exist($db_name){
        foreach ($this->conn->listDatabases() as $key) {
            if ($key->getName() == $db_name)
                return true;   
        }

        return false;
    }
    
}

