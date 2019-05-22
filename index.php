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

<?php PrintUpper() ?>
<?php PrintHeader(); ?>

<main class="container flex">
    <section class="flex flexC">
        <h2 class="align-center">Workshops</h2>
        <p class="align-center">Tempor fore eiusmod nescius hic ne velit probant ut qui ubi quorum excepteur, lorem consectetur ingeniis fore mandaremus. Quo ut cillum mentitum, eu quae quorum an expetendis si offendit e minim ubi quem arbitror instituendarum. </p>
    </section>

    <section class="flex articles">
        <?php PrintCategoriën() ?>
    </section>

</main>

<footer class="container flex">
    &copy; Workshops, januari 2019
</footer>

<?php PrintScript(); ?>

</body>

</html>
