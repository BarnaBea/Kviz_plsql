<?php
session_start();
require("connection.php");
$conn = new OracleConnection();
$osszpontok = 0;
$osszpontok = $conn->osszpont($_SESSION["felhasznalonev"]);
$feltoltott_kerdesekszama=array();
$feltoltott_kerdesekszama = $conn->feltoltott_kerdesekszama($_SESSION["felhasznalonev"]);
$helyes_valaszok_aranya=array();
$helyes_valaszok_aranya = $conn->helyes_valaszok_aranya($_SESSION["felhasznalonev"]);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="css/profil.css">
    <title>Profil és statisztika</title>

</head>

<body style="background-color: #8fdb97;">
    <section class="shadow " id="about" style="background-color: white;">
        <div class="container">
            <div class="row align-items-center justify-content-around flex-row-reverse">
                <div class="col-lg-4">
                    <div class="about-text">
                        <h3 class="dark-color">Profil</h3>
                        <h4 class="dark-color"><?=$_SESSION["felhasznalonev"]?></h4>
                        <p>Összpontjaid száma: <b><?=$osszpontok?></b></p>
                        <p>Feltöltött kérdéseid száma:  <b><?=$feltoltott_kerdesekszama[0]["BEKULDOTT_KERDESEK_SZAMA"]?> </b></p>
                        <p>Helyes válaszaid aránya:  <b><?=number_format($helyes_valaszok_aranya[0]["EREDMENY"]*100,2,",","")?> %</b></p>
                        <div class="btn-bar">
                            <a class="btn btn-dark" href="mainpage.php">Vissza a főoldalra</a>
                            <a class="btn btn-dark" href="profil_torles.php" onclick="confirm('Biztosan szeretné törölni?')">Profilom törlése</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="">
                        <img src="img/profil.jpg">
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>