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
        $user = $this->db->getLoggedUserData();
        $tplData['user'] = $user;

        if (isset($_POST['delete']) && $_POST['delete'] == 'Smazat'){
            $this->db->deletePost($_POST['id_post']);
        }

        $tplData['logged'] = $this->db->isUserLogged();
        if ($tplData['logged']) {
            $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
        }else{
            $tplData['userRole'] = -1;
        }
        $tplData['posts'] = $this->db->getAllReviewedPosts();
        
        ob_start();
        require(DIRECTORY_VIEWS ."/MainTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;  
    }

}

?>