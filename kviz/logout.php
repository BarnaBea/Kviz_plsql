<?php
session_start();
$_SESSION["felhasznalonev"]="";
header('Location:index.php');
session_destroy();

?>