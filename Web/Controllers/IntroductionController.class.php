<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 */
class IntroductionController implements IController
{
    private $db;

    public function __construct()
    {
        require_once(DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * vrátí obsah úvodní stránky.
     * @param string $pageTitle     název stránky.
     * @return string               šablona stránky.
     */
    public function show(string $pageTitle):string
    {
        global $tplData;

        $tplData['title'] = $pageTitle;
        $tplData['logged'] = $this->db->isUserLogged();

        //zjištění a uložení role
        if ($tplData['logged']) {
            $tplData['userRole'] = $this->db->getLoggedUserData()['ROLE_id_role'];
        } else {
            $tplData['userRole'] = -1;
        }

        ob_start();
        require(DIRECTORY_VIEWS ."/IntroductionTemplate.tpl.php");
        $obsah = ob_get_clean();

        return $obsah;
    }
}
