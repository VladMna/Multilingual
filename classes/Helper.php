<?php

class Helper {



    public static function makeArray($array = null){
        return is_array($array)? $array : array($array);

    }


    public function formatException($exception = null){
        if(is_object($exception)){
            $out = array();
            $out[] = '<strong>Message: </strong>'.$exception->getMessage();
            $out[] = '<strong>Code:</strong>'.$exception->getCode();
            $out[] = '<strong>File:</strong>'.$exception->getFile();
            $out[] = '<strong>Line:</strong>'.$exception->getLine();
            $out[] = '<strong>Trace:</strong>'.$exception->getTraceAsString();
            $out[] = '<strong>Last statement:</strong>'.$this->_last_statement;
            return '<p>'.implode('<br.>', $out).'</p>';
        }
    }


    public function getLastInsertId($sequenceName = null){
        return $this->_db_object->lastInsertId($sequenceName);
    }

    public function  getAll($sql = null, $params = null){
        if(!empty($sql)){
            $statement = $this->query($sql, $params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getOne($sql = null, $param = null){
        if(!empty($sql)){
            $statement = $this->query($sql, $param);
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

    }

    public  function execute($sql = null, $params = null){
        if(!empty($sql)){
            $statement = $this->query($sql, $params);
            $this->_affected_rows = $statement->rowCount();
            return true;
        } else {
            return false;
        }
    }

    public function insert($sql = null, $param = null){
        if(!empty($sql)){
            if($this->execute($sql, $param)){
                $this->id = $this->getLastInsertId();
                return true;
            } else {
                return false;
            }
        }

    }


    public static function getPlug($file = null, $data = null){
        if(!empty($file)){
            $file = ROOT_PATH.DS.'plugs'.DS.$file.'.php';
            if(is_file($file)) {
                ob_start();
            require_once($file);
                return ob_get_clean();

            }
        }

    }
}