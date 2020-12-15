<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
// hlavička
if (!isset($tplData['title'])){
    $tplData['title'] = "Nenalázá se zde žádný článek";
}

$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/Post.css", $tplData['logged'], $tplData['userRole']);
$res = "";


//vypsání článku
if (isset($tplData['post'])){
    $post = $tplData['post'];
    $user = $tplData['user'];
    $res .= "<div class='center col-md-6 col-sm-6 post jumbotron'>
                <div class='statusText'></div><h2>" . htmlspecialchars($post['nadpis']) . "</h2>
                    <p><i class='fa fa-calendar'></i> $post[datum]</p>
                    <p>" . htmlspecialchars($post['text']) . "</p>";

    if (isset($tplData['user']) && ($user['ROLE_id_role'] == 3 || $user['id_uzivatel'] == $post['UZIVATEL_id_uzivatel'])){
        $res .= "<div class='center col-md-6 col-sm-6'>
                    <form action='' method='POST'>
                        <input type='hidden' name='id_post' value='$post[id_prispevek]'>
                        <input class='btn btn-warning' type='submit' name='delete' value='Smazat'>
                    </form>
                </div></div>";
    }     
}
//hláška pokud se na stránce nenachází článek
else{
    $res .= "<div class='center container alert alert-primary col-md-6 col-sm-6'>Nenachází se zde žádný článek</div>";
}

echo $res;

// patička
$tplHeaders->getHTMLFooter()

?>