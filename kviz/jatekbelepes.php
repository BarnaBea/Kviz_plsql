<?php
session_start();
require("connection.php");
$conn = new OracleConnection();

$ertekek = $conn->jatekok_kiiratasa();

$jatek_azon = "";
$felhasznalonev = "";
if (isset($_POST["jatekbabelep"])) {
   $jatek_azon = $_POST["jatek"];
    $felhasznalonev = $_SESSION["felhasznalonev"];
    $conn->jatekba_belepes($jatek_azon, $felhasznalonev); 
}


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
    <link rel="stylesheet" href="css/jatekletrehozas.css">
    <title>Belépés</title>

</head>

<body>
    <section class="vh-100" style="background-color: #dbf5da;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black shadow" style="border-radius: 25px;">
                        <div class="card-body p-md-5 ">
                        <div class="ms-4 px-3 pb-5">
                                        <a href="mainpage.php" class="btn btn-success btn-sm">Vissza</a>
                                    </div>
                            <img src="img/jatekkivalaszt.jpg" class="img-fluid mx-auto d-block" alt="">
                            <div class="row justify-content-center ">
                                <form action="jatek.php" method="post">
                                    <div>
                                        <?php
                                        echo '<table class="table table-success table-striped table-hover text-center">';
                                        echo "<thead>
                                            
                                            <th>Játék neve</th>
                                            <th>Létszám</th>
                                            <th>Kérdések száma</th>
                                            <th>Szint</th>
                                            <th></th>
                                        </thead>";
                                        foreach ($ertekek as $ertek => $data) {
                                            echo '<tr>
                                            
                                            <td>' . $data["nev"] . '</td>
                                            <td>' . $data["letszam"] . '/' . $data["belepett_jatekosok"] . '</td>
                                            <td>' . $data["kerdesek_szama"] . '</td>
                                            <td>' . $data["nehezseg"] . '</td>
                                            <td><input type="radio" name="jatek" value="' . $ertek . '"></td>
                                        </tr>';
                                        }
                                        echo "</table>";
                                        ?>
                                    </div>
                                    <div class="d-grid gap-3 col-2 mx-auto d-md-block">

                                        <button type="submit" name="jatekbabelep" class="btn btn-success">belépés</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>