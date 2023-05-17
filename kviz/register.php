<?php
require("connection.php");

$regfelhasznalo = "";
$eletkor = "";
$regjelszo = "";
$regjelszo2 = "";
$msg = "";
$hash_regjelszo = "";
$feltoltheto = true;

if (isset($_POST["regisztracio"])) {
  if (isset($_POST["regfelhasznalo"])  && $_POST["regfelhasznalo"] != "") {
    $regfelhasznalo = $_POST["regfelhasznalo"];
  } else {
    $feltoltheto = false;
    $msg = "<div class='alert alert-danger'>Kérem adjon meg egy felhasználónevet</div>";
  }

  if (isset($_POST["eletkor"])  && $_POST["eletkor"] != "") {
    $eletkor = $_POST["eletkor"];
  } else {
    $feltoltheto = false;
    $msg .= "<div class='alert alert-danger'>Kérem adja meg a születési dátumát!</div>";
  }

  if (isset($_POST["regjelszo"])  && $_POST["regjelszo"] != "") {
    $regjelszo = $_POST["regjelszo"];
  } else {
    $feltoltheto = false;
    $msg .= "<div class='alert alert-danger'>Kérem adjon meg egy jelszót!</div>";
  }

  if (isset($_POST["regjelszo2"]) && $_POST["regjelszo2"] != "") {
    if ($_POST["regjelszo"] == $_POST["regjelszo2"]) {
      $regjelszo2 = $_POST["regjelszo2"];
      $hash_regjelszo = password_hash($regjelszo, PASSWORD_DEFAULT);
    } else {
      $feltoltheto = false;
      $msg .= "<div class='alert alert-danger'>A két jelszó nem egyezik!</div>";
    }
  } else {
    $feltoltheto = false;
    $msg .= "<div class='alert alert-danger'>Kérem adja meg ismételten a jelszavát!</div>";
  }

  if ($feltoltheto === true) {
    $conn = new OracleConnection();
    $result = $conn->getData("SELECT * FROM FELHASZNALO WHERE felhasznalonev ='" . $regfelhasznalo . "'");
    if (empty($result)) {
      $siker=$conn->regisztral($regfelhasznalo, $hash_regjelszo, $eletkor, null);
      header('Location:index.php');
      if($siker =! ""){
        $msg = "<div class='alert alert-danger'>A regisztrációhoz szükséges életkor: 15 év.</div>";
      }else{
        header('Location:index.php');
      }
    } else {
      $msg = "<div class='alert alert-danger'>Ezzel a felhasználónévvel már regisztráltak, kérem válasszon másikat!</div>";
    }
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
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  <title>Document</title>
</head>

<body style="font-family: 'Roboto', sans-serif;">
  <section class="vh-100" style="background-color: #99bac4;">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Regisztráció</p>

                  <form class="mx-1 mx-md-4" method="post">

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="text" name="regfelhasznalo" class="form-control" />
                        <label class="form-label" for="form3Example1c">Felhasználónév</label>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="number" name="eletkor" class="form-control" />
                        <label class="form-label" for="form3Example3c">Életkor</label>
                        <p style="font-size: small;">*a regisztrációhoz szükséges minimum életkor: 15 év</p>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="password" name="regjelszo" class="form-control" />
                        <label class="form-label" for="form3Example4c">Jelszó</label>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="password" name="regjelszo2" class="form-control" />
                        <label class="form-label" for="form3Example4cd">Jelszó mégegyszer</label>
                      </div>
                    </div>
                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <button type="submit" name="regisztracio" class="btn btn-dark btn-lg">Regisztráció</button>
                    </div>

                  </form>

                </div>
                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                  <img src="img/reg.jpg" class="img-fluid rounded" alt="Sample image">

                </div>
              </div>
              <?= $msg ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>