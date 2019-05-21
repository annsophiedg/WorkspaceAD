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
<?php PrintUpper();
PrintHeader(); ?>

<main class="container flex">
    <?php PrintWorkshopsVanCategorie() ?>
</main>
<footer class="container flex">
    &copy; Workshops, januari 2019
</footer>

<?php PrintScript(); ?>

</body>

</html>
