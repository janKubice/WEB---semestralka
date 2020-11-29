<?php
/**
 * Trida spravujici databazi.
 */
class DatabaseModel {
    private $pdo;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->pdo->exec("set names utf8");
    }
    
    public function addUser(){

    }

    public function addPost(){

    }

    public function deletePost(){

    }

    public function updateUser(){

    }

    public function updatePost(){

    }

    public function getFirstXPosts(){
        
    }
    
    /**
     *  Vrati seznam vsech uzivatelu pro spravu uzivatelu.
     *  @return array Obsah spravy uzivatelu.
     */
    public function getAllUsers():array {
        $q = "SELECT * FROM ".TABLE_USER;
        return $this->pdo->query($q)->fetchAll();
    }
    
    /**
     *  Smaze daneho uzivatele z DB.
     *  @param int $userId  ID uzivatele.
     */
    public function deleteUser(int $userId):bool {
        $q = "DELETE FROM ".TABLE_USER." WHERE id_user = $userId";
        $res = $this->pdo->query($q);
        if ($res) {
            return true;
        } else {

            return false;
        }
    }
    
}

?>