<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class PostManagementController implements IController {

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
        $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
       
        ob_start();
        require(DIRECTORY_VIEWS ."/PostManagementTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;
    }

}

?>