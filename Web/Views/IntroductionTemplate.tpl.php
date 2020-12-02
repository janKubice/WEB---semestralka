<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<!-- Vypsani sablony -->
<?php
// hlavicka
$tplData['title'] = 'Hlavní stránka';
$tplHeaders->getHTMLHeader($tplData['title']);

// paticka
$tplHeaders->getHTMLFooter()

?>