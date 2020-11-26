<?php
//////////////////////////////////////////////////////////////////
/////////////////  Globalni nastaveni aplikace ///////////////////
//////////////////////////////////////////////////////////////////

//// Pripojeni k databazi ////

/** Adresa serveru. */
define("DB_SERVER","147.228.63.10"); // https://students.kiv.zcu.cz
/** Nazev databaze. */
define("DB_NAME","db1_vyuka");
/** Uzivatel databaze. */
define("DB_USER","db1_vyuka");
/** Heslo uzivatele databaze */
define("DB_PASS","db1_vyuka");


//// Nazvy tabulek v DB ////

/** Tabulka s pohadkami. */
define("TABLE_INTRODUCTION", "orionlogin_mvc_introduction");
/** Tabulka s uzivateli. */
define("TABLE_USER", "orionlogin_mvc_user");


//// Dostupne stranky webu ////

/** Adresar kontroleru. */
const DIRECTORY_CONTROLLERS = "Controllers";
/** Adresar modelu. */
const DIRECTORY_MODELS = "Models";
/** Adresar sablon */
const DIRECTORY_VIEWS = "Views";

/** Dostupne webove stranky. */
const WEB_PAGES = array(
    // uvodni stranka
    "uvod" => array("file_name" => "IntroductionController.class.php",
                    "class_name" => "IntroductionController",
                    "title" => "Úvodní stránka"),
    // sprava uzivatelu
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
);

/** Klic defaultni webove stranky. */
const DEFAULT_WEB_PAGE_KEY = "uvod";

?>