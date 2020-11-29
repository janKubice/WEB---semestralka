<?php

// vynuceni chybovych vypisu na serveru students.kiv.zcu.cz
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

// spustim aplikaci
$app = new ApplicationStart();
$app->appStart();

/**
 * Vstupni bod webove aplikace.
 */
class ApplicationStart {

    /**
     * Inicializace webove aplikace.
     */
    public function __construct()
    {
        require_once("settings.inc.php");
        require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");
    }

    /**
     * Spusteni webove aplikace.
     */
    public function appStart(){
        if(isset($_GET["page"]) && array_key_exists($_GET["page"], WEB_PAGES)){
            $pageKey = $_GET["page"]; 
        } else {
            $pageKey = DEFAULT_WEB_PAGE_KEY; 
        }
        $pageInfo = WEB_PAGES[$pageKey];
        require_once(DIRECTORY_CONTROLLERS ."/". $pageInfo["file_name"]);

        $controller = new $pageInfo["class_name"];

        echo $controller->show($pageInfo["title"]);

    }
}

?>