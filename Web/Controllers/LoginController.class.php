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

            // zpracovani odeslanych formularu
            if (isset($_POST['action'])){
                if ($_POST['action'] == 'login' && isset($_POST['login']) && isset($_POST['heslo'])){
                    $res = $this->db->userLogin($_POST['login'], $_POST['heslo']);
                    if ($res)
                        echo "OK: UZIVATEL LOGGGNUUtý";
                    else
                        echo "ERROR prihlaseni se nepovedlo";
                }
                else if ($_POST['action'] == 'logout'){
                    $db->userLogout();
                    echo "OK: uzivatel odhlásen";
                }
                else
                    echo "NEznámá akce";
                
                echo"<br>";
            }


            ///////////// PRO NEPRIHLASENE UZIVATELE ///////////////
            if (!$this->db->isUserLogged()){
                $tplData["logged"] = false;
            }

            ///////////// KONEC: PRO NEPRIHLASENE UZIVATELE ///////////////
        else {
                $tplData["logged"] = true;
        }
        
       
        ob_start();
        require(DIRECTORY_VIEWS ."/LoginTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;
    }

}

?>