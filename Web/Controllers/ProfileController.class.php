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
                $res = $this->db->deletePost($_POST['id_post']);
                
                if ($res){
                    $tplData['deleteStatus'] = "Článek se podařilo úspěšně smazat";
                } else {
                    $tplData['deleteStatus'] = "Článek se nepodařilo smazat";
                }
            }
        }

        //požadavek na vydání článku?
        if (isset($_POST['action']) && $_POST['action'] == "Vydat") {
            $target_dir = "Uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            if (isset($_FILES["fileToUpload"])){
                if ($_FILES["fileToUpload"]["size"] > 5000000) {
                    $tplData['uploadStatus'] = "Soubor je příliš veliký";
                    $uploadOk = 0;
                }
            }   
            if ($uploadOk == 0) {
                $tplData['uploadStatus'] .= ", tvůj soubor se nepodařilo nahrát";
            } else {
              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $res = $this->db->addPost($_POST['title'], $_POST['text'], $target_file);
                    if ($res) {
                        $tplData['releaseStatus'] = "Článek v pořádku vyšel";
                    } else {
                        $tplData['releaseStatus'] = "Článek se nepodařilo vydat";
                    }
              } else {
                $tplData['uploadStatus'] = "Nepodařilo se nehrát soubor, článek se nepodařilo vydat";
              }
            }
        }
       
        //pokud je uživatel přihlášený načtou se jeho data
        if ($this->db->isUserLogged()) {
            $tplData['logged'] = $this->db->isUserLogged();
            $tplData['user'] = $this->db->getLoggedUserData();
            $tplData['role'] = $this->db->getUserRole(intval($tplData['user']['ROLE_id_role']));
            $tplData['posts'] = $this->db->getUserPosts($tplData['user']['id_uzivatel']);
        }
        else {
            $tplData['role'] = -1;
        }
        
        $tplData['logged'] = $this->db->isUserLogged();
        ob_start();
        require(DIRECTORY_VIEWS ."/User-profileTemplate.tpl.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}
