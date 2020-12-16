<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stranky se spravou uzivatelu
 */
class UserManagementController implements IController
{
    private $db;

    public function __construct()
    {
        require_once(DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * vrátí obsah se správou členů
     * @param string $pageTitle     název stránky.
     * @return string               šablona stránky.
     */
    public function show(string $pageTitle):string
    {
        global $tplData;
        $tplData['title'] = $pageTitle;        

        //prisel pozadavek na smazani uzivatele?
        if (isset($_POST['action']) and $_POST['action'] == "delete" and isset($_POST['id_uzivatel'])) {
            // provedu smazani uzivatele
            $ok = $this->db->deleteUser(intval($_POST['id_uzivatel']));
            if ($ok) {
                $tplData['user_action'] = "Uživatel s ID:$_POST[id_uzivatel] byl smazán z databáze.";
            } else {
                $tplData['user_action'] = "Uživatele s ID:$_POST[id_uzivatel] se nepodařilo smazat z databáze.";
            }
        }
        //prisel pozadavek na promote uzivatele?
        elseif (isset($_POST['action']) and $_POST['action'] == "promote" and isset($_POST['id_uzivatel'])) {
            // provedu povyseni uzivatele
            $role = $this->db->getUserRoleId(intval($_POST['id_uzivatel']));
            $ok = $this->db->promoteUser($role[0]['ROLE_id_role'], intval($_POST['id_uzivatel']));

            //získání nových údajů
            $role = $this->db->getUserRoleId(intval($_POST['id_uzivatel']));
            $role_name = $this->db->getRoleNameById($role[0]['ROLE_id_role']);

            if ($ok) {
                $tplData['user_action'] = "Uživatel s ID:$_POST[id_uzivatel] byl povýšen na roli: $role_name.";
            } else {
                $tplData['user_action'] = "Uživatele s ID:$_POST[id_uzivatel] se nepovedlo povýšit.";
            }
        }
        //prisel pozadavek na demote uzivatele?
        elseif (isset($_POST['action']) and $_POST['action'] == "demote"and isset($_POST['id_uzivatel'])) {
            // provedu ponizeni uzivatele
            $role = $this->db->getUserRoleId(intval($_POST['id_uzivatel']));
            $ok = $this->db->demoteUser($role[0]['ROLE_id_role'], intval($_POST['id_uzivatel']));

            //získání nových údajů
            $role = $this->db->getUserRoleId(intval($_POST['id_uzivatel']));
            $role_name = $this->db->getRoleNameById($role[0]['ROLE_id_role']);
            
            if ($ok) {
                $tplData['user_action'] = "Uživatel s ID:$_POST[id_uzivatel] byl ponížen na roli: $role_name.";
            } else {
                $tplData['user_action'] = "Uživatele s ID:$_POST[id_uzivatel] se nepodařilo ponížt.";
            }
        }
        //---konec požadavků

        //zjištění role uživatele
        if ($this->db->isUserLogged()) {
            $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
        }

        //načtu všechny uživatele
        $tplData['users'] = $this->db->getAllUsers();
        //role
        $tplData['roles'] = $this->db->getAllRoles();
        
        $tplData['logged'] = $this->db->isUserLogged();
        
        ob_start();
        require(DIRECTORY_VIEWS ."/UserManagementTemplate.tpl.php");
        $obsah = ob_get_clean();

        return $obsah;
    }
}
