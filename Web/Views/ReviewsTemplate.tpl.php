<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
// hlavicka
$tplData['title'] = 'Recenze';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/Reviews.css");

$res = "";
if (isset($tplData['userRole'])) {
    if ($tplData['userRole'] < 2) {
        echo "<div class='alert'>Stránka dostupná pouze pro administrátory a recenzenty</div>";
    } else {
        if (count($tplData['posts']) == 0) {
            echo "<div class='alert'>Nemáž žádné články ke schválení</div>";
        } elseif (isset($tplData['posts'])) {
            foreach ($tplData['posts'] as $post) {
                $res .= "<h2>$post[nadpis]</h2>";
                $res .= "<p>$post[datum]</p>";
                $res .= "<p>$post[text]</p>";
                $res .= "<p></p>";
                $res .= "<p></p>";
                $res .= "<div>";
                $res .= "<div>
                <form action='' method='POST'>
                    <input type='hidden' name='id_post' value='$post[id_prispevek]'>
                    <input class='btn btn-warning' type='submit' name='potvrzeni' value='Schválit'>
                    <input class='btn btn-warning' type='submit' name='potvrzeni' value='Zamítnout'>
                </form>
                </div>";
            }
        }
    }
}

echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>