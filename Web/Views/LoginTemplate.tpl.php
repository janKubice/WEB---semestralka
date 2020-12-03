<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<!-- Vypsani sablony -->
<?php
// hlavicka
$tplData['title'] = 'Přihlášení';
$tplHeaders->getHTMLHeader($tplData['title']);

$res = "<div class=container>";

if (isset($tplData['logged']) && !$tplData['logged']) {
    $res .= "<h2>Přihlášení uživatele</h2>

    <form action='' method='POST'>
        <p>Login:</p><input type='text' placeholder='Uživatelské jméno' name='login' required>
        <p>Heslo:</p><input type='password' placeholder='Heslo' name='heslo' required>
        <input type='hidden' name='action' value='login'>
        <input type='submit' name='potvrzeni' value='Přihlásit'>
    </form>";
} else {
    $res .= "<h2>Ohlášení uživatele</h2>";
    $res .= "<form action='' method='POST'>
                <input type='hidden' name='action' value='logout'>
                <input type='submit' name='potvrzeni' value='Odhlásit'>
            </form>";
}

$res .= "</div>";
echo $res;
// paticka
$tplHeaders->getHTMLFooter()

?>