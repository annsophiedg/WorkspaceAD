<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Vrije opdracht PHP</title>
    <link rel="stylesheet" href="../../css/style.css">

    <link rel="stylesheet" href="javascript/script.js">
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
</head>

<body>
<header>
    <div class="container">
        <h1>Workshops</h1>
        <p>Create something new</p>
    </div>
</header>
<nav class="container cont-nav">
    <ul class="unlist">
        <li><a href="../../index.php">Home</a></li>

        <?php
        require_once("../connection.php");

        //opvragen categorieën
        $sql = "SELECT * FROM categorie";
        $res_cat = $conn->query($sql);

        //<!--        for looping categorieën + link    -->
        while($row = $res_cat->fetch_assoc())
        {
            $cat = $row[cat_naam];
            $id = $row[cat_id];
            print'<li><a href="categorie.php?id='.$id.'">' .$cat.'</a></li>';
        }
        ?>
    </ul>
</nav>
<main class="container flex">
    <section class="small flex">
        <h2 class="align-center">Schrijf je in!</h2>

        <img src="../../images/boeket.jpeg" alt="">
        <div class="detail">
            <p>Titel</p>
            <p>Locatie</p>
            <p>Uur</p>
        </div>

        <form id="form" method=POST action="form_save.php">

            <fieldset>
                <ul class="flex flexC">

                    <?php

                    //inputs voor alle velden
                    $arr_form = array(
                        "Voornaam" => "ins_voornaam",
                        "Naam" => "ins_naam",
                        "E-mail" => "ins_email",
                        "Telefoon" => "ins_telefoon",
                        "Wachtwoord" => "ins_wachtwoord"
                    );

                    foreach( $arr_form as $label => $name )
                    {
                        print '<li><label for="' . $name . '">'.$label.'</label>';
                        $type = "text";
                        if ( $name == "ins_email" ) { $type = "email";
                        } elseif ( $name == "ins_telefoon" ) { $type = "tel";
                        } elseif ( $name == "ins_wachtwoord" ) $type = "password";
                        print '<input type="' . $type . '" id="' . $name . '" name="' . $name . '" value="" required></li>';
                    }

                    ?>

                </ul>
            </fieldset>

            <button type="submit" name="save" value="Opslaan">Schrijf in</button>

        </form>
    </section>

</main>
<footer class="container flex">
    &copy; Workshops, januari 2019
</footer>
</body>

</html>
