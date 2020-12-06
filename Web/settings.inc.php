<?php
//////////////////////////////////////////////////////////////////
/////////////////  Globalni nastaveni aplikace ///////////////////
//////////////////////////////////////////////////////////////////

//// Pripojeni k databazi ////

define("DB_SERVER","localhost");
define("DB_NAME","weby_sp");
define("DB_USER","root");
define("DB_PASS","");


//// Nazvy tabulek v DB ////

define("TABLE_ROLE", "role");
define("TABLE_USER", "uzivatel");
define("TABLE_COMMENT", "komentar");
define("TABLE_POST", "prispevek");


//// Dostupne stranky webu ////

/** Adresar kontroleru. */
const DIRECTORY_CONTROLLERS = "Controllers";
/** Adresar modelu. */
const DIRECTORY_MODELS = "Models";
/** Adresar sablon */
const DIRECTORY_VIEWS = "Views";

/** Dostupne webove stranky. */
const WEB_PAGES = array(
    "title" => array("file_name" => "IntroductionController.class.php",
                    "class_name" => "IntroductionController",
                    "title" => "Úvodní stránka"),
    "sprava" => array("file_name" => "UserManagementController.class.php",
                    "class_name" => "UserManagementController",
                    "title" => "Správa uživatelů"),
    "profil" => array("file_name" => "ProfileController.class.php",
                    "class_name" => "ProfileController",
                    "title" => "Profil"),
    "register" => array("file_name" => "RegisterController.class.php",
                    "class_name" => "RegisterController",
                    "title" => "Registrace"),
    "login" => array("file_name" => "LoginController.class.php",
                    "class_name" => "LoginController",
                    "title" => "Přihlášení"),
    "main" => array("file_name" => "MainController.class.php",
                    "class_name" => "MainController",
                    "title" => "Hlavní stránka"),
    "sprava_post" => array("file_name" => "PostManagementController.class.php",
                    "class_name" => "PostManagementController",
                    "title" => "Správa článků"),
    "recenze" => array("file_name" => "ReviewsController.class.php",
                    "class_name" => "ReviewsController",
                    "title" => "Recenze"),
);

/** Klic defaultni webove stranky. */
const DEFAULT_WEB_PAGE_KEY = "title";

?>