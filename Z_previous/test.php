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
        $sql = "select * from workshop
          inner join detail_workshop on workshop.wor_id = detail_workshop.det_wor_id
          inner  join locatie l on detail_workshop.det_loc_id = l.loc_id
          inner join postcode p on l.loc_pos_id = p.pos_id
          where wor_id= " .$_GET["id"];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        //Databank-gegevens opslaan als variabelen
        $id = $row[wor_id];
        $det_id = $row[det_id];
        $wor = $row[wor_naam];
        $wor_src = $row[wor_foto];
        $wor_omschr = $row[wor_omschrijving];
        $prijs= $row[det_prijs];
        $starttijd= $row[det_startuur];
        $einduur= $row[det_einduur];
        $straat= $row[loc_straat];
        $huisnr= $row[loc_huisnr];
        $gemeente = $row[pos_gemeente];
        $postcode = $row[pos_postcode];
        $datum= $row[det_datum];
        print '<h2 class="align-center">'.$wor.'</h2>
               <div id="detail" class="flex">
                    <img src="../images/'.$wor_src.'" alt="">
                    <div class="detailinfo">
                        <p>Datum: '.$datum.'</p>
                        <p>Uur: Van '.$starttijd.' tot '.$einduur.' </p>
                        <p>Prijs: '.$prijs.' Euro</p>
                        <p>Adres: '.$straat.' '.$huisnr.', '.$postcode.' '.$gemeente.'</p>
                    </div>
               </div>
               <div id="omschrijving">
                    <p>'.$wor_omschr.'</p>
                    <div class="flex">';
        if($_GET["signUp"] == "Save"){
            $sql = "INSERT INTO KT_det_reg SET ".
                "fk_det_id='". $det_id ."', ".
                "fk_reg_id='". $_SESSION["user"]["reg_id"]."'";
            $result = $conn->query($sql);}

        if ( isset($_SESSION["user"]))
        {   $sql = "select * from KT_det_reg where fk_det_id= '". $det_id."'and fk_reg_id='". $_SESSION["user"]["reg_id"]."'";
            $result=$conn->query($sql);
            $row=$result->fetch_assoc();
            if($row >= 1 ){
                print'<p class="signed">U bent ingeschreven voor deze workshop!<br> Ga naar <a href="../profile/profiel.php">Mijn profiel</a> voor een overzicht van je inschrijving en persoonsgegevens </p>';
            }else{
                print '<form action="detail.php" method="get">
                           <input type="text" name="id" style="visibility: hidden" value="'.$_GET["id"].'">
                        <button id="h4" type="submit" name="signUp" value="Save">Schrijf je in voor deze workshop!</button>
                        </form>';
            }
        }
        else {
            print '<h4 class="align-center">Schrijf je in voor deze workshop!</h4>
                            <form id="schrijfinlog" class="schrijfin flex flexC" method=POST action="http://localhost/dag1/vrije_opdracht_huidig/det/detail.php>"
                                <ul>
                                    <li>
                                        <input id="logemail" name="logemail" type="email" placeholder="E-mail">
                                    </li>
                                    <li>
                                        <input id="logwachtwoord" name="logwachtwoord" type="password" placeholder="Wachtwoord">
                                    </li>
                                </ul>
                                <input type="submit" name="login" value="Log in">
                            </form>
                            <div id="schrijfinreg" class="schrijfin flex flexC">
                                <p class="nieuw align-center">Nieuw lid?</p>
                                <button type="button" onclick="location.href=\'http://localhost/dag1/vrije_opdracht_huidig/reg/registreer.php?det_id="'.$det_id.'\';">Registreer</button>
                            </div>';
        };
        print '</div>
               </div>';
        ?>
    </section>
</main>
<footer class="container flex">
    &copy; Workshops, januari 2019
</footer>
</body>

</html>