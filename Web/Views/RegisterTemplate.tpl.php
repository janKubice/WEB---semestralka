<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
// hlavička
$tplData['title'] = 'Registrace';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/Register.css", $tplData['logged'], $tplData['userRole']);

//Informace o registraci
if (isset($tplData['registrationStatus'])) {
    echo "<div class='center container alert alert-primary col-md-6 col-sm-6'>$tplData[registrationStatus]</div>";
}

//vytvoření registračního formuláře
$res = "<div class='center'>
            <form class='container' action='' method='POST'>
                <div><p>Login:</p> <input type='text' placeholder='uživatelské jméno' name='login' required></div>
                <div><p>Heslo:</p><input type='password' placeholder='heslo' name='heslo' id='pas1' required></br></div>
                <div><p>Heslo znova:</p><input type='password' placeholder='heslo podruhé' name='heslo2' id='pas2' required></br></div>
                <div><p>Jméno:</p><input type='text' placeholder='jméno' name='jmeno' required></br></div>
                <div><p>Příjmení:</p><input type='text' placeholder='přijmení' name='prijmeni' required></br></div>
                <input class='btn btn-success col-md-4 col-lg-4 col-xl-4 col-sm-4' type='submit' name='action' value='register'>
            </form>
        </div></br></br>";

echo $res;

// patička
$tplHeaders->getHTMLFooter()

?>