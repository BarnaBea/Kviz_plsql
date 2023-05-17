<?php
session_start();
require("connection.php");

if (isset($_POST["jatek"])) {
    $jatekazonosito = $_POST["jatek"];
    $felhasznalo = $_SESSION["felhasznalonev"];
    $_SESSION["jatek_id"] = $jatekazonosito;

    $conn = new OracleConnection();
    $conn->jatekba_belepes($jatekazonosito, $felhasznalo);
    $kerdesek_es_valaszok = $conn->kerdesek_lekeres($jatekazonosito);
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
    <link rel="stylesheet" href="css/jatekletrehozas.css">
    <title>Játék!</title>

</head>

<body style="background-color: #eee;">
    <section class="vh-100">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5 ">
                            <div class="row justify-content-center ">
                                <form action="osszegzes.php" method="post">
                                    <?php
                                    $i = 0;
                                    foreach ($kerdesek_es_valaszok as $kerdes => $kerdes_adatok) {
                                        $valaszok = array($kerdes_adatok["VALASZ1"], $kerdes_adatok["VALASZ2"], $kerdes_adatok["VALASZ3"], $kerdes_adatok["HELYES_VALASZ"]);
                                        shuffle($valaszok);
                                        echo "<table class='table'><thead class='bg-warning'><th colspan = 2>" . $kerdes_adatok["SZOVEG"] . "</th></thead>";
                                        echo "<tr>
                                            <td class='w-50'>
                                                <input type='radio' class='btn-check' name='" . $kerdes_adatok["ID"] . "_valaszok' id='" . ($i + 1) . "' autocomplete='off' value='" . $valaszok[0] . "'>
                                                <label class='btn btn-outline-secondary w-100' for='" . ($i + 1) . "'>" . $valaszok[0] . "</label>
                                            </td>
                                            <td class='w-50'>
                                                <input type='radio' class='btn-check' name='" . $kerdes_adatok["ID"] . "_valaszok' id='" . ($i + 2) . "' autocomplete='off' value='" . $valaszok[1] . "'>
                                                <label class='btn btn-outline-secondary w-100' for='" . ($i + 2) . "'>" . $valaszok[1] . "</label>
                                            </td>
                                            </tr>";
                                        echo "<tr>
                                            <td class='w-50'>
                                                <input type='radio' class='btn-check' name='" . $kerdes_adatok["ID"] . "_valaszok' id='" . ($i + 3) . "' autocomplete='off' value='" . $valaszok[2] . "'>
                                                <label class='btn btn-outline-secondary w-100' for='" . ($i + 3) . "'>" . $valaszok[2] . "</label>
                                            </td>
                                            <td class='w-50'>
                                                <input type='radio' class='btn-check' name='" . $kerdes_adatok["ID"] . "_valaszok' id='" . ($i + 4) . "' autocomplete='off' value='" . $valaszok[3] . "'>
                                                <label class='btn btn-outline-secondary w-100' for='" . ($i + 4) . "'>" . $valaszok[3] . "</label>
                                            </td>
                                            </tr></table>";
                                        $i += 5;
                                    }
                                    ?>
                                    <div class="d-grid gap-3 col-2 mx-auto">
                                        <button type="submit" class="btn btn-success" value="done" name="kesz">játék befejezése</button>
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