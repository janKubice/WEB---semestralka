<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class RegisterController implements IController
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
     * Vrati obsah stranky s registraci.
     * @param string $pageTitle     Nazev stranky.
     * @return string               Vypis v sablone.
     */
    public function show(string $pageTitle):string
    {
        global $tplData;
        $tplData = [];
        $tplData['title'] = $pageTitle;

        //ověření  zda se něco předává v _POST
        if (isset($_POST['action']) and $_POST['action'] == "register") {
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
     
        $tplData['logged'] = $this->db->isUserLogged();
        if ($tplData['logged']) {
            $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
        }else{
            $tplData['userRole'] = -1;
        }
        ob_start();
        require(DIRECTORY_VIEWS ."/RegisterTemplate.tpl.php");
        $obsah = ob_get_clean();
    
        return $obsah;
    }
}
