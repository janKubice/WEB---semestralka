<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 */
class IntroductionController implements IController {
    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * Vrati obsah uvodni stranky.
     * @param string $pageTitle     Nazev stranky.
     * @return string               Vypis v sablone.
     */
    public function show(string $pageTitle):string {
        global $tplData;
        $tplData = [];
        $tplData['title'] = $pageTitle;
        $tplData['logged'] = $this->db->isUserLogged();
        if ($tplData['logged']) {
            $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
        }else{
            $tplData['userRole'] = -1;
        }

        ob_start();
        require(DIRECTORY_VIEWS ."/IntroductionTemplate.tpl.php");
        $obsah = ob_get_clean();

        return $obsah;
    }
    
}

?>