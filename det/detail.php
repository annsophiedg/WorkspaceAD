<!DOCTYPE html>
<html lang="nl">

<?php
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/lib/html_functions.php");
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/lib/user_functions.php");
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/lib/connection.php");

PrintHead();

session_start();
$_SESSION['url']=$_SERVER["REQUEST_URI"];

?>

<body>
<header>
    <?php PrintUpper() ?>
    <?php PrintHeader(); ?>

    <main class="container flex">
    <section class="small flex">
        <?php
        $sql = "select * from vo_workshop w
          inner join vo_detail_workshop dw on w.wor_id = dw.det_wor_id
          inner  join vo_locatie l on dw.det_loc_id = l.loc_id
          inner join vo_postcode p on l.loc_pos_id = p.pos_id
          where wor_id= ". $_GET['id'];
          
        $result = $_SERVER['conn']->query($sql);
        $row = $result->fetch_assoc();

        //Databank-gegevens opslaan als variabelen
        $id = $row['wor_id'];
        $det_id = $row['det_id'];
        $wor = $row['wor_naam'];
        $wor_src = $row['wor_foto'];
        $wor_omschr = $row['wor_omschrijving'];
        $prijs= $row['det_prijs'];
        $startuur= date("H:i", strtotime($row['det_startuur']));
        $einduur= date("H:i", strtotime($row['det_einduur']));
        $straat= $row['loc_straat'];
        $huisnr= $row['loc_huisnr'];
        $gemeente = $row['pos_gemeente'];
        $postcode = $row['pos_postcode'];
        $datum= date("d/m/Y", strtotime($row['det_datum']));
        print '<h2 class="align-center">'.$wor.'</h2>
               <div id="detail" class="flex">
                    <img src="../images/'.$wor_src.'" alt="">
                    <div class="detailinfo">
                        <p><span class="fa fa-calendar-alt icoon"></span>'.$datum.'</p>
                        <p><span class="fa fa-clock icoon"></span>'.$startuur.' - '.$einduur.' </p>
                        <p><span class="fa fa-euro-sign icoon"></span>'.$prijs.' Euro</p>
                        <p><span class="fa fa-map-marker-alt icoon"></span>'.$straat.' '.$huisnr.', '.$postcode.' '.$gemeente.'</p>
                    </div>
               </div>
               <div id="omschrijving">
                    <p>'.$wor_omschr.'</p>';

        if ( isset($_SESSION["user"]))
        {   //als op de schrijfin-knop geklikt wordt:
            if(isset($_POST["signUp"])){
            // if($_POST["signUp"] !== ""){
                $sql = "INSERT INTO vo_KT_det_reg SET ".
                    "fk_det_id='". $det_id ."', ".
                    "fk_reg_id='". $_SESSION["user"]["reg_id"]."'";
                $result = $conn->query($sql);
                unset($_POST["signUp"]);

                $sql = "select * from vo_KT_det_reg where fk_det_id= '". $det_id."'and fk_reg_id='". $_SESSION["user"]["reg_id"]."'";
                $result=$conn->query($sql);
                $row=$result->fetch_assoc();
                print'<p class="signed">U bent ingeschreven voor deze workshop!</p>
                <p> Ga naar jouw <a class="signed" href="../geg/profiel.php">profiel</a> voor een overzicht van jouw inschrijving en gegevens </p>';
            } //als niet op schrijfin geklikt werd, toon schrijf in-knop
            else{
                print '<form action="'.$_SESSION['url'].'" method="post">
                        <button id="h4" type="submit" name="signUp" value="schrijfIn">Schrijf je in voor deze workshop!</button>
                       </form>';
            }
        } //als niet ingelogd is, geef keuze om in te loggen of registreren
        else {
            print '<div class="flex"><h4 class="align-center">Schrijf je in voor deze workshop!</h4>';
            ToonLoginForm("detlog","schrijfin flexC", "");
            print '<div id="schrijfinreg" class="schrijfin flex flexC">
                                <p class="nieuw align-center">Nieuw lid?</p>
                                <form action="/reg/registreer.php" method="post">
                                    <button type="submit" name="reg_sign_up" value="'.$_GET["id"].'">Registreer</button>
                                </form>
                            </div></div>';
        };

        print '</div>';
        ?>

    </section>
</main>
<footer class="container flex">
    &copy; Workshops, januari 2019
</footer>

<?php PrintScript(); ?>

</body>

</html>