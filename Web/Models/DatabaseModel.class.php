<?php
/**
 * Trida spravujici databazi.
 */
class DatabaseModel {
    private $pdo;
    private $session;
    private $userSessionKey = "id_user";

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->pdo->exec("set names utf8");
        require_once("SessionModel.class.php");
        $this->session = new SessionModel();
    }
    
    public function addUser(string $userName, string $userSurname, string $userLogin, string $userPass){
        $defRole = 0;
        $insertStatement = "id_uzivatel, jmeno, prijmeni, ROLE_id_role, heslo, login";
        $insertValues = "'NULL', '$userName', '$userSurname', '$defRole', '$userPass', '$userLogin'";
        return $this->insertIntoTable(TABLE_USER, $insertStatement, $insertValues);
    }

    public function addPost(string $title, string $text){
        $userId = $this->getLoggedUserId();
        $time = date("Y/m/d");
        $insertStatement = "id_prispevek, datum, nadpis, text, id_recenzent, recenzovano, hodnoceni, UZIVATEL_id_uzivatel";
        $insertValues = "'NULL', '$time', '$title', '$text', '-1', '0', '0', '$userId'";
        return $this->insertIntoTable(TABLE_POST, $insertStatement, $insertValues);
    }

    public function promoteUser(int $id_role, int $id_user){
        if ($id_role < 3)
            $id_role++;
        else
            return false;

        $updateStatementWithValues = "ROLE_id_role='$id_role'";
        $whereStatement = "id_uzivatel=$id_user";
        return $this->updateInTable(TABLE_USER, $updateStatementWithValues, $whereStatement);
    }

    public function demoteUser(int $id_role, int $id_user){
        if($id_role > 0)
            $id_role--;
        else
            return false;

        $updateStatementWithValues = "ROLE_id_role='$id_role'";
        $whereStatement = "id_uzivatel=$id_user";
        return $this->updateInTable(TABLE_USER, $updateStatementWithValues, $whereStatement);
    }

    public function selectFromTable(string $tableName, string $whereStatement = "", string $orderByStatement = ""):array{
        $q = "SELECT * FROM ".$tableName
            .(($whereStatement == "") ? "" : " WHERE $whereStatement")
            .(($orderByStatement == "") ? "" : " ORDER BY $orderByStatement");
        $obj = $this->executeQuery($q);

        if ($obj == NULL)
            return [];

        return $obj->fetchAll();
    }

    public function deleteFromTable(string $tableName,string $whereStatement):bool{
        $q = "DELETE FROM $tableName WHERE $whereStatement";
        $obj = $this->executeQuery($q);
        if ($obj == NULL)
            return false;
        else
            return true;
    }

    public function insertIntoTable(string $tableName, string $insertStatement, string $insertValue):bool{
        $q = "INSERT INTO $tableName($insertStatement) VALUES ($insertValue)";
        $obj = $this->executeQuery($q);

        if ($obj == NULL)
            return false;  
        else 
            return true;
    }

    public function getUserRoleId(int $id_user){
        $users = $this->selectFromTable(TABLE_USER, "id_uzivatel=$id_user");
        if (empty($users))
            return NULL;
        return $users[0]['ROLE_id_role'];
    }

    public function getRoleNameById(int $id_role){
        $users = $this->selectFromTable(TABLE_ROLE, "id_role=$id_role");
        if (empty($users))
            return NULL;
        return $users[0]['nazev'];
    }

    public function updateInTable(string $tableName, string $updateStatementWithValues, string $whereValue):bool{
        $q = "UPDATE $tableName SET $updateStatementWithValues WHERE $whereValue";
        $obj = $this->executeQuery($q);
        if ($obj == NULL) return false;
        else return true; 
    }

    private function executeQuery(string $dotaz){
        $res = $this->pdo->query($dotaz);
        if ($res)
            return $res;
        else{
            $error = $this->pdo->erroInfo();
            echo $error[2];
            return NULL;
        }
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
        $q = "DELETE FROM ".TABLE_USER." WHERE id_uzivatel = $userId";
        $res = $this->pdo->query($q);
        if ($res) {
            return true;
        } else {

            return false;
        }
    }

    public function getAllReviewedPosts(){
        $posts = $this->selectFromTable(TABLE_POST, "recenzovano=1");
        return $posts;
    }

    public function getNotReviewPosts(){
        $posts = $this->selectFromTable(TABLE_POST, "id_recenzent=-1");
        return $posts;
    }

    public function getUserPosts(int $idUser){
        $posts = $this->selectFromTable(TABLE_POST, "UZIVATEL_id_uzivatel=$idUser");
        return $posts;
    }

    public function getPostToReviewToUser(int $id_user){
        $posts = $this->selectFromTable(TABLE_POST, "id_recenzent=$id_user AND recenzovano=0");
        return $posts;
    }

    public function getReviewers(){
        $users = $this->selectFromTable(TABLE_USER, "ROLE_id_role>=2");
        return $users;
    }

    public function updatePostStatus(int $idPost, int $status){
        $updateStatementWithValues = "recenzovano='$status'";
        $whereStatement = "id_prispevek=$idPost";
        return $this->updateInTable(TABLE_POST, $updateStatementWithValues, $whereStatement);
    }

    public function setReviewerToPost(int $post, int $rev){
        $updateStatementWithValues = "id_recenzent='$rev'";
        $whereStatement = "id_prispevek=$post";
        return $this->updateInTable(TABLE_POST, $updateStatementWithValues, $whereStatement);
    }
    
    public function deletePost(int $postId){
        $q = "DELETE FROM ".TABLE_POST." WHERE id_prispevek = $postId";
        $res = $this->pdo->query($q);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function userLogin(string $login, string $heslo){
        $where = "login='$login' AND heslo='$heslo'";
        $user = $this->selectFromTable(TABLE_USER, $where);

        if (count($user)){
            $_SESSION[$this->userSessionKey] = $user[0]['id_uzivatel'];
            return true;
        }
        else
            return false;
    }

    public function userLogout(){
        unset($_SESSION[$this->userSessionKey]);
    }

    public function isUserLogged(){
        return isset($_SESSION[$this->userSessionKey]);
    }

    public function getLoggedUserId(){
        if ($this->isUserLogged()){
            $id_user = $_SESSION[$this->userSessionKey];
            return $id_user;
        }
        else
            return null;
    }

    public function getLoggedUserData(){
        if ($this->isUserLogged()){
            $id_user = $_SESSION[$this->userSessionKey];
            if ($id_user == null){
                echo "Chyba serveru";
                $this->userLogout();
            }
            else{
                $userData = $this->selectFromTable(TABLE_USER, "id_uzivatel=$id_user");
                if (empty($userData)){
                    echo "Chyba serveru";
                    $this->userLogout();
                    return null;
                }else {
                    return $userData[0];
                }
            }
        }else{
            return null;
        }   
    }
    
}

?>