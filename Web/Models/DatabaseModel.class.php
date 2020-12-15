<?php
/**
 * Třída pracující s databází
 */
class DatabaseModel
{
    private $pdo;
    private $session;
    private $userSessionKey = "id_user";

    /**
     * Initializace připojení,
     * Initializace session.
     */
    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->pdo->exec("set names utf8");
        require_once("SessionModel.class.php");
        $this->session = new SessionModel();
    }
    
    //---------------------Práce s uživatelem-----------------------

    /**
     *  přidá uživatele do databáze.
     *  @param string $userName     jméno uživatele
     *  @param string $userSurname  příjmení
     *  @param string $userLogin    přihlašovací jméno
     *  @param string $userPass     heslo
     *  @return bool true - povedlo se jinak false
     */
    public function addUser(string $userName, string $userSurname, string $userLog, string $userPass)
    {
        $role = 1;
        $stmt = $this->pdo->prepare("INSERT INTO ".TABLE_USER." (jmeno, prijmeni, ROLE_id_role, heslo, login)
        VALUES (:jmeno, :prijmeni, :ROLE_id_role, :heslo, :login)");
        $stmt->bindValue(':jmeno', $userName); 
        $stmt->bindValue(':prijmeni', $userSurname);
        $stmt->bindValue(':ROLE_id_role', $role);
        $stmt->bindValue(':heslo', $userPass);
        $stmt->bindValue(':login', $userLog);

        try {
            $stmt->execute();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     *  smaže uživatele z databáze
     *  @param int $userId  ID uživatele.
     *  @return bool true - povedlo se jinak false
     */
    public function deleteUser(int $userId):bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM ".TABLE_USER." WHERE id_uzivatel = :id ");
        $stmt->bindValue(':id', $userId); 

        try {
            $stmt->execute();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
    *  Vrátí pole všech uživatelů.
    *  @return array pole všech uživatelů.
    */
    public function getAllUsers():array
    {
        $users = $this->selectFromTable(TABLE_USER);
        return $users;
    }

    /**
     *  promotne uživatele
     *  @param string $id_role  aktuální role uživatele
     *  @param string $id_user  id uživatele
     *  @return bool true - povedlo se jinak false
     */
    public function promoteUser(int $id_role, int $id_user)
    {
        if ($id_role < 3) {
            $id_role++;
        } else {
            return false;
        }

        $updateStatementWithValues = "ROLE_id_role='$id_role'";
        $whereStatement = "id_uzivatel=$id_user";
        return $this->updateInTable(TABLE_USER, $updateStatementWithValues, $whereStatement);
    }

    /**
     *  demotne uživatele
     *  @param string $id_role  aktuální role uživatele
     *  @param string $id_user  id uživatele
     *  @return bool true - povedlo se jinak false
     */
    public function demoteUser(int $id_role, int $id_user)
    {
        if ($id_role > 0) {
            $id_role--;
        } else {
            return false;
        }

        $updateStatementWithValues = "ROLE_id_role='$id_role'";
        $whereStatement = "id_uzivatel=$id_user";
        return $this->updateInTable(TABLE_USER, $updateStatementWithValues, $whereStatement);
    }

    /**
     *  zjistí a vrátí ID uživatelovo role
     *  @param int   $id_user  id uživatele
     *  @return int     id role uživatele
     */
    public function getUserRoleId(int $id_user):int
    {
        $users = $this->selectFromTable(TABLE_USER, "id_uzivatel=$id_user");
        if (empty($users)) {
            return null;
        }
        return $users[0]['ROLE_id_role'];
    }

    /**
     *  zjistí a vrátí ID uživatelovo role
     *  @param int   $id_user  id uživatele
     *  @return array  role uživatele
     */
    public function getUserRole(int $id_role):array
    {
        $role = $this->selectFromTable(TABLE_ROLE, "id_role=$id_role");
        if (empty($role)) {
            return null;
        }
        return $role[0];
    }

    /**
     *  přihlásí uživatele, uloží do session
     *  @param string   $login  přihlašovací jméno uživatele
     *  @param string   $heslo  heslo uživatele
     *  @return bool  true pokud se povedlo přihlásit, jinak false
     */
    public function userLogin(string $login, string $heslo):bool
    {
        $where = "login='$login' AND heslo='$heslo'";
        $user = $this->selectFromTable(TABLE_USER, $where);

        if (count($user)) {
            $_SESSION[$this->userSessionKey] = $user[0]['id_uzivatel'];
            return true;
        } else {
            return false;
        }
    }

    /**
     *  odhlásí uživatele, smaže session
     */
    public function userLogout()
    {
        unset($_SESSION[$this->userSessionKey]);
    }

    /**
     *  zjístí zda je uživatel přihlášen
     *  @return bool  true pokud ano, jinak false
     */
    public function isUserLogged():bool
    {
        return isset($_SESSION[$this->userSessionKey]);
    }

    /**
     *  zjístí id přihlášeného uživatele
     *  @return int  id uživatele, pokud není přihlášen vrací NULL
     */
    public function getLoggedUserId():int
    {
        if ($this->isUserLogged()) {
            $id_user = $_SESSION[$this->userSessionKey];
            return $id_user;
        } else {
            return null;
        }
    }

    /**
     *  pokud je uživatel přihlášen vrací jeho data
     *  @return array  data uživatele pokud je přihlášen, pokud není vrací null
     */
    public function getLoggedUserData():array
    {
        if ($this->isUserLogged()) {
            $id_user = $_SESSION[$this->userSessionKey];
            if ($id_user == null) {
                $this->userLogout();
            } else {
                $userData = $this->selectFromTable(TABLE_USER, "id_uzivatel=$id_user");
                if (empty($userData)) {
                    $this->userLogout();
                    return null;
                } else {
                    return $userData[0];
                }
            }
        } else {
            return null;
        }
    }

    /**
     *  Vrátí pole všech uživatelů kteří mají roli admin a nebo recezent
     *  @return array  pole uživatelů kteří mohou recenzovat
     */
    public function getReviewers():array
    {
        $users = $this->selectFromTable(TABLE_USER, "ROLE_id_role>=2");
        return $users;
    }

    //------------------------Konec práce s uživatelem------------------------


    //-------------------------Práce s příspěvky------------------------------


    /**
     *  přihlásí uživatele, uloží do session
     *  @param string   $title  nadpisek článku
     *  @param string   $text  text článku
     *  @param string   $path  cesta k případně přiloženému souboru
     *  @return bool  true pokud se povedlo přidat článek, jinak false
     */
    public function addPost(string $title, string $text, string $path = ""):bool
    {
        $userId = $this->getLoggedUserId();
        echo $cesta;
        $time = date("Y/m/d");
        $insertStatement = "id_prispevek, datum, nadpis, text, id_recenzent, recenzovano, hodnoceni, UZIVATEL_id_uzivatel, cesta";
        $insertValues = "'NULL', '$time', '$title', '$text', '-1', '0', '0', '$userId', '$path'";
        return $this->insertIntoTable(TABLE_POST, $insertStatement, $insertValues);
    }

    /**
     *  vrátí článek podle id
     *  @param int   $id_post  id článku
     *  @return array   článek reprezentovaný polem
     */
    public function getPostById(int $id_post):array
    {
        $post = $this->selectFromTable(TABLE_POST, "id_prispevek=$id_post");
        if (empty($post)) {
            return null;
        }
        return $post[0];
    }

    /**
     *  změní status článku
     *  @param int   $idPost  id článku
     *  @param int   $status  požadovaný status článku /  0 nevydán, 1 vydán 
     *  @return bool   true pokud se povedlo článek upravit, jinak false
     */
    public function updatePostStatus(int $idPost, int $status):bool
    {
        $updateStatementWithValues = "recenzovano='$status'";
        $whereStatement = "id_prispevek=$idPost";
        return $this->updateInTable(TABLE_POST, $updateStatementWithValues, $whereStatement);
    }

    /**
     *  přiřadí článku recenzenta
     *  @param int   $post  id článku
     *  @param int   $rev   id uživatele kterému se článek přiřadí
     *  @return bool   true pokud se povedlo přiřadit, jinak false
     */
    public function setReviewerToPost(int $post, int $rev):bool
    {
        $updateStatementWithValues = "id_recenzent='$rev'";
        $whereStatement = "id_prispevek=$post";
        return $this->updateInTable(TABLE_POST, $updateStatementWithValues, $whereStatement);
    }
    
    /**
     *  smaže článek
     *  @param int   $postId  id článku
     *  @return bool   true pokud se povedlo článek smazat, jinak false
     */
    public function deletePost(int $postId):bool
    {
        $q = "DELETE FROM ".TABLE_POST." WHERE id_prispevek = $postId";
        $res = $this->pdo->query($q);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  vrátí všechny články uživatele 
     *  @param int   $idUser  id uživatele
     *  @return array   pole všech článu uživatele
     */
    public function getUserPosts(int $idUser):array
    {
        $posts = $this->selectFromTable(TABLE_POST, "UZIVATEL_id_uzivatel=$idUser", "id_prispevek DESC");
        return $posts;
    }

    /**
     *  vrátí všechny vydané články 
     *  @return array   pole všech vydaných článků
     */
    public function getAllReviewedPosts():array
    {
        $posts = $this->selectFromTable(TABLE_POST, "recenzovano=1", "id_prispevek DESC");
        return $posts;
    }

    /**
     *  vrátí všechny nezrecenzovaných článků 
     *  @return array   pole nezrecenzovaných článků
     */
    public function getNotReviewPosts():array
    {
        $posts = $this->selectFromTable(TABLE_POST, "id_recenzent=-1");
        return $posts;
    }

    /**
     *  vrátí všechny články k recenzování daným uživatelem
     *  @param int   $id_user  id uživatele
     *  @return array   pole všech článu k recenzování daným uživatelem
     */
    public function getPostToReviewToUser(int $id_user):array
    {
        $posts = $this->selectFromTable(TABLE_POST, "id_recenzent=$id_user AND recenzovano=0");
        return $posts;
    }

     //-------------------------Konec práce s příspěvky------------------------------

    //-----------Práce s rolemi--------------------------------------------------


    /**
     *  vrátí všechny role 
     *  @return array   pole rolí
     */
    public function getAllRoles():array
    {
        $q = "SELECT * FROM ".TABLE_ROLE;
        return $this->pdo->query($q)->fetchAll();
    }

    /**
     *  získá jméno role podle id
     *  @param int $id_role id role
     *  @return string   název role
     */
    public function getRoleNameById(int $id_role):string
    {
        $role = $this->selectFromTable(TABLE_ROLE, "id_role=$id_role");
        if (empty($role)) {
            return null;
        }
        return $role[0]['nazev'];
    }

    //-----------Konecp práce s rolemi-------------------------

    //-----------obecné metody-------------------------

    /**
     *  vybere z tabulky
     *  @param string $tableName jméno tabulky
     *  @param string $whereStatement podmínka výběru
     *  @param string $orderByStatement řazení
     *  @return array   pole výsleků
     */
    public function selectFromTable(string $tableName, string $whereStatement = "", string $orderByStatement = ""):array
    {   
        $q = "SELECT * FROM ".$tableName
            .(($whereStatement == "") ? "" : " WHERE $whereStatement")
            .(($orderByStatement == "") ? "" : " ORDER BY $orderByStatement");
        $obj = $this->executeQuery($q);

        if ($obj == null) {
            return [];
        }

        return $obj->fetchAll();
    }

    /**
     *  vybere z tabulky
     *  @param string $tableName jméno tabulky
     *  @param string $whereStatement podmínka výběru
     *  @return bool   true zda se povedla operace, jinak false
     */
    public function deleteFromTable(string $tableName, string $whereStatement):bool
    {
        $q = "DELETE FROM $tableName WHERE $whereStatement";
        $obj = $this->executeQuery($q);
        if ($obj == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     *  vybere z tabulky
     *  @param string $tableName jméno tabulky
     *  @param string $whereStatement podmínka výběru
     *  @param string $orderByStatement řazení
     *  @return bool   true zda se povedla operace, jinak false
     */
    public function insertIntoTable(string $tableName, string $insertStatement, string $insertValue):bool
    {
        $q = "INSERT INTO $tableName($insertStatement) VALUES ($insertValue)";
        $obj = $this->executeQuery($q);

        if ($obj == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     *  vybere z tabulky
     *  @param string $tableName jméno tabulky
     *  @param string $whereStatement podmínka výběru
     *  @param string $orderByStatement řazení
     *  @return array   true zda se povedla operace, jinak false
     */
    public function updateInTable(string $tableName, string $updateStatementWithValues, string $whereValue):bool
    {
        $q = "UPDATE $tableName SET $updateStatementWithValues WHERE $whereValue";
        $obj = $this->executeQuery($q);
        if ($obj == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     *  vybere z tabulky
     *  @param string $tableName jméno tabulky
     *  @param string $whereStatement podmínka výběru
     *  @param string $orderByStatement řazení
     */
    private function executeQuery(string $dotaz)
    {
        $res = $this->pdo->query($dotaz);
        if ($res) {
            return $res;
        } else {
            $error = $this->pdo->erroInfo();
            echo $error[2];
            return null;
        }
    }
}
