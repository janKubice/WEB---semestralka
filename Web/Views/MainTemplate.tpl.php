<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
// hlavicka
$tplData['title'] = 'Články';
$tplHeaders->getHTMLHeader($tplData['title'],"http://127.0.0.1:8080/CSS/UserManagement.css");

$res = "";

if (isset($tplData['posts'])){
    foreach ($tplData['posts'] as $post) {
       $res .= "<h2>$post[nadpis]</h2>";
       $res .= "<p>$post[datum]</p>"; 
       $res .= "<p>$post[text]</p>";
       $res .= "<p></p>";
       $res .= "<p></p>";

       if ($tplData['userRole'] == 3){
        $res .= "<div>
        <form action='' method='POST'>
            <input type='hidden' name='id_post' value='$post[id_prispevek]'>
            <input class='btn btn-warning' type='submit' name='delete' value='Smazat'>
        </form>
        </div>";
       }
    }
}

echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>