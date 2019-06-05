<?php
    include_once dirname(__DIR__) . '\interface\doDatabase.php';

    //php composer autoload
    require dirname(__DIR__) . '\vendor\autoload.php';
    class DatabaseConnector implements doDatabase 
{


    /**
     * 
     *
     * 
     * @var [db_type] for database management libary
     * by default we will be using mongodb but we have an option to set 
     * other database management sys 
     * only Mongodb and Mysql supported for now
     */
    private $db_type = null;


    private $database;

    /***
     * sets the selected database type to @var conn
     */
    private $conn = null;



     /** @var db_name uses a database name specificed 
     *  if database is not found it creates new database
      */
    private $db_name = null;


    function __construct($db_type = 'MongoDB'){
        is_null($this->db_type) ? $this->db_type = $db_type : $this->db_type = null;
        
        try {
            $this->db_connect();
        } catch (ErrorHandler $e) {
            echo $e->E_getMessage($e);
        }
    }



    //connection to specified database type
    private function db_connect(){
        switch ($this->getDataBaseType()) {
            case doDatabase::MONGO :
                $this->conn =  new MongoDB\Client(DB_INSTANCE . DB_USERNAME .':'. DB_PASSWORD . DB_HOST );
                $this->database = DataFactory::get(C_MONGODB,array($this->conn));

                return true;
                break;            
            case doDatabase::MYSQLI :
                $this->conn =  mysqli_connect(DB_HOST   ,   DB_USERNAME   ,  DB_PASSWORD   ,   DB_DATABASE);
                $this->database = DataFactory::get(C_MYSQLI,array($this->conn));
                return true;
                break;
            default:
                throw new ErrorHandler("Error: Database Connector not found", 1);
                break;
        }
        return false;
    }



    /** @method  createDatabase(@param db_name) creates a new database
     * 
      */
      protected function createDatabase($db_name){
        switch ($this->getDataBaseType()) {
            case doDatabase::MONGO: 
                return $this->database->createDatabase($db_name);
                break;
            case doDatabase::MYSQLI :
                break;
            default:
                break;
        }
      }

    /** @method  selectDatabase(@param db_name) uses a database nam
     * 
      */
      protected function selectDatabase($db_name){
        switch ($this->getDataBaseType()) {
            case doDatabase::MONGO: 
                return $this->database->selectDatabase($db_name);
                break;
            case doDatabase::MYSQLI :
                break;
            
            default:
                break;
        }
      }

          /**
     * 
     * 
     *
     * @param [type] $tablename to be created
     * @param array $options contains extra conditions for the table
     * @return false if database hasnt not been selected
     * @return true creates table if database is selected
     *  
     */
      protected function createTable($table_name , array $option = null){
        switch ($this->getDataBaseType()) {
            case doDatabase::MONGO: 
                return $this->database->createCollection($db_name , $option);
                break;
            case doDatabase::MYSQLI :
                break;
            default:
                break;
        }
      }




          /**
     *
     *
     * @param array $object is the data to be inserted into database 
     * @param [type] $table to be inserted into
     */
    public function insert(array $object = null , $table , $options = null ){
        switch ($this->getDataBaseType()) {
            case doDatabase::MONGO: 
                return $this->database->insert($object , $table , $options);
                break;
            case doDatabase::MYSQLI :
                break;
            default:
                break;
        }
    }

    /**
     * @method  select()
     * @return found results from database
     */
    public function select(array $object = null , $table , array $options = [] ){
        switch ($this->getDataBaseType()) {
            case doDatabase::MONGO: 
                return $this->database->find($object , $table , $options);
                break;
            case doDatabase::MYSQLI :
                break;
            default:
                break;
        }
    }

    /**
     * Update data on table
     *
     * @param array $object
     * @param array $replacement
     * @param [type] $collection
     * @param mixed $option are extra details need for the specified database 
     * example for MongoDB $option = true = updateMany ; false = updateOne
     * @return void
     */
    public function update(array $object , array $replacement , $table , array $option){
        switch ($this->getDataBaseType()) {
            case doDatabase::MONGO: 
                return $this->database->update($object , $replacement , $table , $option);
                break;
            case doDatabase::MYSQLI :
                break;
            default:
                break;
        }
    }

    /**
     * Delete data on table
     *
     * @param array $object
     * @param [type] $collection
     * @param mixed $option are extra details need for the specified database 
     * example for MongoDB $option = true = updateMany ; false = updateOne
     * @return void
     */
    public function delete(array $object  , $table , $option = false){
        switch ($this->getDataBaseType()) {
            case doDatabase::MONGO: 
                return $this->database->delete($object , $table , $option);
                break;
            case doDatabase::MYSQLI :
                break;
            default:
                break;
        }
    }



      /** 
       *    @return dataBase connection
       * */
    public function getDatabaseConnection(){
        return $this->conn;
    }
    
    //return last insertedId after inserts
    public function getLastInsertId(){
          switch ($this->getDataBaseType()) {
            case doDatabase::MONGO: 
                return $this->database->getLastInsertedId();
                break;
            case doDatabase::MYSQLI :
                break;
            default:
                break;
        }
    }

    /**
     * 
     *
     * @return @this->database
     */
     public function getDataBase(){
        switch ($this->getDataBaseType()) {
            case doDatabase::MONGO: 
                return $this->database->getDatabase();
                break;
            case doDatabase::MYSQLI :
                break;
            default:
                break;
        }
     }
     /**
     * 
     * generate Id for use
     * @param [type] $id
     * @return void
     */
    public function generateId($id = null){
        switch ($this->getDataBaseType()) {
            case doDatabase::MONGO: 
                return $this->database->generateObjectId($id);
                break;
            case doDatabase::MYSQLI :
                break;
            default:
                break;
        }
    }
    //@method mixed getDataBaseType() returns selected databse name
    private function getDataBaseType(){
        return $this->db_type;
    }

    

    


}