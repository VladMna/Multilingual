<?php

class Dbase {

    private $_db_host = 'localhost';
    private $_db_name = 'multilingual';
    private $_db_user = 'root';
    private $_db_password = 'password';

    private $_db_object = null;
    private $_db_driver_options = array();

    public $_last_statement;
    public $_affected_rows;

    public $_id;


    public function __construct($dbconn = null)
    {
        $this->setProperties($dbconn);
        $this->connect();
    }

        public function setProperties($array = null){
            if(!empty($array) || is_array($array) && count($array) == 4){
                foreach($array as $key => $value){
                    $this->$key = $value;

                }

        }

        }
        private function connect(){
            $this->setDrivenOptions(array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAME utf8"));
            try{
                $this->_db_object = new PDO("mysql:dbname={$this->_db_name}; host={$this->_db_host}",
                    $this->_db_user,
                    $this->_db_password,
                    $this->_db_driver_options
                );

            } catch(PDOException $e){
                echo $e->getMessage();
                exit();
            }

    }

    public function  setDrivenOptions($options = null){
        if(!empty($options)){
            $this->_db_driver_options = $options;
        }

    }


    /**
     * @param null $sql
     * @param null $params
     * @return mixed         $statement = $dbh->prepare($sql, $params_optional);
     */
    private function query($sql = null, $params = null){

        if(!empty($sql)){
            $this->_last_statement = $sql;

            if($this->_db_object == null){
                $this->connect();
            }

            try {
                $statement = $this->_db_object->prepare($sql, $this->_db_driver_options);
                $params = Helper::makeArray($params);

                if(!$statement->execute($params) || $statement->errorCode() != '0000'){
                    $error = $statement->errorInfo();
                    throw new PDOException("Database error {$error[0]} : {$error[2]}, driven error code is {$error[1]}");
                    exit;
                }
                return $statement;

            } catch(PDOException $e){
                echo $this->formatException($e);
                exit;
            }

        }

    }




}