<?php
session_start();
require("connection.php");
$conn = new OracleConnection();
$conn->delete_felhasznalo($_SESSION["felhasznalonev"]);
$_SESSION['felhasznalonev'] = "";
$conn->__destruct();
header('Location: index.php');

?>