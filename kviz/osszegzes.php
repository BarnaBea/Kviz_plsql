<?php
session_start();
require("connection.php");


$felhasznalonev = $_SESSION["felhasznalonev"];
$jatek_id = "";

if (isset($_POST["kesz"])) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, '_valasz') !== false) {
            $kerdes_id = str_replace('_valaszok', '', $key);
            $valaszok[$kerdes_id] = $value;
        }
    }
    $conn = new OracleConnection();
    $result = array();
    $conn->valaszok_feltoltese($felhasznalonev, $valaszok);
    $result = $conn->valaszok_visszakerese($felhasznalonev, $_SESSION["jatek_id"]);
    foreach ($valaszok as $id => $value) {
        $conn->hozzarendel_feltoltes($_SESSION["jatek_id"], $id);
    }
    $conn->jatekbol_kilepes($_SESSION["felhasznalonev"]);
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
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/ef4c73c0c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/jatekletrehozas.css">
    <title>Eredmények</title>

</head>

<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5 ">
                            <div class="row justify-content-center ">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <th>Kérdés</th>
                                        <th class="text-end">Helyes volt?</th>
                                    </thead>
                                    <tbody>    
                                <?php
                                foreach ($result as $key => $value) {
                                    echo "<tr><td class='p-2'>".$value["SZOVEG"]."</td><td>";
                                    if ($value["HELYESSEG"] == 1){
                                        echo "<td><i class='fa-solid fa-square-check text-success fs-4'></i></td></tr>";
                                    }else{
                                        echo "<td><i class='fa-sharp fa-solid fa-square-xmark text-danger fs-4'></i></td></tr>";
                                    }
                                }
                                ?>
                                </tbody>
                                </table>
                                <div class="d-grid gap-2">
                                <a href="jatekbelepes.php" class="btn btn-dark">Újra játszom</a>
                                <a href="mainpage.php" class="btn btn-dark">Vissza a főoldalra</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>