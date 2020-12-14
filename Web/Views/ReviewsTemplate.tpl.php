<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
// hlavicka
$tplData['title'] = 'Recenze';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/Reviews.css", $tplData['logged'], $tplData['userRole']);

$res = "";
if (isset($tplData['userRole'])) {
    if ($tplData['userRole'] < 2) {
        echo "<div class='center container alert alert-primary col-md-6 col-sm-6'>Stránka dostupná pouze pro administrátory a recenzenty</div>";
    } else {
        if (count($tplData['posts']) == 0) {
            echo "<div class='center container alert alert-primary col-md-6 col-sm-6'>Nemáš žádné články ke schválení</div>";
        } elseif (isset($tplData['posts'])) {
            foreach ($tplData['posts'] as $post) {
                $res .= "<div class='center col-md-6 col-sm-6 jumbotron'>";

                $res .= "<div class='statusText'>";
                $res .= "</div>";
                $res .= "<h2>$post[nadpis]</h2>
                    <p><i class='fa fa-calendar'></i> $post[datum]</p>
                    <p>$post[text]</p>";

                if (strlen($post['cesta']) > 0){
                    $name = str_replace("Uploads/", "", $post['cesta']);
                    $res .= "<a href=$post[cesta] download=$name>Stáhnout přiložený soubor</a>";
                }

                if (isset($tplData['user']) && ($user['ROLE_id_role'] == 3 || $user['id_uzivatel'] == $post['UZIVATEL_id_uzivatel'])) {
                    $res .= "<div class='center col-md-6 col-sm-6'>
        <form action='' method='POST'>
            <input type='hidden' name='id_post' value='$post[id_prispevek]'>
            <input class='btn btn-warning deleteButton' type='submit' name='delete' value='Smazat'>
        </form>
        </div>";
                }
                $res .= "</br><i style='cursor: pointer;' onclick='openPost($post[id_prispevek])' class='fa fa-external-link openPost' style='font-size:48px;'></i>";
                $res .= "
                <form action='' method='POST'>
                    <input type='hidden' name='id_post' value='$post[id_prispevek]'>
                    <input class='btn btn-warning' type='submit' name='potvrzeni' value='Schválit'>
                    <input class='btn btn-warning' type='submit' name='potvrzeni' value='Zamítnout'>
                </form>
                </div></div></div>";
            }
        }
    }
}

echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>