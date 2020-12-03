<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class LoginController implements IController {

    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * Vrati obsah stranky se spravou uzivatelu.
     * @param string $pageTitle     Nazev stranky.
     * @return string               Vypis v sablone.
     */
    public function show(string $pageTitle):string {
        global $tplData;
        $tplData = [];
        $tplData['title'] = $pageTitle;

        if(isset($tplData['reg_suc'])){
            echo "<div class='info'>$tplData[loginStatus]</div>";
        }

            // zpracovani odeslanych formularu
            if (isset($_POST['action'])){
                if ($_POST['action'] == 'login' && isset($_POST['login']) && isset($_POST['heslo'])){
                    $res = $this->db->userLogin($_POST['login'], $_POST['heslo']);
                    if ($res)
                    {   
                        $tplData['userRole'] = $this->db->getLoggedUserData();
                        $tplData['loginStatus'] = "Přihlášení se zdařilo";
                    }         
                    else
                        $tplData['loginStatus'] = "Přihlášení se nezdařilo";
                }
                else if ($_POST['action'] == 'logout'){
                    $this->db->userLogout();
                    $tplData['userRole'] = -1;
                    $tplData['loginStatus'] = "Úspěšné odhlášení";
                }
                else
                    $tplData['loginStatus'] = "Něco se nezdařilo";
            }

            $tplData['logged'] = $this->db->isUserLogged();
        
       
        ob_start();
        require(DIRECTORY_VIEWS ."/LoginTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;
    }

}

?>