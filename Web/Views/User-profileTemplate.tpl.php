<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<!-- Vypsani sablony -->
<?php
// hlavicka
$tplData['title'] = 'Profil';
$tplHeaders->getHTMLHeader($tplData['title']);

$res = "";

if ($tplData['logged']){
    $u = $tplData['user'];
    $res .= "<p>$u[jmeno]</p>";
    $res .= "<p>$u[prijmeni]</p>";
    $res .= "<p>$u[login]</p>";
    $res .= "<p>$u[ROLE_id_role]</p>";
}
else{
    $res .= "<h2>Pro zobrazení profilu se přihlašte</h2>";
    $res .= "<h2>Pokud nejste registrovaní, vytvořte si profil</h2><a href='index.php?page=register'>Registrovat</a>";
}

echo $res;
// paticka
$tplHeaders->getHTMLFooter()

?>