<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
$tplData['title'] = 'Správa článků';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/PostManagement.css");
$res = "";


if (isset($tplData['userRole'])) {
    if ($tplData['userRole'] != 3) {
        echo "<div class='alert'>Stránka dostupná pouze pro administrátory</div>";
    } else {
        if (isset($tplData['posts'])) {
            foreach ($tplData['posts'] as $post) {
                $res .= "<h2>$post[nadpis]</h2>";
                $res .= "<p>$post[datum]</p>";
                $res .= "<p>$post[text]</p>";
                $res .= "<p></p>";
                $res .= "<p></p>";
                $res .= "<div>
                <form action=''>
                    <input class='btn btn-warning' data-toggle='modal' data-target='#staticBackdrop' type='button' onclick='savePostId($post[id_prispevek])' name='potvrzeni' value='Vybrat recenzenta'>
                </form>
                </div>";


                $res .= "<div class='modal fade' id='staticBackdrop' data-backdrop='static' data-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title' id='staticBackdropLabel'>Modal title</h5>
                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                      </button>
                    </div>
                    <div class='modal-body'>";
                    
                    foreach ($tplData['reviewers'] as $rev) {
                        $res .= "<div id=$rev[id_uzivatel]>
                                <a>$rev[jmeno]</a>
                                <input class='btn btn-warning' type='button' onclick='saveReviewerId($rev[id_uzivatel])' name='potvrzeni' value='Zvolit'>
                        </div>";                    
                    }

                   $res .= "</div>
                    <div class='modal-footer'>
                      <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
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
        document.getElementById(lastRev).style.color="black";

    document.getElementById(id).style.color="green";
    document.getElementById("revId").value = id;
    document.getElementById("lastRevId").value = id;
}
</script>