<?php
session_start();
require("connection.php");
$conn = new OracleConnection();
$osszpontok = 0;
$osszpontok = $conn->osszpont($_SESSION["felhasznalonev"]);
$helyes_valaszok_temakorokszerinti_rangsora = $conn->helyes_valaszok_temakorokszerinti_rangsora();
$osszesitettpontok_eletkor_szerint = $conn->helyes_valaszok_eletkor_szerint();
$kerdesekszama_temakorszerint = $conn->kerdesekszama_temakorszerint();
$legnehezebb_kerdes = $conn->legnehezebb_kerdesek();
$legnepszerubb_jatekok = $conn->legnepszerubb_jatekok();

if (isset($_POST["lekerdezes"])) {
    $eletkor_szerinti_helyes_valaszok = $conn->eletkor_ranglista($_POST["tol"], $_POST["ig"]);
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
    <title>Profil és statisztika</title>

</head>

<body style="background-color: #f7edd0;">
    <section class="vh-100">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-3 ">
                            <a class="btn btn-warning" href="mainpage.php">Vissza</a>   
                            <img src="img/statisztika2.jpg" class="img-fluid mx-auto d-block" alt="">
                        </div>
                        <div class="card-body p-md-3 ">
                            <div class="row justify-content-center ">
                                <form action="" method="post">
                                    <div class="input-group mb-5">
                                        <input type="text" name="tol" class="form-control">
                                        <span class="input-group-text">-tól</span>
                                        <input type="text" name="ig" class="form-control">
                                        <span class="input-group-text">-ig</span>
                                        <button type="submit" class="btn btn-outline-dark" name="lekerdezes">lekérdezés</button>
                                        <table class="table">
                                            <thead>
                                                <th>Felhasználónév</th>
                                                <th>Életkor</th>
                                                <th>összpontszám</th>
                                            </thead>

                                            <?php
                                            if (isset($eletkor_szerinti_helyes_valaszok)) {
                                                foreach ($eletkor_szerinti_helyes_valaszok as $key => $value) {
                                                    echo "<tr><td>" . $value["FELHASZNALONEV"] . "</td><td>" . $value["ELETKOR"] . "</td><td class='text-center'>" . $value["PONTSZAM"] . "</td></tr>";
                                                }
                                            }

                                            ?>

                                        </table>
                                    </div>
                                </form>
                                <div>
                                    <div class="accordion" id="accordionExample">
                                        
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed btn-ligt" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Ranglista felhasználónként - Témakörök szerinti megszerzett pontok
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse " aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table">
                                                        <thead>
                                                            <th>Első helyezett</th>
                                                            <th>témakör megnevezése</th>
                                                            <th class='text-center'>megszerzett pontok</th>
                                                        </thead>

                                                        <?php
                                                        foreach ($helyes_valaszok_temakorokszerinti_rangsora as $key => $value) {
                                                            echo "<tr><td>" . $value["FELHASZNALO"] . "</td><td>" . $value["TEMAKOR"] . "</td><td class='text-center'>" . $value["HELYES_VALASZOK"] . "</td></tr>";
                                                        }
                                                        ?>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed btn-ligt" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    Ranglista - Életkor szerint
                                                </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table">
                                                        <thead>
                                                            <th>Életkor</th>
                                                            <th class='text-center'>összpontszám</th>

                                                        </thead>

                                                        <?php
                                                        foreach ($osszesitettpontok_eletkor_szerint as $key => $value) {
                                                            echo "<tr><td>" . $value["ELETKOR"] . "</td><td class='text-center'>" . $value["PONTSZAM_ELETKOR_SZERINT"] . "</td></tr>";
                                                        }
                                                        ?>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingFour">
                                                <button class="accordion-button collapsed btn-ligt" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                    Kérdések száma témakörök szerint
                                                </button>
                                            </h2>
                                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table">
                                                        <thead>
                                                            <th>Témakör megnevezése</th>
                                                            <th class='text-center'>Kérdések száma</th>

                                                        </thead>

                                                        <?php
                                                        foreach ($kerdesekszama_temakorszerint as $key => $value) {
                                                            echo "<tr><td>" . $value["TEMAKOR_MEGNEVEZESE"] . "</td><td class='text-center'>" . $value["KERDESEK_SZAMA"] . "</td></tr>";
                                                        }
                                                        ?>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingFive">
                                                <button class="accordion-button collapsed btn-ligt" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                    Legnehezebb kérdés(ek)
                                                </button>
                                            </h2>
                                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table">
                                                        <thead>
                                                            <th>A kérdés szövege</th>
                                                            <th class='text-center'>Kérdésre összesen hány válasz érkezett</th>
                                                            <th class='text-center'>Ebből a rossz válaszok száma</th>
                                                        </thead>
                                                        <?php
                                                        foreach ($legnehezebb_kerdes as $key => $value) {
                                                            echo "<tr><td>" . $value["SZOVEG"] . "</td><td class='text-center'>" . $value["VALASZOK_SZAMA"] . "</td><td class='text-center'>" . $value["HELYTELEN_VALASZOK_SZAMA"] . "</td></tr>";
                                                        }
                                                        ?>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading6">
                                                <button class="accordion-button collapsed btn-ligt" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                                    Játékszobák népszerűség szerint
                                                </button>
                                            </h2>
                                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table">
                                                        <thead>
                                                            <th>Szoba neve</th>
                                                            <th class='text-center'>Népszerűség</th>
                                                        </thead>
                                                        <?php
                                                        foreach ($legnepszerubb_jatekok as $key => $value) {
                                                            echo "<tr><td>" . $value["NEV"] . "</td><td class='text-center'>" . $value["DARABSZAM"] . "</td></tr>";
                                                        }
                                                        ?>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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