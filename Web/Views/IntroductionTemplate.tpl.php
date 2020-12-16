<?php
global $tplData;

require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>

<!-- Vypsani sablony -->
<?php
// hlavicka
$tplData['title'] = 'Hlavní stránka';
$tplHeaders->getHTMLHeader($tplData['title'], "http://127.0.0.1:8080/CSS/Introduction.css", $tplData['logged'], $tplData['userRole']);

$res = "";

$res .= "<div class='center col-md-6 col-sm-6 jumbotron'>
            <h1>Proč existuje MyBlogSpace?</h1>
            <p>Jedná se o semestrální práci k předmětu KIV/WEB.</p>
            <h4>Standardní zadání 1 - začátečníci - webové stránky konferenčního systému</h4>
            <ul>
                <li>Vaším úkolem bude vytvořit webové stránky konference.  Téma konference si můžete zvolit libovolné.</li>
                <li>Uživateli systému jsou autoři příspěvků (vkládají abstrakty článků a PDF dokumenty), recenzenti příspěvků (hodnotí příspěvky) a administrátoři (spravují uživatele, přiřazují příspěvky recenzentům k hodnocení a rozhodují o publikování příspěvků). Každý uživatel se do systému přihlašuje prostřednictvím vlastního uživatelského jména a hesla. Nepřihlášený uživatel vidí pouze publikované příspěvky.</li>
                <li>Nový uživatel se může do systému zaregistrovat, čímž získá status autora.</li>
                <li>Přihlášený autor vidí svoje příspěvky a stav, ve kterém se nacházejí (v recenzním řízení / přijat +hodnocení / odmítnut +hodnocení). Své příspěvky může přidávat, editovat a volitelně i mazat. Rozhodnutí, zda autor může editovat či mazat publikované příspěvky je ponecháno na tvůrci systému.</li>
                <li>Přihlášený recenzent vidí příspěvky, které mu byly přiděleny k recenzi, a může je hodnotit (nutně alespoň 3 kritéria hodnocení). Pokud příspěvek nebyl dosud publikován, tak své hodnocení může změnit.</li>
                <li>Přihlášený administrátor spravuje uživatele (určuje jejich role a může uživatele zablokovat či smazat), přiřazuje neschválené příspěvky recenzentům k hodnocení (každý příspěvek bude recenzován minimálně třemi recenzenty) a na základě recenzí rozhoduje o publikování nebo odmítnutí příspěvku. Publikované příspěvky jsou automaticky zobrazovány ve veřejné části webu.</li>
                <li>Databáze musí obsahovat alespoň 3 tabulky, které budou dostatečně naplněny daty tak, aby bylo možné předvést funkčnost aplikace.</p></li>
            </ul>

            <h4>Nutné požadavky</h4>
            <ul>
                <li>Práce musí být osobně předvedena cvičícímu a po schválení odevzdána na CourseWare či Portál.</li>
                <li>K práci musí být dodána dokumentace (viz dále) a skripty pro instalaci databáze (např. získané exportem databáze).</li>
                <li>Aplikace musí dodržovat MVC architekturu.</li>
                <li>Pro práci s databází musí být využito PDO nebo jeho ekvivalent a používány předpřipravené dotazy (prepared statements).</li>
                <li>Web musí obsahovat responzivní design.</li>
                <li>Web musí obsahovat ošetření proti základním typům útoku (XSS, SQL injection).</li>
                <li>Web musí fungovat i s \"ošklivými\" URL adresami.</p></li>
                <li>Aplikaci není možné realizovat s využitím PHP frameworků (zakázáno např. Nette, Symfony atd.).</p></li>
                <li>Front-end je vhodné realizovat s využitím frameworku Bootstrap (getbootstrap.com), popř. lze využít jeho ekvivalent.</p></li>
            </ul>
        </div>";

echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>