<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class ProfileController implements IController {

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


        if (isset($_POST['delete'])){
            if ($_POST['delete'] == 'Smazat'){
                $this->db->deletePost($_POST['id_post']);
            }
        }
       

        if ($this->db->isUserLogged()){
            $tplData['logged'] = $this->db->isUserLogged();
            $tplData['user'] = $this->db->getLoggedUserData();
            $tplData['posts'] = $this->db->getUserPosts($tplData['user']['id_uzivatel']);
        }

        if (isset($_POST['action']) && $_POST['action'] == "Vydat"){
            $res = $this->db->addPost($_POST['title'], $_POST['text']);

            if ($res){
                $tplData['releaseStatus'] = "Článek v pořádku vyšel";
            }
            else{
                $tplData['releaseStatus'] = "Článek se nepodařilo vydat";
            }
        }

        ob_start();
        require(DIRECTORY_VIEWS ."/User-profileTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;
    }

}

?>