<!DOCTYPE html>
<html lang="nl">

<?php
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/lib/html_functions.php");
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/lib/user_functions.php");
require_once ( $_SERVER["DOCUMENT_ROOT"] . "/lib/connection.php");

PrintHead();

$reg_val = "registreer";
if ($_POST['reg_sign_up']) { $reg_val=$_POST['reg_sign_up']; }

?>

<body>
<?php PrintUpper() ?>
<?php PrintHeader(); ?>

<main class="container flex register">

    <div id="reglayer" class="flex">

        <form id="regform" class="flex flexC" method=POST action="/reg/reg_save.php">

            <fieldset class="flex flexC">

                <legend class="align-center">Registreer</legend>

                <ul class="flex flexC">

                    <?php

                    //inputs voor alle velden
                    $arr_form = array(
                        "Voornaam" => "reg_voornaam",
                        "Naam" => "reg_naam",
                        "E-mail" => "reg_email",
                        "Telefoon" => "reg_telefoon",
                        "Kies wachtwoord" => "reg_wachtwoord",
                        "Controle wachtwoord" => "reg_checkww",
                    );

                    foreach( $arr_form as $label => $name )
                    {
                        print '<li>';
                        $type = "text";
                        if ( $name == "reg_email" ) { $type = "email";
                        } elseif ( $name == "reg_telefoon" ) { $type = "tel";
                        } elseif ( $name == "reg_wachtwoord" or $name == "reg_checkww" ) $type = "password";
                        print '<input type="' . $type . '" id="' . $name . '" name="' . $name . '" value="" placeholder="'.$label.'" required></li>';
                    }

                    ?>
                </ul>
            </fieldset>

            <?php
            print '<button id="registreer" type="submit" name="reg_save" value="'.$reg_val.'">Registreer</button>'
            ?>

        </form>

    </div>

</main>

<footer class="container flex">
    &copy; Workshops, januari 2019
</footer>

<?php PrintScript(); ?>

</body>

</html>
