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
     * vrátí obsah s profilem uživatele.
     * @param string $pageTitle     název stránky.
     * @return string               šablona stránky.
     */
    public function show(string $pageTitle):string
    {
        global $tplData;
        $tplData['title'] = $pageTitle;
        //požadavek na smazání článku
        if (isset($_POST['delete'])) {
            if ($_POST['delete'] == 'Smazat') {
                $res = $this->db->deletePost($_POST['id_post']);
                if ($res) {
                    $tplData['deleteStatus'] = "Článek se podařilo úspěšně smazat";
                } else {
                    $tplData['deleteStatus'] = "Článek se nepodařilo smazat";
                }
            }
            else {
                $tplData['deleteStatus'] = "Požadavek nebyl rozpoznán";
            }
        }

        //požadavek na vydání článku
        if (isset($_POST['action']) && $_POST['action'] == "Vydat") {
            $target_dir = "Uploads/"; //cesta kam se ukládají soubory
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;

            //je přítomný soubor?
            if (isset($_FILES["fileToUpload"])) {
                if ($_FILES["fileToUpload"]["size"] > 5000000) {
                    $tplData['releaseStatus'] = "Soubor je příliš veliký";
                    $uploadOk = 0;
                }
            }

            //soubor je veliký
            if ($uploadOk == 0) {
                $tplData['releaseStatus'] .= ", tvůj článek se nepodařilo zpracovat";
            }
            //soubor je v pořádku 
            else {         
                if ($_FILES["fileToUpload"]["size"] == 0){
                    $res = $this->db->addPost($_POST['title'], $_POST['text'], "");
                        if ($res) {
                            $tplData['releaseStatus'] = "Článek v pořádku vyšel";
                        } else {
                            $tplData['releaseStatus'] = "Článek se nepodařilo vydat";
                        }
                }
                else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        $res = $this->db->addPost($_POST['title'], $_POST['text'], $target_file);
                        if ($res) {
                            $tplData['releaseStatus'] = "Článek v pořádku vyšel";
                        } else {
                            $tplData['releaseStatus'] = "Článek se nepodařilo vydat";
                        }
                    } else {
                        $tplData['releaseStatus'] = "Nepodařilo se nehrát soubor, článek se nepodařilo vydat";
                    }
                }
            }
        }
       
        //pokud je uživatel přihlášený načtou se jeho data
        $tplData['logged'] = $this->db->isUserLogged();
        if ( $tplData['logged']) {
            $tplData['user'] = $this->db->getLoggedUserData();
            $tplData['role'] = $this->db->getUserRole(intval($tplData['user']['ROLE_id_role']));
            $tplData['userRole'] = $tplData['user']['ROLE_id_role'];
            $tplData['posts'] = $this->db->getUserPosts($tplData['user']['id_uzivatel']);
        } else {
            $tplData['userRole'] = -1;
        }
        
        ob_start();
        require(DIRECTORY_VIEWS ."/User-profileTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}
