<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
$tplData['title'] = 'Profil';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/Profile.css");

//vpsání jak dopadlo vydání článku
if (isset($tplData['releaseStatus'])) {
    echo "<div class='alert alert-primary' role='alert'>$tplData[releaseStatus]</div>";
}

$res = "";

//přihlášený uživatel
if ($tplData['logged']) {
    $u = $tplData['user'];
    $r = $tplData['role'];
    $res .= "<div> 
                <p>Údaje</p>
                <p>$u[jmeno]</p>
                <p>$u[prijmeni]</p>
                <p>$u[login]</p>
                <p>$r[nazev]</p>
            </div>";

    $res .= "<div class='jumbotron'><form action='' method='POST'>
        Titulek:<input type='text' name='title' required>
        Text:<input type='text' name='text' required>
        <input class='btn btn-success btn-block' type='submit' name='action' value='Vydat'>
        </form></div>";

    if (isset($tplData['posts'])) {
        foreach ($tplData['posts'] as $post) {
            $res .= "<h2>$post[nadpis]</h2>";
            $res .= "<p>$post[datum]</p>";
            $res .= "<p>$post[text]</p>";
            $res .= "<p></p>";
            $res .= "<p></p>";
    
            
            $res .= "<div>
            <form action='' method='POST'>
                <input type='hidden' name='id_post' value='$post[id_prispevek]'>
                <input class='btn btn-warning' type='submit' name='delete' value='Smazat'>
            </form>
            </div>";
        }
    }
} else {
    //nepřihlášený uživatel
    $res .= "<h2>Pro zobrazení profilu se přihlašte</h2>";
    $res .= "<h2>Pokud nejste registrovaní, vytvořte si profil</h2><a href='index.php?page=register'>Registrovat</a>";
}

echo $res;
$tplHeaders->getHTMLFooter()

?>