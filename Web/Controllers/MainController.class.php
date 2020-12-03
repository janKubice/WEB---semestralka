<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class MainController implements IController {

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

        $tplData['posts'] = $this->db->getAllPosts();
        
        ob_start();
        require(DIRECTORY_VIEWS ."/MainTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;  
    }

}

?>