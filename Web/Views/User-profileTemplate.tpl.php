<?php
    global $tplData;

    require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
    $tplHeaders = new TemplateBasics();

    ?>

    <?php
    $tplData['title'] = 'profil';
    $tplHeaders->getHTMLHeader($tplData['title']);

  
    $tplHeaders->getHTMLFooter()
?>
