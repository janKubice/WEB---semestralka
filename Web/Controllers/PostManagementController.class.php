<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class PostManagementController implements IController
{
    private $db;

    public function __construct()
    {
        require_once(DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * vrátí obsah se správou příspěvků.
     * @param string $pageTitle     název stránky.
     * @return string               šablona stránky.
     */
    public function show(string $pageTitle):string
    {
        global $tplData;
        $tplData['title'] = $pageTitle;

        
        //zjištění a uložení role uživatele
        $tplData['logged'] = $this->db->isUserLogged();
        if ($tplData['logged']) {
            $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
        } else {
            $tplData['userRole'] = -1;
        }
        
        //požadavek na přiřazení článku recenzentovi
        if (isset($_POST['potvrzeni'])) {
            if (isset($_POST['reviewer_id'])) {
                $res = $this->db->setReviewerToPost($_POST['post_id'], $_POST['reviewer_id']);
                if ($res) {
                    $tplData['status'] = "Článek byl v pořádku přiřazen";
                } else {
                    $tplData['status'] = "Článek se nepodařilo přiřadit";
                }
            } else {
                $tplData['status'] = "Něco se pokazilo při vybírání recenzenta";
            }
        }else{
            $tplData['status'] = "Požadavek nebyl rozpoznán";
        }

        $tplData['posts'] = $this->db->getNotReviewPosts();
        $tplData['reviewers'] = $this->db->getReviewers();

        ob_start();
        require(DIRECTORY_VIEWS ."/PostManagementTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}
