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

    }




}