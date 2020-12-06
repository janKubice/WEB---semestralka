<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<?php
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/UserManagement.css");

if(isset($tplData['user_action'])){
    echo "<div class='alert'>$tplData[user_action]</div>";
}

if (isset($tplData['userRole'])){
   if ($tplData['userRole'] != 3)
        echo "<div class='alert'>Stránka dostupná pouze pro administrátory</div>";
    else{
        $res = "<table border><tr><th>ID</th><th>Jméno</th><th>Příjmení</th><th>role</th><th>login</th><th>Akce</th></tr>";
        foreach($tplData['users'] as $u){
            $res .= "<tr><td>$u[id_uzivatel]</td><td>$u[jmeno]</td><td>$u[prijmeni]</td><td>$u[ROLE_id_role]</td><td>$u[login]</td>"
                    ."<td><form method='post'>"
                    ."<input type='hidden' name='id_uzivatel' value='$u[id_uzivatel]'>"
                    ."<button type='submit' name='action' value='delete'>Smazat</button>"
                    ."<button type='submit' name='action' value='promote'>Povýšit</button>"
                    ."<button type='submit' name='action' value='demote'>Ponížit</button>"
                    ."</form></td></tr>";
        }
        $res .= "</table>";
        echo $res;
    }
}


// paticka
$tplHeaders->getHTMLFooter()

?>