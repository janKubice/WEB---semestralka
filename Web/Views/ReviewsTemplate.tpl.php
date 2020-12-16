<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
// hlavička
$tplData['title'] = 'Recenze';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/Reviews.css", $tplData['logged'], $tplData['userRole']);

//pokud je zde status zobrazí hlášku statusu
if (isset($tplData['status'])) {
    echo "<div class='alert alert-primary center col-md-6 col-sm-6' role='alert'>$tplData[status]</div>";
}

$res = "";
if (isset($tplData['userRole'])) {
    //hláška s nedostatečnou rolí
    if ($tplData['userRole'] < 2) {
        echo "<div class='center container alert alert-primary col-md-6 col-sm-6'>Stránka dostupná pouze pro administrátory a recenzenty</div>";
    } else {
        //hláška oznamující že recenzent nemá co recenzovat
        if (count($tplData['posts']) == 0) {
            echo "<div class='center container alert alert-primary col-md-6 col-sm-6'>Nemáš žádné články ke schválení</div>";
        }
        // vypsání všech příspěvků k recenzi 
        else if (isset($tplData['posts'])) {
            foreach ($tplData['posts'] as $post) {
                $res .= "<div class='center col-md-6 col-sm-6 jumbotron'>
                            <div class='statusText'></div>
                                <h2>" . htmlspecialchars($post['nadpis']) . "</h2>
                                <p><i class='fa fa-calendar'></i> $post[datum]</p>
                                <p>$post[text]</p>";

                //odkaz ke stažení přílohy
                if (strlen($post['cesta']) > 0){
                    $name = str_replace("Uploads/", "", $post['cesta']);
                    $res .= "<a href=" . htmlspecialchars($post['cesta']) . " download=" . htmlspecialchars($name) . ">Stáhnout přiložený soubor</a>";
                }

                //formuláž na smazání příspěvku
                if (isset($tplData['user']) && ($user['ROLE_id_role'] == 3 || $user['id_uzivatel'] == $post['UZIVATEL_id_uzivatel'])) {
                    $res .= "<div class='center col-md-6 col-sm-6'>
                                <form action='' method='POST'>
                                    <input type='hidden' name='id_post' value='$post[id_prispevek]'>
                                    <input class='btn btn-warning deleteButton' type='submit' name='delete' value='Smazat'>
                                </form>
                            </div>";
                }

                //tlačítko k otevření
                $res .= "</br><i style='cursor: pointer;' onclick='openPost($post[id_prispevek])' class='fa fa-external-link' style='font-size:48px;'></i>";
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

// patička
$tplHeaders->getHTMLFooter()

?>

<script>
    //otevře článek v novém okně
    function openPost(postID){
        openWindowWithPost("index.php?page=clanek", {
            postID: postID,
        });
    }

    //otevře nové okno s url a post daty
    function openWindowWithPost(url, data) {
        var form = document.createElement("form");
        form.target = "_blank";
        form.method = "POST";
        form.action = url;
        form.style.display = "none";

        for (var key in data) {
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = data[key];
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
</script>