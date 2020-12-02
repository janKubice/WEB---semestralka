<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
// hlavicka
$tplData['title'] = 'Registrace';
$tplHeaders->getHTMLHeader($tplData['title']);

if(isset($tplData['reg_err'])){
    echo "<div class='alert'>$tplData[reg_err]</div>";
}
if(isset($tplData['reg_suc'])){
    echo "<div class='alert'>$tplData[reg_suc]</div>";
}

$res = "<form action='' method='POST' oninput='x.value=(pas1.value==pas2.value)?'OK':'Nestejná hesla''>
<table>
    <tr><td>Login:</td><td><input type='text' name='login' required></td></tr>
    <tr><td>Heslo 1:</td><td><input type='password' name='heslo' id='pas1' required></td></tr>
    <tr><td>Heslo 2:</td><td><input type='password' name='heslo2' id='pas2' required></td></tr>
    <tr><td>Ověření hesla:</td><td><output name='x' for='pas1 pas2'></output></td></tr>
    <tr><td>Jméno:</td><td><input type='text' name='jmeno' required></td></tr>
    <tr><td>Příjmení:</td><td><input type='text' name='prijmeni' required></td></tr>
</table>

<input type='submit' name='action' value='register'>
</form>";

echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>