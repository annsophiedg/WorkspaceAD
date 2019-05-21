<!DOCTYPE html>
<html lang="nl">

<?php
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/18.12/vrije_opdracht/lib/html_functions.php");
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/18.12/vrije_opdracht/lib/user_functions.php");
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/18.12/vrije_opdracht/lib/connection.php");

PrintHead();

session_start();
$_SESSION['url']=$_SERVER["REQUEST_URI"];

?>

<body>
<header>
    <div id="translayer" class="container">
        <h1>WorkSpace</h1>
        <p id="quote">Improve your skills</p>
    </div>
</header>

<?php PrintNavbar() ?>

<main class="container flex">
    <section class="small flex">

        <?php
        if ( $_POST["login"] == "Login" )
        {
            unset($_POST['login']);      //Login knop uit $_POST verwijderen
            $hash = hash("md5", $_POST["reg_wachtwoord"]);
            //haal de gegevens uit de databank van de persoon die inlogt
            $sql = "SELECT * FROM registratie where reg_email=" . "'" . $_POST["reg_email"] . "'" . " and reg_wachtwoord=" . "'" . $hash . "'";
            $result = $GLOBALS['conn']->query($sql);
            //als er een rij voldoet aan de input-log, zeg Welkom
            if ( $result->num_rows == 1 )
            {
                $row = $result->fetch_assoc();
                $_SESSION["user"] = $row;
                Welkom("");
            } // als de input niet klopt, geef het formulier + foutmelding
            else {
                print "<p id='fout'>Onbekend e-mailadres en/of wachtwoord!</p>";
            }
        }
        ?>

    </section>
</main>
<footer class="container flex">
    &copy; Workshops, januari 2019
</footer>
</body>

</html>