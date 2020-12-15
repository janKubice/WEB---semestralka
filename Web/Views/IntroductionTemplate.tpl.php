<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<!-- Vypsani sablony -->
<?php
// hlavicka
$tplData['title'] = 'Hlavní stránka';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/Introduction.css", $tplData['logged'], $tplData['userRole']);

$res = "";


echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>