<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
// hlavicka
$tplData['title'] = 'Články';
$tplHeaders->getHTMLHeader($tplData['title']);

$res = "";

if (isset($tplData['posts'])){
    foreach ($tplData['posts'] as $post) {
       $res .= "<h2>$post[nadpis]</h2>";
       $res .= "<p>$post[datum]</p>"; 
       $res .= "<p>$post[text]</p>";
       $res .= "<p></p>";
       $res .= "<p></p>";
    }
}

echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>