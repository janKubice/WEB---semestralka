<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class ReviewsController implements IController {

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

        if (isset($_POST['potvrzeni'])){
            if ($_POST['potvrzeni'] == "Schválit")
                $this->db->updatePostStatus($_POST['id_post'], 1);
            else if ($_POST['potvrzeni'] == 'Zamítnout')
                $this->db->deletePost($_POST['id_post']);
        }

        $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
        $tplData['posts'] = $this->db->getPostToReviewToUser($this->db->getLoggedUserData()['id_uzivatel']);
        $tplData['logged'] = $this->db->isUserLogged();
        
        if ($tplData['logged']) {
            $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
        }else{
            $tplData['userRole'] = -1;
        }

        ob_start();
        require(DIRECTORY_VIEWS ."/ReviewsTemplate.tpl.php");
        $obsah = ob_get_clean();
    
        return $obsah;
    }

}

?>