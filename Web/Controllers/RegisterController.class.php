<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class RegisterController implements IController {

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

        if (isset($_POST['action']) and $_POST['action'] == "register")
        {
            if (isset($_POST['login']) && isset($_POST['heslo']) && isset($_POST['heslo2']) 
            && isset($_POST['jmeno']) && isset($_POST['prijmeni'])
            && $_POST['heslo'] == $_POST['heslo2']
            && $_POST['login'] != "" && $_POST['heslo'] != "" && $_POST['jmeno'] != ""){
                $res = $this->db->addUser($_POST['jmeno'], $_POST['prijmeni'], $_POST['login'], $_POST['heslo']);
                if ($res){
                    unset($tplData['reg_err']);
                    $tplData['reg_suc'] = "Registrace proběhla v pořádku!";
                }
                else{
                    unset($tplData['reg_suc']);
                    $tplData['reg_err'] = "Registrace se nezdařila!";
                }
            }
        else
            unset($tplData['reg_suc']);
            $tplData['reg_err'] = "Špatné údaje!";
        }

       

        
        ob_start();
        require(DIRECTORY_VIEWS ."/RegisterTemplate.tpl.php");
        $obsah = ob_get_clean();
    
        return $obsah;
    }

}

?>