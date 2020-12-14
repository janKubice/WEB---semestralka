<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
$tplData['title'] = 'Správa článků';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/PostManagement.css", $tplData['logged'], $tplData['userRole']);
$res = "";


if (isset($tplData['userRole'])) {
    if ($tplData['userRole'] != 3) {
        echo "<div class='alert'>Stránka dostupná pouze pro administrátory</div>";
    } else {
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
                $res .= "<form action=''>
              <input class='btn btn-warning' data-toggle='modal' data-target='#staticBackdrop' type='button' onclick='savePostId($post[id_prispevek])' name='potvrzeni' value='Vybrat recenzenta'>
          </form>";
                $res .= "</div></div>";
                $res .= "<div></div>";


                $res .= "<div class='modal fade' id='staticBackdrop' data-backdrop='static' data-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title' id='staticBackdropLabel'>Vybrat recenzenta</h5>
                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                      </button>
                    </div>
                    <div class='modal-body'>";
                    

                $res .= "<table class='center style= width=100%; jumbotron'>";
                foreach ($tplData['reviewers'] as $rev) {
                    $res .= "<tr id=$rev[id_uzivatel]>
                        <td>
                        $rev[jmeno] $rev[prijmeni] ($rev[login])
                        </td>
                        <td><input class='btn btn-warning' type='button' onclick='saveReviewerId($rev[id_uzivatel])' name='potvrzeni' value='Zvolit'></td>
                    </tr>";
                }

                $res .= "</table></div>
                    <div class='modal-footer'>
                      <button type='button' class='btn btn-secondary' data-dismiss='modal'>Zavřít</button>
                      <form action='' method='POST'>
                      <input class='btn btn-warning' type=hidden id='lastRevId'>
                      <input class='btn btn-warning' type=hidden id='postId' name='post_id'>
                      <input class='btn btn-warning' type=hidden id='revId' name='reviewer_id'>
                        <input class='btn btn-warning' type='submit' name='potvrzeni' value='Uložit'>
                    </form>
                    </div>
                  </div>
                </div>
              </div>";
            }
        }
    }
}

$res .= "</br></br>";
echo $res;
// paticka
$tplHeaders->getHTMLFooter()

?>

<script>
function savePostId(id) {
    document.getElementById("postId").value = id;
}

function saveReviewerId(id) {
    var lastRev = document.getElementById("lastRevId").value;
    if (lastRev > 0)
        document.getElementById(lastRev).style.backgroundColor = "white";

    document.getElementById(id).style.backgroundColor  = "green";
    document.getElementById("revId").value = id;
    document.getElementById("lastRevId").value = id;
}

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