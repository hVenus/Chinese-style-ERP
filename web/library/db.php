<?php

class db{
    private $connection;

    function __construct() {
        try {
            $dsn = "".DB_DRIVER.":host=".DB_HOST.";dbname=".DB_NAME.";port=".DB_PORT." ";
            //$this->connection = new PDO($dsn, DB_USER, DB_PASSWORD);
            $this->connection = new PDO("java:comp/env/jdbc/tdoa");
            $this->connection->exec("SET NAMES utf8;"); 
            $this->connection->exec("SET character_set_results = 'utf8'"); 
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    function __destruct() {
    }

    function query($sql){
        $return = false;
        try{
            $temp = $this->connection->query($sql);
            var_dump($temp);
            if($temp!==false){
                while ( $row = $temp->fetch()) {
                    $return[] =  $row;
                }
            }else{
                if ($this->connection->errorCode())
                {
                    echo "有錯誤！有錯誤！";
                    print_r($this->connection->errorInfo());
                }
            }
        }catch(PDOException $e){
            echo "Syntax Error: ".$e->getMessage();
        }
        return $return;
    }

}