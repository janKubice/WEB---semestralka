<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class PostController implements IController
{
    private $db;

    public function __construct()
    {
        require_once(DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * vrátí obsah s jedním příspěvkem.
     * @param string $pageTitle     název stránky.
     * @return string               šablona stránky.
     */
    public function show(string $pageTitle):string
    {
        global $tplData;

        //požadavek na článek
        if (isset($_POST['postID'])) {
            $post = $this->db->getPostById(intval($_POST['postID']));
            $tplData['title'] = $post['nadpis'];
            $tplData['post'] = $post;
        }

        //zjištění a uložení role uživatele
        $tplData['logged'] = $this->db->isUserLogged();
        if ($this->db->isUserLogged()) {
            $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
            $tplData['user'] = $this->db->getLoggedUserData();
        } else {
            $tplData['userRole'] = -1;
        }
        
        ob_start();
        require(DIRECTORY_VIEWS ."/PostTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}
