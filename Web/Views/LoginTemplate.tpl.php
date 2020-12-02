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

$res = "";

if (isset($tplData['logged']) && !$tplData['logged']){
    $res .= "<h2>Přihlášení uživatele</h2>

    <form action='' method='POST'>
        <table>
            <tr><td>Login:</td><td><input type='text' name='login'></td></tr>
            <tr><td>Heslo:</td><td><input type='password' name='heslo'></td></tr>
        </table>
        <input type='hidden' name='action' value='login'>
        <input type='submit' name='potvrzeni' value='Přihlásit'>
    </form>";
}

echo $res;
// paticka
$tplHeaders->getHTMLFooter()

?>