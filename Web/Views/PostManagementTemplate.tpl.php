<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
$tplData['title'] = 'Správa článků';
$tplHeaders->getHTMLHeader($tplData['title']);

if (isset($tplData['userRole'])) {
    if ($tplData['userRole'] != 3) {
        echo "<div class='alert'>Stránka dostupná pouze pro administrátory</div>";
    } else {
    }
}

// paticka
$tplHeaders->getHTMLFooter()

?>