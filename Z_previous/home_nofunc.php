<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Vrije opdracht PHP</title>
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="javascript/general.js">
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
</head>

<body>
<header>
    <div id="translayer" class="container">
        <h1>WorkSpace</h1>
        <p id="quote">Improve your skills</p>

        <?php
        session_start();
        require_once("lib/connection.php");

        //wanneer ingelogd, zeg Welkom
        if ( isset($_SESSION["user"]))
        {
            $_SESSION['url'] = $_SERVER["REQUEST_URI"];
            print "<p id='login' class='welkom'>Welkom, " . $_SESSION["user"]["reg_voornaam"] . "!<br><a href='../log/loguit.php'>Log uit</a></p>" ;
        } //zoniet check $_POST
        elseif ( $_POST["login"] == "Login" )
        {
            unset($_POST['login']);      //Login knop uit $_POST verwijderen
            $hash = hash("md5", $_POST["reg_wachtwoord"]);

            //haal de gegevens uit de databank van de persoon die inlogt
            $sql = "SELECT * FROM registratie where reg_email=" . "'" . $_POST["reg_email"] . "'" . " and reg_wachtwoord=" . "'" . $hash . "'";
            $result = $conn->query($sql);

            //als er een rij voldoet aan de input-log, zeg Welkom
            if ( $result->num_rows == 1 )
            {
                $row = $result->fetch_assoc();
                $_SESSION["user"] = $row;
                print "<p id='login' class='welkom'>Welkom, " . $_SESSION["user"]["reg_voornaam"] . "!<br><a href='../log/loguit.php'>Log uit</a></p>" ;
                //header("location: view_immo.php");
            } // als de input niet klopt, geef het formulier + foutmelding
            else {
                $arr_login = array(
                    "E-mail" => "reg_email",
                    "Wachtwoord" => "reg_wachtwoord"
                );
                print '<form id="login" class="flex flexC" method=POST action="'.$_SERVER["REQUEST_URI"].'">
                               <ul>';
                foreach( $arr_login as $label => $name )
                {
                    print '<li class="flex flexC">';
                    print '<label for="' . $name . '" class="col-sm-4 col-form-label">' . $label . '</label>';
                    $type = "email";
                    if ( $name == "reg_wachtwoord" ) $type = "password";
                    print '<input type="' . $type . '" class="form-control" id="' . $name . '" name="' . $name . '" value="" required>';
                    print '</li>';
                }
                print '</ul>
                           <input type="submit" name="login" value="Login">
                           <a id="reg" href="../reg/registreer.php">Registreer</a>
                           <p id="fout">Onbekend e-mailadres en/of wachtwoord!</p>
                       </form>';
            }
        } //als geen $_POST, geef het inlogformulier
        else {
            $arr_login = array(
                "E-mail" => "reg_email",
                "Wachtwoord" => "reg_wachtwoord"
            );
            print '<form id="login" class="flex flexC" method=POST action="'.$_SERVER["REQUEST_URI"].'">
                               <ul>';
            foreach( $arr_login as $label => $name )
            {
                print '<li class="flex flexC">';
                print '<label for="' . $name . '" class="col-sm-4 col-form-label">' . $label . '</label>';
                $type = "email";
                if ( $name == "reg_wachtwoord" ) $type = "password";
                print '<input type="' . $type . '" class="form-control" id="' . $name . '" name="' . $name . '" value="" required>';
                print '</li>';
            }
            print '</ul>
                           <input type="submit" name="login" value="Login">
                           <a id="reg" href="../reg/registreer.php">Registreer</a>
                           <p id="fout"></p>
                       </form>';
        }
        ?>
    </div>
</header>

<nav class="container cont-nav">
    <ul class="unlist">
        <li><a href="#">Home</a></li>

        <?php
        //opvragen categorieën
        $sql = "SELECT * FROM categorie";
        $res_cat = $conn->query($sql);

        //<!--        for looping categorieën + link    -->
        while($row = $res_cat->fetch_assoc())
        {
            $cat = $row[cat_naam];
            $id = $row[cat_id];
            print'<li><a href="cat/categorie.php?id='.$id.'">' .$cat.'</a></li>';
        }
        ?>

    </ul>
</nav>

<main class="container flex">
    <section class="flex flexC">
        <h2 class="align-center">Workshops</h2>
        <p class="align-center">Tempor fore eiusmod nescius hic ne velit probant ut qui ubi quorum excepteur, lorem consectetur ingeniis fore mandaremus. Quo ut cillum mentitum, eu quae quorum an expetendis si offendit e minim ubi quem arbitror instituendarum. </p>
    </section>

    <!--    for looping in categorielijst   -->
    <section class="flex articles">
        <?php
        //opvragen categorieën
        $sql = "SELECT * FROM categorie";
        $res_cat = $conn->query($sql);

        //<!--    for looping in categorielijst   -->
        while($row = $res_cat->fetch_assoc())
        {
            $id = $row[cat_id];
            $cat = $row[cat_naam];
            $src = $row[cat_foto];
            $omschr = $row[cat_omschrijving];
            print '<figure class="categorie">
                <h3>'.$cat.'</h3>
                <img src="images/'.$src. '" alt="">
                <figcaption>
                    <p>Do fore illustriora, iis e voluptatibus ex commodo varias officia admodum, doctrina anim se deserunt instituendarum. Probant elit iis incurreret coniunctione, do culpa ea veniam. </p>
                    <a href="cat/categorie.php?id='.$id.'">lees meer...</a>
                </figcaption>
            </figure>';
        }

        ?>
    </section>

</main>

<footer class="container flex">
    &copy; Workshops, januari 2019
</footer>

</body>

</html>
