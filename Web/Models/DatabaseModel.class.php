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
        $stmt = $this->pdo->prepare("DELETE FROM ".TABLE_USER." WHERE id_uzivatel=?");
    
        try {
            $stmt->execute(array($userId));
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
        if($stmt = $this->pdo->prepare("SELECT * FROM uzivatel")) {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_NAMED);
            return $result;
        }
        else{
            return null;
        }
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

        try {
            $stmt = $this->pdo->prepare("UPDATE uzivatel SET ROLE_id_role = ? WHERE id_uzivatel = ?");
            $res = $stmt->execute(array($id_role, $id_user));
            return $res;
        } catch (\Throwable $th) {
            return null;
        }
        
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

        try {
            $stmt = $this->pdo->prepare("UPDATE uzivatel SET ROLE_id_role = ? WHERE id_uzivatel = ?");
            $res = $stmt->execute(array($id_role, $id_user));
            return $res;
        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     *  zjistí a vrátí ID uživatelovo role
     *  @param int   $id_user  id uživatele
     *  @return int     id role uživatele
     */
    public function getUserRoleId(int $id_user)
    {
        if($stmt = $this->pdo->prepare("SELECT ROLE_id_role FROM ".TABLE_USER." WHERE id_uzivatel=?")) {
            $stmt->execute(array($id_user));
            $result = $stmt->fetchAll(PDO::FETCH_NAMED);
            return $result;
        }
        else{
            return null;
        }
    }

    /**
     *  zjistí a vrátí ID uživatelovo role
     *  @param int   $id_user  id uživatele
     *  @return array  role uživatele
     */
    public function getUserRole(int $id_role):array
    {
        if($stmt = $this->pdo->prepare("SELECT * FROM ".TABLE_ROLE." WHERE id_role=?")) {
            $stmt->execute(array($id_role));
            $result = $stmt->fetchAll(PDO::FETCH_NAMED);
            return $result[0];
        }
        else{
            return null;
        }
    }

    /**
     *  přihlásí uživatele, uloží do session
     *  @param string   $login  přihlašovací jméno uživatele
     *  @param string   $heslo  heslo uživatele
     *  @return bool  true pokud se povedlo přihlásit, jinak false
     */
    public function userLogin(string $login, string $heslo):bool
    {
        if($stmt = $this->pdo->prepare("SELECT * FROM uzivatel WHERE login=? AND heslo=?")) {
            $stmt->execute(array($login, $heslo));
            $result = $stmt->fetchAll(PDO::FETCH_NAMED);
            $_SESSION[$this->userSessionKey] = $result[0]['id_uzivatel'];
            return true;
        }
        else{
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
    public function getLoggedUserData()
    {
        if ($this->isUserLogged()) {
            $id_user = $_SESSION[$this->userSessionKey];
            if ($id_user == null) {
                $this->userLogout();
            } else {
                $stmt = $this->pdo->prepare("SELECT * FROM uzivatel WHERE id_uzivatel=?");
                $stmt->execute(array($id_user));
                $result = $stmt->fetchAll(PDO::FETCH_NAMED);
                if (empty($result)) {
                    $this->userLogout();
                    return null;
                } else {
                    return $result[0];
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
        if($stmt = $this->pdo->prepare("SELECT * FROM uzivatel WHERE ROLE_id_role>=2")) {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_NAMED);
            return $result;
        }
        else{
            return null;
        }
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
        $time = date("Y/m/d");
        $stmt = $this->pdo->prepare("INSERT INTO ".TABLE_POST." (id_prispevek, datum, nadpis, text, id_recenzent, recenzovano, UZIVATEL_id_uzivatel, cesta)
        VALUES (:id_prispevek, :datum, :nadpis, :text, :id_recenzent, :recenzovano, :UZIVATEL_id_uzivatel, :cesta)");
        $stmt->bindValue(':id_prispevek', NULL); 
        $stmt->bindValue(':datum', $time);
        $stmt->bindValue(':nadpis', $title);
        $stmt->bindValue(':text', $text);
        $stmt->bindValue(':id_recenzent', -1);
        $stmt->bindValue(':recenzovano', 0);
        $stmt->bindValue(':UZIVATEL_id_uzivatel', $userId);
        $stmt->bindValue(':cesta', $path);

        try {
            $stmt->execute();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     *  vrátí článek podle id
     *  @param int   $id_post  id článku
     *  @return array   článek reprezentovaný polem
     */
    public function getPostById(int $id_post):array
    {
        if($stmt = $this->pdo->prepare("SELECT * FROM ".TABLE_POST." WHERE id_prispevek=?")) {
            $stmt->execute(array($id_post));
            $result = $stmt->fetchAll(PDO::FETCH_NAMED);
            return $result[0];
        }
        else{
            return null;
        }
    }

    /**
     *  změní status článku
     *  @param int   $idPost  id článku
     *  @param int   $status  požadovaný status článku /  0 nevydán, 1 vydán 
     *  @return bool   true pokud se povedlo článek upravit, jinak false
     */
    public function updatePostStatus(int $idPost, int $status):bool
    {
        $stmt = $this->pdo->prepare("UPDATE ".TABLE_POST." SET recenzovano = ? WHERE id_prispevek = ?");
        try {
            $result = $stmt->execute(array($status, $idPost,));
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     *  přiřadí článku recenzenta
     *  @param int   $post  id článku
     *  @param int   $rev   id uživatele kterému se článek přiřadí
     *  @return bool   true pokud se povedlo přiřadit, jinak false
     */
    public function setReviewerToPost(int $post, int $rev):bool
    {
        $stmt = $this->pdo->prepare("UPDATE ".TABLE_POST." SET id_recenzent = ? WHERE id_prispevek = ?");
        try {
            $result = $stmt->execute(array($rev, $post,));
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    
    /**
     *  smaže článek
     *  @param int   $postId  id článku
     *  @return bool   true pokud se povedlo článek smazat, jinak false
     */
    public function deletePost(int $postId):bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM ".TABLE_POST." WHERE id_prispevek=?");
    
        try {
            $stmt->execute(array($postId));
            return true;
        } catch (\Throwable $th) {
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
        if($stmt = $this->pdo->prepare("SELECT * FROM ".TABLE_POST." WHERE UZIVATEL_id_uzivatel=? ORDER BY id_prispevek DESC")) {
            $stmt->execute(array($idUser));
            $result = $stmt->fetchAll(PDO::FETCH_NAMED);
            return $result;
        }
        else{
            return null;
        }
    }

    /**
     *  vrátí všechny vydané články 
     *  @return array   pole všech vydaných článků
     */
    public function getAllReviewedPosts():array
    {
        if($stmt = $this->pdo->prepare("SELECT * FROM ".TABLE_POST." WHERE recenzovano=1 ORDER BY id_prispevek DESC")) {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_NAMED);
            return $result;
        }
        else{
            return null;
        }
    }

    /**
     *  vrátí všechny nezrecenzovaných článků 
     *  @return array   pole nezrecenzovaných článků
     */
    public function getNotReviewPosts():array
    {
       if($stmt = $this->pdo->prepare("SELECT * FROM ".TABLE_POST." WHERE id_recenzent=-1")) {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_NAMED);
            return $result;
        }
        else{
            return null;
        }
    }

    /**
     *  vrátí všechny články k recenzování daným uživatelem
     *  @param int   $id_user  id uživatele
     *  @return array   pole všech článu k recenzování daným uživatelem
     */
    public function getPostToReviewToUser(int $id_user):array
    {
        if($stmt = $this->pdo->prepare("SELECT * FROM ".TABLE_POST." WHERE id_recenzent=? AND recenzovano=0")) {
            $stmt->execute(array($id_user));
            $result = $stmt->fetchAll(PDO::FETCH_NAMED);
            return $result;
        }
        else{
            return null;
        }
    }

     //-------------------------Konec práce s příspěvky------------------------------

    //-----------Práce s rolemi--------------------------------------------------


    /**
     *  vrátí všechny role 
     *  @return array   pole rolí
     */
    public function getAllRoles():array
    {
        if($stmt = $this->pdo->prepare("SELECT * FROM ".TABLE_ROLE)) {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_NAMED);
            return $result;
        }
        else{
            return null;
        };
    }

    /**
     *  získá jméno role podle id
     *  @param int $id_role id role
     *  @return string   název role
     */
    public function getRoleNameById(int $id_role)
    {
        if($stmt = $this->pdo->prepare("SELECT * FROM ".TABLE_ROLE." WHERE id_role=?")) {
            $stmt->execute(array($id_role));
            $result = $stmt->fetchAll(PDO::FETCH_NAMED);
            return $result[0]['nazev'];
        }
        else{
            return null;
        }
    }

    //-----------Konec práce s rolemi-------------------------
}
