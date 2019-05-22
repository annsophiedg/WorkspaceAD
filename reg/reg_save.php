<?php
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/lib/connection.php");

if ( $_POST["reg_save"] )
{
    $reg_val = $_POST["reg_save"];
    unset($_POST['reg_save']);          //Save element uit $_POST verwijderen
    unset($_POST['reg_checkww']);       //checkww niet wegschrijven

    //sleutel-waardenparen opslaan met = en '
    foreach( $_POST as $name => $value )
    {
        if ( $name == "reg_wachtwoord" ) $value = hash("md5", $_POST["reg_wachtwoord"]);
        $pairs[] = $name . "=" . "'" . $value . "'" ;
    }

    //update statement maken; gebruik implode()
    $sql = "INSERT INTO vo_registratie SET " . implode(", " , $pairs ) ;

    //SQL uitvoeren
    if ($conn->query($sql) === TRUE) {
        //auto login na registratie
        session_start();
        $sql_login = "SELECT * FROM vo_registratie where reg_email='" . $_POST["reg_email"] ."'";
        $res_login = $_SERVER['conn']->query($sql_login);
        $row = $res_login->fetch_assoc();
        $_SESSION["user"] = $row;

        if ($reg_val!="registreer") {
            header("location:/det/detail.php?id=".$reg_val);
        } else {
            //na registratie terugsturen naar de laatste opgeslagen url
            header("location:" .$_SESSION['url']);
        }
    } else {
        echo "Uw registratie is mislukt: " . $conn->error . "<br>";
    }

} else { print 'FOUT'; } //inschrijver registreren


foreach( $_POST as $key => $value )
{
    if ( $key == "usr_paswd" ) $value = hash("md5", $_POST["usr_paswd"]);
    $pairs[] = $key . "=" . "'" . $value . "'" ;
}


?>