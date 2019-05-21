<?php

require_once ( $_SERVER["DOCUMENT_ROOT"] . "/18.12/vrije_opdracht/lib/connection.php");

session_start();
session_destroy();

header("location:" .$_SESSION['url']);

?>