<?php
ini_set("default_charset", "ISO-8859-1");

$servername = "ID81394_annsophie.db.webhosting.be";
$username = "ID81394_annsophie";
$password = "anns19581600?";

// Create connection
$conn = new mysqli($servername, $username, $password);
$_SERVER['conn']= $conn;

// Check connection
if ($_SERVER['conn']->connect_error) die("Connection to $database failed: " . $_SERVER['conn']->connect_error);

$_SERVER['conn']->select_db ("ID81394_annsophie");

?>