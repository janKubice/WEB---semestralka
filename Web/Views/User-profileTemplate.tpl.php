<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
$tplData['title'] = 'Profil';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/Profile.css", $tplData['logged'], $tplData['userRole']);

//vpsání jak dopadlo vydání článku
if (isset($tplData['releaseStatus'])) {
    echo "<div class='alert alert-primary center col-md-6 col-sm-6' role='alert'>$tplData[releaseStatus]</div>";
}
//vypsání jak dopadlo smazání článku
if (isset($tplData['deleteStatus'])) {
    echo "<div class='alert alert-primary center col-md-6 col-sm-6' role='alert'>$tplData[deleteStatus]</div>";
}


$res = "";

//přihlášený uživatel
if ($tplData['logged']) {
    $u = $tplData['user'];
    $r = $tplData['role'];
    
    //údaje
    $res .= "<div class='col-md-6 col-sm-6 center'> 
            <p class='boldText'>Vaše údaje</p></br>
            <table class='center col-md-6 col-sm-6 jumbotron'>
                <tr>
                    <td>Jméno: </td>
                    <td>" . htmlspecialchars($u['jmeno']) . "</td>
                </tr>
                <tr>
                    <td>Příjmení: </td>
                    <td>" . htmlspecialchars($u['prijmeni']) . "</td>
                </tr>
                <tr>
                    <td>Přezdívka: </td>
                    <td>" . htmlspecialchars($u['login']) . "</td>
                </tr>
                <tr>
                    <td>Role: </td>
                    <td>$r[nazev]</td>
                </tr>
            </table>
            </div>";

    //Psaní článku
    $res .= "<div class='divLeft'></div>
                <div><p class='newPostText center col-md-6 col-sm-6'>Napsat nový článek</p></div>
                <div class='postWriting center col-md-6 col-sm-6 jumbotron'>
                    <form action='' method='POST' id='postForm' enctype='multipart/form-data'>
                        <div><p>Titulek</p><input type='text' size='50' name='title' required></div>
                        <div><p>Text:</p>
                        <i class='fas fa-pencil-alt prefix'></i>
                        <textarea id='editor' class='md-textarea form-control' rows='3' name='text' form='postForm'>Enter text here...</textarea></div>
                        <input form='postForm' id='fileToUpload' name='fileToUpload' type='file'/>
                        <input class='btn btn-success btn-block' type='submit' name='action' value='Vydat'>
                    </form>
                </div>";

    //vypsání uživatelovo článků
    if (isset($tplData['posts'])) {
        foreach ($tplData['posts'] as $post) {
            $res .= "<div class='center col-md-6 col-sm-6 post jumbotron'>";
            $res .= "<form action='' method='POST'>
                            <input type='hidden' name='id_post' value='$post[id_prispevek]'>
                            <input class='btn btn-warning deleteButton' type='submit' name='delete' value='Smazat'>
                    </form>";

            $res .= "<div class='statusText'>";
            //příspevek má recenzenta
            if ($post['id_recenzent'] > 0 && $post['id_recenzent'] != null) {
                //příspěvek byl zrecenzovan
                if ($post['recenzovano'] == 1) {
                    $res .= "<p class='text-success'>schváleno</p>";
                }
                //příspěvek nebyl zrecenzovan
                else {
                    $res .= "<p class='text-danger'>ještě neschváleno</p>";
                }
            }
            //příspěvěk nemu recenzenta
            else {
                $res .= "<p class='text-primary'>čeká na přiřazení</p>";
            }
            $res .= "</div>";
            $res .= "<i style='cursor: pointer;' onclick='openPost($post[id_prispevek])' class='fa fa-external-link openPost' style='font-size:48px;'></i>
                    <h2>" . htmlspecialchars($post['nadpis']) . "</h2>
                    <p><i class='fa fa-calendar'></i> $post[datum]</p>
                    <p>" . htmlspecialchars($post['text']) . "</p>";
            if (strlen($post['cesta']) > 0){
                $name = str_replace("Uploads/", "", $post['cesta']);
                $res .= "<a href=" . htmlspecialchars($post['cesta']) . " download=" . htmlspecialchars($name) . ">Stáhnout přiložený soubor</a>";
            }
            $res .= "</div>";
            
        }
    }
} else {
    //nepřihlášený uživatel
    $res .= "<div class='center'>
                <h2>Pro zobrazení profilu se přihlašte</h2> 
                <h2>Pokud nemáte účet, můžete si jeden zdarma vytvořit:
                <a class='regBtn' href='index.php?page=register'>Registrovat</a></h2> 
            </div></br></br>";
}
echo $res;

//patička
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

    //CKeditor script
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
