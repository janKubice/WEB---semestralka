<?php
///////////////////////////////////////////////////////////////////
////////////// Stranka pro prihlaseni/odhlaseni uzivatele ////////////////
///////////////////////////////////////////////////////////////////

    // nacteni souboru s funkcemi
    require_once("MyDatabase.class.php");
    $db = new MyDatabase();

    // nacteni hlavicky stranky
    require_once("ZakladHTML.class.php");
    ZakladHTML::createHeader("Přihlášení a odhlášení uživatele");


    // zpracovani odeslanych formularu
    if (isset($_POST['action'])){
        if ($_POST['action'] == 'login' && isset($_POST['login']) && isset($_POST['heslo'])){
            $res = $db->userLogin($_POST['login'], $_POST['heslo']);
            if ($res)
                echo "OK: UZIVATEL LOGGGNUUtý";
            else
                echo "ERROR prihlaseni se nepovedlo";
        }
        else if ($_POST['action'] == 'logout'){
            $db->userLogout();
            echo "OK: uzivatel odhlásen";
        }
        else
            echo "NEznámá akce";
        
        echo"<br>";
    }


    ///////////// PRO NEPRIHLASENE UZIVATELE ///////////////
    if (!$db->isUserLogged()){
        ?>
            <h2>Přihlášení uživatele</h2>

            <form action="" method="POST">
                <table>
                    <tr><td>Login:</td><td><input type="text" name="login"></td></tr>
                    <tr><td>Heslo:</td><td><input type="password" name="heslo"></td></tr>
                </table>
                <input type="hidden" name="action" value="login">
                <input type="submit" name="potvrzeni" value="Přihlásit">
            </form>
        <?php
    }

    ///////////// KONEC: PRO NEPRIHLASENE UZIVATELE ///////////////
else {
        $user = $db->getLoggedUserData();
        $pravo = $db->getRightById($user["id_pravo"]);
        $pravoNazev = ($pravo == null) ? "*Neznámé*" : $pravo['nazev'];
        ?>
        <h2>Přihlášený uživatel</h2>

        Login: <?= $user['login']  ?><br>
        Jméno: <?= $user['jmeno'] ?><br>
        E-mail: <?= $user['email'] ?><br>
        Právo: <?= $pravoNazev ?><br>
        <br>

        Odhlášení uživatele:
        <form action="" method="POST">
            <input type="hidden" name="action" value="logout">
            <input type="submit" name="potvrzeni" value="Odhlásit">
        </form>
    <?php
}
    ///////////// PRO PRIHLASENE UZIVATELE /////////////



    ///////////// KONEC: PRO PRIHLASENE UZIVATELE ///////////////

    // paticka
    ZakladHTML::createFooter();
?>
