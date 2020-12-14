<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class ReviewsController implements IController {

    private $db;

    public function __construct() {
        require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * vrátí obsah s recenzemi
     * @param string $pageTitle     název stránky.
     * @return string               šablona stránky.
     */
    public function show(string $pageTitle):string {
        global $tplData;
        $tplData['title'] = $pageTitle;

        //požadavek na potvrzení/zamítnutí
        if (isset($_POST['potvrzeni'])){
            //článek byl schválení
            if ($_POST['potvrzeni'] == "Schválit"){
                $res = $this->db->updatePostStatus($_POST['id_post'], 1);
                if ($res){
                    $tplData['status'] = "Článek se podařilo v pořádku schválit";
                }
                else{
                    $tplData['status'] = "Článek se nepodařilo schválit";
                }
            }
            //požadavek na zamítnutí
            else if ($_POST['potvrzeni'] == 'Zamítnout'){
                $res = $this->db->deletePost($_POST['id_post']);
                if ($res){
                    $tplData['status'] = "Článek se podařilo zamítnout";
                }
                else{
                    $tplData['status'] = "Článek se nepodařilo zamítnout";
                }
            }
        }

        //zjištění zda je uživatel přihlášen a načtení článků k recenzi
        $tplData['logged'] = $this->db->isUserLogged();
        if ($tplData['logged']) {
            $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
            if ($tplData['userRole'] == 2 || $tplData['userRole'] == 3){
                $tplData['posts'] = $this->db->getPostToReviewToUser($this->db->getLoggedUserData()['id_uzivatel']);
            }
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