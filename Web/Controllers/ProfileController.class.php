<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class ProfileController implements IController
{
    private $db;
    public function __construct()
    {
        require_once(DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * Vrati obsah stranky se profilem uzivatele.
     * @param string $pageTitle     Nazev stranky.
     * @return string               Vypis v sablone.
     */
    public function show(string $pageTitle):string
    {
        global $tplData;
        $tplData = [];
        $tplData['title'] = $pageTitle;

        //požadavek na smazání článku?
        if (isset($_POST['delete'])) {
            if ($_POST['delete'] == 'Smazat') {
                $this->db->deletePost($_POST['id_post']);
            }
        }

        //požadavek na vydání článku?
        if (isset($_POST['action']) && $_POST['action'] == "Vydat") {
            $res = $this->db->addPost($_POST['title'], $_POST['text']);

            if ($res) {
                $tplData['releaseStatus'] = "Článek v pořádku vyšel";
            } else {
                $tplData['releaseStatus'] = "Článek se nepodařilo vydat";
            }
        }
       
        //pokud je uživatel přihlášený načtou se jeho data
        if ($this->db->isUserLogged()) {
            $tplData['logged'] = $this->db->isUserLogged();
            $tplData['user'] = $this->db->getLoggedUserData();
            $tplData['role'] = $this->db->getUserRole(intval($tplData['user']['ROLE_id_role']));
            $tplData['posts'] = $this->db->getUserPosts($tplData['user']['id_uzivatel']);
        }

        ob_start();
        require(DIRECTORY_VIEWS ."/User-profileTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}
