<?php
//////////////////////////////////////////////////////////////
////////////// HTML Zaklad vsech stranek webu ////////////////
//////////////////////////////////////////////////////////////

/**
 * Trida pro vypis hlavicky a paticky HTML stranky.
 */
class HTMLMaker {

    /**
     *  Vytvoreni hlavicky stranky.
     *  @param string $title Nazev stranky.
     */
    public static function createHeader($title="WEB"){
        ?>
        <!doctype html>
        <html lang="cs">
            <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title><?= $title ?></title>

                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
                    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

                    <link rel="stylesheet" href="../CSS/style_profile.css" />
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
                
            </head>
            <body>
            <div class="topnav">
        <div class="mainPanelButtons">
            <a href="">Profile</a>
            <a href="#news">Main page</a>
            <a href="#contact">Logout</a>
        </div>
        <div class="mainPanelLogo">
            <a>LOGO ZDE</a>
        </div>
    </div>
        <?php
    }

    /**
     *  Vytvoreni paticky.
     */
    public static function createFooter(){
        ?>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>
                <footer>
                    &copy; <?= date("Y-m-d") ?> Jan Kubice
                </footer>

                
            </body>
        </html>
        <?php
    }

}
?>
