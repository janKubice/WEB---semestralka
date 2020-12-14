<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
// hlavicka
$tplData['title'] = 'Články';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/UserManagement.css", $tplData['logged'], $tplData['userRole']);
$user = $tplData['user'];
$res = "";

if (isset($tplData['posts'])) {
    foreach ($tplData['posts'] as $post) {
        $res .= "<div class='center col-md-6 col-sm-6 post jumbotron'>";

        $res .= "<div class='statusText'>";
        $res .= "</div>";
        $res .= "<h2>$post[nadpis]</h2>
                    <p><i class='fa fa-calendar'></i> $post[datum]</p>
                    <p>$post[text]</p>";

        if (strlen($post['cesta']) > 0){
            $name = str_replace("Uploads/", "", $post['cesta']);
            $res .= "<a href=$post[cesta] download=$name>Stáhnout přiložený soubor</a></br>";
        }

        if (isset($tplData['user']) && ($user['ROLE_id_role'] == 3 || $user['id_uzivatel'] == $post['UZIVATEL_id_uzivatel'])) {
            $res .= "<div class='center col-md-6 col-sm-6'>
        <form action='' method='POST'>
            <input type='hidden' name='id_post' value='$post[id_prispevek]'>
            <input class='btn btn-warning deleteButton' type='submit' name='delete' value='Smazat'>
        </form>
        </div>";
        }
        $res .= "<i style='cursor: pointer;' onclick='openPost($post[id_prispevek])' class='fa fa-external-link openPost' style='font-size:48px;'></i>";
        $res .= "</div></div>";
    }
}

echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>

<script>
    function openPost(postID){
        openWindowWithPost("index.php?page=clanek", {
            postID: postID,
        });
    }

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