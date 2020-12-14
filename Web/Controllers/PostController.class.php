<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class PostController implements IController {

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

        if (isset($_POST['postID'])){
            $post = $this->db->getPostById(intval($_POST['postID']));
            $tplData['title'] = $post['nadpis'];
            $tplData['post'] = $post;
            
        }
        
        $user = $this->db->getLoggedUserData();
        $tplData['user'] = $user;

        $tplData['logged'] = $this->db->isUserLogged();
        if ($this->db->isUserLogged()){
            $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
        }else {
            $tplData['userRole'] = -1;
        }
        
        ob_start();
        require(DIRECTORY_VIEWS ."/PostTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;
    }

}

?>