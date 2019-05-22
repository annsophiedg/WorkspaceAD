<?php

require_once ( $_SERVER["DOCUMENT_ROOT"] . "/lib/connection.php");

session_start();
session_destroy();

header("location:" .$_SESSION['url']);

?>