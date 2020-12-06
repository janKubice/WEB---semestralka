<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
// hlavicka
$tplData['title'] = 'Registrace';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/Register.css");

if(isset($tplData['reg_err'])){
    echo "<div class='alert alert-primary' role='alert'>$tplData[registrationStatus]</div>";
}

$res = "<div class='container'><form action='' method='POST'>
    Login:<input type='text' name='login' required>
    Heslo:<input type='password' name='heslo' id='pas1' required>
    Heslo znova:<input type='password' name='heslo2' id='pas2' required>
    Jméno:<input type='text' name='jmeno' required>
    Příjmení:<input type='text' name='prijmeni' required>

<input class='btn btn-success btn-block' type='submit' name='action' value='register'>
</form></div>";

echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>