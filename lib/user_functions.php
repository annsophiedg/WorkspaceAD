<?php

function Login()
{
    if ( isset($_SESSION["user"]))
    {
        Welkom (logform);
    } //zoniet check $_POST
    elseif ( $_POST["login"] == "Login" )
    {
        unset($_POST['login']);      //Login knop uit $_POST verwijderen
        $hash = hash("md5", $_POST["reg_wachtwoord"]);
        //haal de gegevens uit de databank van de persoon die inlogt
        $sql = "SELECT * FROM registratie where reg_email=" . "'" . $_POST["reg_email"] . "'" . " and reg_wachtwoord=" . "'" . $hash . "'";
        $result = $_SERVER['conn']->query($sql);
        //als er een rij voldoet aan de input-log, zeg Welkom
        if ( $result->num_rows == 1 )
        {
            $row = $result->fetch_assoc();
            $_SESSION["user"] = $row;
            Welkom(logform);
        } // als de input niet klopt, geef het formulier + foutmelding
        else {
            ToonLoginForm(logform,"","<p id='fout'>Onbekend e-mailadres en/of wachtwoord!</p>");
        }
    } //als geen $_POST, geef het inlogformulier
    else {
        ToonLoginForm(logform,"","");
    }
}

function Welkom ($id) {
print   "<p id='".$id."' class='welkom flex flexC'>Welkom, " . $_SESSION["user"]["reg_voornaam"] . "!<br>
            <span class='flex'><a href='http://localhost/18.12/vrije_opdracht/geg/profiel.php'>Mijn profiel</a>
            <a href='http://localhost/18.12/vrije_opdracht/log/loguit.php'>Log uit</a></p></span>" ;
}

function ToonLoginForm($idform,$classform,$fout) {
$arr_login = array(
"E-mail" => "reg_email",
"Wachtwoord" => "reg_wachtwoord"
);
print '<form id="'.$idform.'" class="'.$classform.' flex" method=POST action="'.$action.'">
    <fieldset>
        <legend>Login</legend>
        <ul>';
            foreach( $arr_login as $label => $name )
            {
            print '<li class="flex">';
                $type = "email";
                if ( $name == "reg_wachtwoord" ) $type = "password";
                print '<input type="' . $type . '" class="form-control" id="' . $name . '" name="' . $name . '" value="" placeholder="' . $label . '" required>';
                print '</li>';
            }
            print '</ul>
    </fieldset>
    <div id="logreg" class="flex flexC"><input type="submit" name="login" value="Login">';
    if ($idform == "logform") {
        print '<a id="reg" href="http://localhost/18.12/vrije_opdracht/reg/registreer.php">Registreer</a>';
    } print '</div>';
    print $fout.
'</form>';
}

?>