<?php
require("connection.php");
$conn = new OracleConnection();

$utolso_azonosito = $conn->utolso_jatek_id() + 1;
$nev = "";
$letszam = "";
$kerdesekszama = "";
$nehezseg = "";

if (isset($_POST["letrehoz"])) {
    $nev = $_POST["nev"];
    $letszam = $_POST["letszam"];
    $kerdesekszama = $_POST["kerdesszam"];
    $nehezseg = $_POST["nehezseg"];
    if ($letszam >= 1 && $letszam <= 10) {
        $utolso_azonosito = $conn->utolso_jatek_id() + 1;
        $conn->jatek_letrehozas($utolso_azonosito, $nev, $letszam, $kerdesekszama, $nehezseg);
        header('Location:jatek_letrehozas.php');
    }
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
    <title>Létrehozás</title>

</head>

<body>
    <section class="vh-200" style="background-color: #cfa9ad;">
        <div class="container h-100 pt-5">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <form class="contact-form row" method="POST">
                                        <div class="w-100 form-field col-lg-12">
                                            <a href="mainpage.php" class="btn submit-btn rounded d-inline" name="vissza">Vissza a főoldalra</a>
                                        </div>
                                        
                                            <img src="img/jatekletrehozas2.jpg" alt="">
                                        
                                        <h1 class="title pt-5">Játék létrehozása</h1>

                                        <div class="form-field col-lg-6">
                                            <input id="name" name="azonosito" class="input-text js-input" type="number" value="<?php echo $utolso_azonosito; ?>" readonly>
                                            <label class="label" for="name">Játék azonosító</label>
                                        </div>
                                        <div class="form-field col-lg-6 ">
                                            <input id="email" name="nev" class="input-text js-input" type="text" required>
                                            <label class="label" for="email">Játékszoba neve</label>
                                        </div>
                                        <div class="form-field col-lg-12">
                                            <input id="kerdesszam" name="kerdesszam" class="input-text js-input" type="number" min="5" value="5" max="30" required>
                                            <label class="label" for="kerdesszam">Kérdések száma</label>
                                        </div>
                                        <p style="font-size: 13px;">A kérdések száma minimum 5 és maximum 30 lehet!</p>
                                        <div class="form-field col-lg-12">
                                            <input id="message" name="letszam" class="input-text js-input" type="number" required>
                                            <label class="label" for="message">Maximum létszám</label>
                                        </div>
                                        <p style="font-size: 13px;">Játékot létrehozni 1-10 fővel lehetséges!</p>
                                        <div class="form-field col-lg-12">
                                            <label class="label" for="message" style="bottom:50px;">Nehézség kiválasztása</label>
                                            <select class="form-select mt-3" name="nehezseg" aria-label="Default select example">
                                                <option selected>Kérem válasszon!</option>
                                                <option value="1">Alap</option>
                                                <option value="2">Normál</option>
                                                <option value="3">Nehéz</option>
                                            </select>

                                        </div>
                                        <div class="w-100 form-field col-lg-12 ">
                                            <input class="submit-btn rounded d-inline" name="letrehoz" type="submit" value="Létrehoz">
                                        </div>
                                    </form>
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