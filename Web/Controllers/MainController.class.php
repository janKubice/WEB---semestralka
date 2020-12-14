<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class MainController implements IController
{
    private $db;

    public function __construct()
    {
        require_once(DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * vrátí obsah stranky s hlavní stránkou.
     * @param string $pageTitle     název stránky.
     * @return string               šablona stránky.
     */
    public function show(string $pageTitle):string
    {
        global $tplData;
        $tplData['title'] = $pageTitle;
        
        //požadavek na smazání článku
        if (isset($_POST['delete']) && $_POST['delete'] == 'Smazat') {
            $this->db->deletePost($_POST['id_post']);
        }

        //zjištění a uložení role uživatele
        $tplData['logged'] = $this->db->isUserLogged();
        if ($tplData['logged']) {
            $tplData['user'] = $this->db->getLoggedUserData();
            $tplData['userRole'] = $tplData['user']['ROLE_id_role'];
        } else {
            $tplData['userRole'] = -1;
        }


        $tplData['posts'] = $this->db->getAllReviewedPosts();
        
        ob_start();
        require(DIRECTORY_VIEWS ."/MainTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}
