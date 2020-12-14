<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<!-- Vypsani sablony -->
<?php
// hlavicka
$tplData['title'] = 'Přihlášení';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/Login.css", $tplData['logged'], $tplData['userRole']);



if(isset($tplData['loginStatus'])){
    echo "<div class='center alert alert-danger col-md-6 col-sm-6'>$tplData[loginStatus]</div>";
}

$res = "<div class=container>";

if (isset($tplData['logged']) && !$tplData['logged']) {
    $res .= "<h2 class='center'>Přihlášení uživatele</h2>

    <form action='' method='POST'>
        <p>Login:</p><input type='text' placeholder='Uživatelské jméno' name='login' required>
        <p>Heslo:</p><input type='password' placeholder='Heslo' name='heslo' required>
        <input type='hidden' name='action' value='login'>
        <input class='btn btn-success' type='submit' name='potvrzeni' value='Přihlásit'>
    </form>";
} else {
    $res .= "<h2 class='center'>Odhlášení uživatele</h2></br>";
    $res .= "<form class='center' action='' method='POST'>
                <input type='hidden' name='action' value='logout'>
                <input class='btn btn-warning' type='submit' name='potvrzeni' value='Odhlásit'>
            </form>";
}

$res .= "</div>";
echo $res;
// paticka
$tplHeaders->getHTMLFooter()

?>