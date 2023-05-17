<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Főoldal</title>
</head>

<body>
    <section class="vh-100 pt-4 pb-4" style="background-color: #dde9eb;">
        <div class="container border rounded p-5 mt-5 shadow bg-light">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-dark m-2" href="logout.php">kijelentkezés</a>
            </div>
            <div class="row card-group gap-4">
                <div class="card card2 mb-3 border border-dark border-3 rounded shadow" style="background-image:url('img/jatekbelep.jpg')">
                    <div class="card-body">
                        <h5 class="card-title "><a href="jatekbelepes.php" class="btn btn-success w-100" style="margin-bottom: 300px;">Csatlakozás egy játékhoz</a></h5>
                    </div>
                </div>
                <div class="card card2 mb-3 border border-dark border-3 rounded shadow" style="background-image:url('img/jatekletrehozas.jpg')">
                    <div class="card-body">
                        <h5 class="card-title"><a href="jatek_letrehozas.php" class="btn btn-danger w-100" style="margin-bottom: 300px;">Játék létrehozása</a></h5>
                    </div>
                </div>
            </div>
            <div class="row card-group  gap-4">
                <div class="card card2 mb-3 border border-dark border-3 rounded shadow" style="background-image:url('img/kerdesbekuld.jpg')">
                    <div class="card-body">
                        <h5 class="card-title "><a href="kerdes_bekuldes.php" class="btn btn-warning w-100" >Kérdés beküldés</a></h5>
                        <h5 class="card-title "><a href="bekuldottkerdeseim.php" class="btn btn-warning w-100" style="margin-bottom: 320px;">Beküldött kérdéseim</a></h5>
                    </div>
                </div>
                <div class="card card2 mb-3 border border-dark border-3 rounded shadow" style="background-image:url('img/statisztika.jpg')">
                    <div class="card-body">
                        <h5 class="card-title"><a href="profil.php" class="btn btn-primary w-100">Profilom</a></h5>
                        <h5 class="card-title"><a href="statisztika.php" class="btn btn-primary w-100" style="margin-bottom: 320px;">Statisztika</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>