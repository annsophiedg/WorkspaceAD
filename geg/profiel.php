<!DOCTYPE html>
<html lang="nl">

<?php
session_start();
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/18.12/vrije_opdracht/lib/connection.php");
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/18.12/vrije_opdracht/lib/html_functions.php");
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/18.12/vrije_opdracht/lib/user_functions.php");

PrintHead();

$_SESSION['url']=$_SERVER["REQUEST_URI"];

if(isset($_SESSION["user"])) {
    if ($_POST["save-change"] == "Opslaan") { //Wanneer persoonsgegevens worden gewijzigd

        unset($_POST["save-change"]);

        foreach ($_POST as $name => $value) {
            $sql = "update registratie set $name= '".$value."'"." where reg_id= " . $_SESSION['user']['reg_id'];
            $result = $conn->query($sql);
        }
    }
    if ($_POST["save-psw"] == "Save") { //Wanneer wachtwoord wordt gewijzigd
        unset($_POST["save-psw"]);
        unset($_POST["check-password"]);
        $curPsw = hash("md5", $_POST["cur-password"]);
        $newPsw = hash("md5", $_POST["new-password"]);
        $sql = "select reg_wachtwoord from registratie where reg_id= " . $_SESSION["user"]["reg_id"];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if ($curPsw == $row['reg_wachtwoord']) {
            $sql = "update registratie set reg_wachtwoord = '" . $newPsw . "' where reg_id=" . $_SESSION["user"]["reg_id"];
            $result2 = $conn->query($sql);
            $changepsw = "<p>Uw wachtwoord werd gewijzigd</p>";
        }else{
            $changepsw = "<p>Uw huidig wachtwoord is niet correct<abbr>*</abbr></p>";
        }
    }
    if(isset($_POST["delete-wor"])){
        $sql = "delete from KT_det_reg where fk_det_id= ".$_POST["delete-wor"]." and fk_reg_id=" .$_SESSION["user"]["reg_id"];
        $result3 = $conn->query($sql);}
}
?>

<body>

<?php PrintUpper();
PrintHeader(); ?>

<main class="container flex">

    <section class="my-page-sec">

        <h2>Mijn workshops</h2>

        <?php

        $sql= "select wor_naam, wor_foto, det_datum, det_startuur, det_einduur, loc_straat, loc_huisnr, pos_postcode, pos_gemeente, det_id from KT_det_reg
            inner join detail_workshop dw on KT_det_reg.fk_det_id = dw.det_id
            inner join locatie l on dw.det_loc_id = l.loc_id
            inner join postcode p on l.loc_pos_id = p.pos_id
            inner join workshop w on dw.det_wor_id = w.wor_id
            where fk_reg_id = " .$_SESSION["user"]["reg_id"]."
            ORDER BY det_datum";
        $result=$conn->query($sql);

        while ($row=$result->fetch_assoc()){
            $wor_src = $row["wor_foto"];
            $wor = $row["wor_naam"];
            $startuur = date("H:i", strtotime($row[det_startuur]));
            $einduur = date("H:i", strtotime($row[det_einduur]));
            $straat = $row["loc_straat"];
            $huisnr = $row["loc_huisnr"];
            $postcode = $row["pos_postcode"];
            $gemeente = $row["pos_gemeente"];
            $datum = date("d/m/Y", strtotime($row[det_datum]));
            $detId = $row["det_id"];
            print'<article class="sign-up-work flex">
                <div class="flex">
                    <img src="../images/'.$wor_src.'" class="sign-up-img">
                    <div class="overview-info flex flexC">
                    <p class="work-title" style="font-weight: 500;">'.$wor.'</p>
                    <p><span class="fa fa-calendar-alt icoon"></span>'.$datum.'</p>
                    <p><span class="fa fa-clock icoon"></span>'.$startuur.' - '.$einduur.' </p>
                    <p><span class="fa fa-map-marker-alt icoon"></span>'.$straat.' '.$huisnr.', '.$postcode.' '.$gemeente.'</p>
                    </div>
                </div>
                <form action="profiel.php" method="post">
                <button class="schrijfuit" type="submit" name="delete-wor" value="'.$detId.'">Schrijf uit</button>
                </form>
              </article>';
        }

        ?>
    </section>

    <section class="my-page-sec">
        <h2>Mijn gegevens</h2>

        <form id="adjust-form" method="post" action="profiel.php">
            <fieldset>
                <ul class="reg-list unlist">

                    <?php

                    $sql= "select * from registratie 
                    where reg_id='".$_SESSION["user"]["reg_id"]."'";
                    $result = $conn->query($sql);
                    $row=$result->fetch_assoc();

                    $arr_form = array(
                        "Voornaam" => "reg_voornaam",
                        "Naam" => "reg_naam",
                        "E-mailadres" => "reg_email",
                        "Telefoonnummer" => "reg_telefoon"
                    );

                    foreach( $arr_form as $label => $name )
                    {
                        print'<li><label for="'.$name.'">'.$label.'</label>';
                        $type = "text";
                        if ( $name == "reg_email" ) { $type = "email";
                        } elseif ( $name == "reg_telefoon" ) { $type = "tel";}
                        print '<input type="' . $type . '" id="' . $name . '" name="' . $name . '" value="'. $row[$name] .'" required></li>';
                    };
                    ?>
                </ul>
            </fieldset>

            <button type="submit" name="save-change" value="Opslaan">Bewerk mijn gegevens</button>
        </form>

        <form id="adjust-psw" method="post" action="profiel.php">
            <fieldset>
                <legend>Wijzig wachtwoord</legend>
                <?php print $changepsw ?>
                <ul class="reg-list unlist">

                    <li><input type="password" id="cur-password" name="cur-password" placeholder="Huidig wachtwoord" required</li>
                    <li><input type="password" id="new-password" class="check-one" name="new-password" placeholder="Nieuw wachtwoord" required</li>
                    <li><input type="password" id="check-password" class="check-two" name="check-password" placeholder="Controleer wachtwoord" required</li>

                </ul>

            </fieldset>
            <button type="submit" name="save-psw" value="Save">Bewerk wachtwoord</button>

        </form>
    </section>
</main>
<footer class="container flex">
    &copy; Workshops, januari 2019
</footer>

<?php PrintScript(); ?>

</body>
</html>