<?php
/**
 * Třída starající se o vytvoření hlavičky a patičky
 */
class TemplateBasics
{

    /**
     * Vytvoří hlavičku stránky - menu, logo
     */
    public function getHTMLHeader(string $pageTitle, string $cssPath, $logedStatus = 0, $role)
    {
        ?>
        <!doctype html>
        <html>
            <head>
                <meta charset='utf-8'>
                <title><?php echo $pageTitle; ?></title>
                <link rel="stylesheet" href='http://127.0.0.1:8080/CSS/TemplateBasics.css'>
                <link rel="stylesheet" href=<?php echo $cssPath ?>>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                <meta name="viewport" content="width=device-width, initial-scale=1">
            </head>
            <body>
                <nav>
                    <?php
                        // vypis menu
                        echo "<div class=header>";
                        echo "<a href='index.php?page=title' class=logo>MyBlogSpace</a>";
                        echo "<div class=header-right>";
                        foreach (WEB_PAGES as $key => $pInfo) {
                            //přihlášený uživatel
                            if ($logedStatus == 1){
                                if ($key == 'register'){
                                    continue;
                                }
                                if ($key == 'login'){
                                    echo "<a href='index.php?page=$key'>Odhlásit</a>";
                                    continue;
                                }
                                //má roli autora
                                if ($role == 1) {
                                    if ($key == 'clanek' || $key == 'sprava' || $key == 'sprava_post' 
                                        || $key == 'recenze') {
                                        continue;
                                    }
                                    else {
                                        echo "<a href='index.php?page=$key'>$pInfo[title]</a>";
                                    }
                                }
                                //má roli recenzenta
                                else if ($role == 2) {
                                    if ($key == 'sprava' || $key == 'sprava_post' || $key == 'clanek') {
                                        continue;
                                    }
                                    else {
                                        echo "<a href='index.php?page=$key'>$pInfo[title]</a>";
                                    }
                                }
                                //má roli admina
                                else {
                                    if ($key == 'clanek') {
                                        continue;
                                    }else {
                                        echo "<a href='index.php?page=$key'>$pInfo[title]</a>";
                                    }
                                    
                                }
                            }else{
                                //nepřihlášený
                                if ($key == 'clanek' || $key == 'sprava' || $key == 'recenze' || $key == 'sprava_post' 
                                    || $key == 'profil' ){
                                    continue;
                                }
                                else{
                                    echo "<a href='index.php?page=$key'>$pInfo[title]</a>";
                                }
                            }
                        }
                        echo "</div></div>"; ?>
                </nav>
                    <br>
                    <?php
    }
    
    /**
     * Vytvoří a vrátí patičku stránky
     */
    public function getHTMLFooter()
    {
        ?>
            <footer>
                <div class="footer">
                    <p>Semestrální práce z KIV/WEB - Jan Kubice</p>
                </div>
            </footer>
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
                <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
            <body>
        </html>

        <?php
    }
}

?>