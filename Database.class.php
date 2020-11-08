<?php

class Database {
    private $pdo;
    private $mySession;
    
    public function __construct(){
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->pdo->exec("set names utf8");
        require_once("MySessions.class.php");
        $this->mySession = new Session();
    }

}
?>