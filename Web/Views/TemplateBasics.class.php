<?php
/**
 * Třída starající se o vytvoření hlavičky a patičky
 */
class TemplateBasics {

    /**
     * Vytvoří hlavičku stránky - menu, logo
     */
    public function getHTMLHeader(string $pageTitle) {
        ?>
        <!doctype html>
        <html>
            <head>
                <meta charset='utf-8'>
                <title><?php echo $pageTitle; ?></title>
                <link rel="stylesheet" href="http://127.0.0.1:8080/CSS/TemplateBasics.css">
                <link rel="stylesheet" href="http://127.0.0.1:8080/CSS/Login.css">
                <meta name="viewport" content="width=device-width, initial-scale=1">
            </head>
            <body>
                <nav>
                    <?php
                        // vypis menu
                        echo "<div class=header>";
                        echo "<a href=#default class=logo>CompanyLogo</a>";
                        echo "<div class=header-right>";
                        foreach(WEB_PAGES as $key => $pInfo){
                            echo "<a href='index.php?page=$key'>$pInfo[title]</a>";
                        }
                        echo "</div>
                        </div>";
                        
                    ?>
                </nav>
                <br>
        <?php
    }
    
    /**
     * Vytvoří a vrátí patičku stránky
     */
    public function getHTMLFooter(){
        ?>
                <div class="footer">
                    <p>Semestrální práce z KIV/WEB - Jan Kubice</p>
                </div>
            <body>
        </html>

        <?php
    }
        
}

?>