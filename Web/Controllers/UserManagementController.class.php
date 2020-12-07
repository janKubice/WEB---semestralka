<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stranky se spravou uzivatelu
 */
class UserManagementController implements IController
{
    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct()
    {
        require_once(DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * Vrati obsah stranky se spravou uzivatelu.
     * @param string $pageTitle     Nazev stranky.
     * @return string               Vypis v sablone.
     */
    public function show(string $pageTitle):string
    {
        global $tplData;
        $tplData = [];

        $tplData['title'] = $pageTitle;

        //zjištění role uživatele
        if ($this->db->isUserLogged()) {
            $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
        }

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
            $ok = $this->db->promoteUser(intval($role), intval($_POST['id_uzivatel']));

            $role = $this->db->getUserRoleId(intval($_POST['id_uzivatel']));
            $role_name = $this->db->getRoleNameById($role);

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
            $ok = $this->db->demoteUser(intval($role), intval($_POST['id_uzivatel']));

            $role = $this->db->getUserRoleId(intval($_POST['id_uzivatel']));
            $role_name = $this->db->getRoleNameById($role);
            
            if ($ok) {
                $tplData['user_action'] = "Uživatel s ID:$_POST[id_uzivatel] byl ponížen na roli: $role_name.";
            } else {
                $tplData['user_action'] = "Uživatele s ID:$_POST[id_uzivatel] se nepodařilo ponížt.";
            }
        }

        //načtu všechny uživatele
        $tplData['users'] = $this->db->getAllUsers();

        ob_start();
        require(DIRECTORY_VIEWS ."/UserManagementTemplate.tpl.php");
        $obsah = ob_get_clean();

        return $obsah;
    }
}
