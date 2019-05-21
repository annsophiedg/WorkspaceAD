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
        <p>Improve your skills</p>
        <form id="login" class="flex flexC" method=POST action='home_login.php'>
            <ul>

                <?php
                require_once("connection.php");    //require_once: vermijden dat het script meerdere keren wordt opgeroepen

                $arr_login = array(
                    "E-mail" => "reg_email",
                    "Wachtwoord" => "reg_wachtwoord"
                );

                foreach( $arr_login as $label => $name )
                {
                    print '<li class="flex flexC">';
                    print '<label for="' . $name . '" class="col-sm-4 col-form-label">' . $label . '</label>';
                    $type == "text";
                    if ( $name == "reg_wachtwoord" ) $type = "password";
                    print '<input type="' . $type . '" class="form-control" id="' . $name . '" name="' . $name . '" value="">';
                    print '</li>';
                }
                ?>

            </ul>
            <input type="submit" name="login" value="Login">
            <a id="reg" href="reg/registreer.php">Registreer</a>
        </form>

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
