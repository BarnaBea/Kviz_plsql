<?php
session_start();
require("connection.php");
$msg = "";

$kerdes = "";
$valaszok = [
    "valasz1" => "",
    "valasz2" => "",
    "valasz3" => "",
    "helyes_valasz" => "",
];
$temakorok = array();
$nehezseg = 0;
$conn = new OracleConnection();

if (isset($_POST["modositas"])) {
    $_SESSION["kerdes_id"] = $_POST["kerdes_id"];
    $result = $conn->get_question( $_SESSION["kerdes_id"]);
}

if (isset($_POST["torles"])) {
    $conn->delete_question($_POST["kerdes_id"]);
    header('Location: bekuldottkerdeseim.php');
}

if (isset($_POST["mentes"])) {
    $kerdes = $_POST["kerdes"];
    $valaszok["valasz1"] = $_POST["valasz1"];
    $valaszok["valasz2"] = $_POST["valasz2"];
    $valaszok["valasz3"] = $_POST["valasz3"];
    $valaszok["helyes_valasz"] = $_POST["helyes_valasz"];
    $nehezseg = $_POST["nehezsegiszint"];
    $pont_id = $_POST["nehezsegiszint"];
    $conn->update_question( $_SESSION["kerdes_id"], $kerdes, $valaszok, $nehezseg);
   
    header('Location: bekuldottkerdeseim.php');
      
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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Kérdés beküldés</title>

</head>

<body style="background-color: #f0ffab;">
    <section class="vh-600">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black shadow mt-5" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <div class="ms-4 px-3 pb-5">
                                        <a href="mainpage.php" class="btn btn-dark btn-sm">Vissza</a>
                                    </div>
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Kérdés beküldés</p>
                                    <form action="" class="mx-1 mx-md-4" method="post">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example1c">Kérdés szövege</label>
                                                
                                                <input type="text" name="kerdes" class="form-control" value="<?=$result[0]["SZOVEG"]?>"required />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example3c">Első helytelen válasz</label>
                                                <input type="text" name="valasz1" class="form-control border border-danger" value="<?=$result[0]["VALASZ1"]?>" required />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4c">Második helytelen válasz</label>
                                                <input type="text" name="valasz2" class="form-control border border-danger" value="<?=$result[0]["VALASZ2"]?>" required />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4cd">Harmadik helytelen válasz</label>
                                                <input type="text" name="valasz3" class="form-control border border-danger" value="<?=$result[0]["VALASZ3"]?>" required />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4cd">Helyes válasz</label>
                                                <input type="text" name="helyes_valasz" class="form-control border border-success" value="<?=$result[0]["HELYES_VALASZ"]?>" required />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                
                                                
                                                <div class="col control-group form-check form-check-inline mt-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" id="alap" name="nehezsegiszint" value="1" <?php if($result[0]["NEHEZSEG"] == 1) : ?>checked<?php endif ?>/>
                                                        <label class="form-check-label" for="alap">Alap</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" id="kozep" name="nehezsegiszint" value="2" <?php if($result[0]["NEHEZSEG"] == 2) : ?>checked<?php endif ?>/>
                                                        <label class="form-check-label" for="kozep">Közép</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" id="halado" name="nehezsegiszint" value="3" <?php if($result[0]["NEHEZSEG"] == 3) : ?>checked<?php endif ?>/>
                                                        <label class="form-check-label" for="halado">Haladó</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" name="mentes" class="btn btn-dark btn-lg w-100" onclick="alert('Sikeres módosítás!');">Módosítás</button>
                                        </div>
                                    </form>
                                    <?= $msg ?>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="img/kerdojel.jpg" class="img-fluid" alt="Sample image">
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