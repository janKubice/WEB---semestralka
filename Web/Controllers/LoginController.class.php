<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class LoginController implements IController
{
    private $db;

    public function __construct()
    {
        require_once(DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * vrátí obsah s přihlašovací stránkou.
     * @param string $pageTitle     název stránky.
     * @return string               šablona stránky.
     */
    public function show(string $pageTitle):string
    {
        global $tplData;
        $tplData['title'] = $pageTitle;
        
        // zpracovani odeslanych formularu
        if (isset($_POST['action'])) {
            //přihlášení
            if ($_POST['action'] == 'login' && isset($_POST['login']) && isset($_POST['heslo'])) {
                $res = $this->db->userLogin($_POST['login'], $_POST['heslo']);
                if ($res) {
                    $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
                    $tplData['loginStatus'] = "Přihlášení se zdařilo";
                } else {
                    $tplData['loginStatus'] = "Přihlášení se nezdařilo";
                }
            }
            //odhlášení 
            else if ($_POST['action'] == 'logout') {
                $this->db->userLogout();
                $tplData['userRole'] = -1;
                $tplData['loginStatus'] = "Úspěšné odhlášení";
            } 
            else {
                $tplData['loginStatus'] = "Něco se nezdařilo";
            }
        }

        //zjištění a uložení role uživatele
        $tplData['logged'] = $this->db->isUserLogged();
        if ($tplData['logged']) {
            $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
        } else {
            $tplData['userRole'] = -1;
        }

        ob_start();
        require(DIRECTORY_VIEWS ."/LoginTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}
