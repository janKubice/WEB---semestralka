<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class RegisterController implements IController
{
    private $db;

    public function __construct()
    {
        require_once(DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * vrátí obsah s registrací.
     * @param string $pageTitle     název stránky.
     * @return string               šablona stránky.
     */
    public function show(string $pageTitle):string
    {
        global $tplData;
        $tplData['title'] = $pageTitle;

        //požadavek na registraci
        if (isset($_POST['action']) and $_POST['action'] == "register") {
            //ověření údajů k registraci
            if (isset($_POST['login']) && isset($_POST['heslo']) && isset($_POST['heslo2'])
            && isset($_POST['jmeno']) && isset($_POST['prijmeni'])
            && $_POST['heslo'] == $_POST['heslo2']
            && $_POST['login'] != "" && $_POST['heslo'] != "" && $_POST['jmeno'] != "") {
                //Přidání uživatele do databáze
                $res = $this->db->addUser($_POST['jmeno'], $_POST['prijmeni'], $_POST['login'], $_POST['heslo']);
                if ($res) {
                    $tplData['registrationStatus'] = "Registrace proběhla v pořádku!";
                } else {
                    $tplData['registrationStatus'] = "Registrace se nezdařila!";
                }
            } else {
                $tplData['registrationStatus'] = "Špatné údaje!";
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
        require(DIRECTORY_VIEWS ."/RegisterTemplate.tpl.php");
        $obsah = ob_get_clean();
    
        return $obsah;
    }
}
