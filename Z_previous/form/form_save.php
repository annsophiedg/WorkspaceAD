<?php
require_once("../connection.php");

if ( $_POST["save"] == "Opslaan" )
{
    unset($_POST['save']);      //Save element uit $_POST verwijderen

    //sleutel-waardenparen opslaan met = en '
    foreach( $_POST as $key => $value )
    {
        if ( $key == "wachtwoord" ) $value = hash("md5", $_POST["ins_wachtwoord"]);
        $pairs[] = $key . "=" . "'" . $value . "'" ;
    }

    //update statement maken; gebruik implode()
    $sql = "INSERT INTO inschrijver SET " . implode(", " , $pairs ) ;
    echo "SQL: " . $sql . "<br>";

    //SQL uitvoeren
    if ($conn->query($sql) === TRUE) {
        echo "Bedankt voor uw registratie!";
    } else {
        echo "Uw registratie is mislukt: " . $conn->error . "<br>";
    }

} //inschrijver toevoegen

//get ID inschrijver
$reg_id = $_GET["reg_id"];
//get ID workshop
$wor_id = $_GET["wor_id"];


?>