<?php
session_start();
require("connection.php");
$jelszo = "";
$msg = "";


if (isset($_POST["bejelentkezes"])) {
  if (isset($_POST["felhasznalonev"])  && $_POST["felhasznalonev"] != "") {
    $felhasznalonev = $_POST["felhasznalonev"];
  } else {
    $msg = "<div class='alert alert-danger'>Kérem adja meg a felhasználónevet</div>";
  }

  if (isset($_POST["jelszo"])  && $_POST["jelszo"] != "") {
    $jelszo = $_POST["jelszo"];
  } else {
    $msg = "<div class='alert alert-danger'>Kérem adja meg a jelszavát</div>";
  }

  if (($felhasznalonev != "") && ($jelszo != "")) {
    $conn = new OracleConnection();
    $x = $conn->getData("SELECT * FROM FELHASZNALO WHERE felhasznalonev ='" . $felhasznalonev . "'");

    if ($x) {
      if ($felhasznalonev == $x["FELHASZNALONEV"]) {
        if (password_verify($jelszo, $x["JELSZO"])) {
          $_SESSION["felhasznalonev"] = $felhasznalonev;
          header('Location:mainpage.php');
        } else {
          $msg = "<div class='alert alert-danger'>Hibás jelszó!</div>";
        }
      } else {
        $msg = "<div class='alert alert-danger'>Hibás felhasználónév!</div>";
      }
    } else {
      $msg = "<div class='alert alert-danger'>Hibás felhasználónév!</div>";
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
  <link rel="stylesheet" href="css/style.css">
  <title>Kvíz</title>
</head>

<body>
  <section class="vh-100" style="background-color: #8fdb97;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block mt-5">
                <img src="img/login.jpg" alt="login form" class="img-fluid mt-5" style="border-radius: 1rem 0 0 1rem;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">

                  <form action="" method="post">

                    <div class="d-flex align-items-center mb-3 pb-1">
                      <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                      <span class="h1 fw-bold mx-auto">Bejelentkezés</span>
                    </div>

                    <h5 class="fw-normal mb-3 pb-3 " style="letter-spacing: 1px;">Jelentkezz be a fiókodba</h5>

                    <div class="form-outline mb-4">
                      <input type="text" name="felhasznalonev" id="form2Example17" class="form-control form-control-lg" />
                      <label class="form-label" for="form2Example17">Felhasználónév</label>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" name="jelszo" id="form2Example27" class="form-control form-control-lg" />
                      <label class="form-label" for="form2Example27">Jelszó</label>
                    </div>

                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg btn-block" type="submit" name="bejelentkezes">Bejelentkezés</button>
                    </div>
                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Nincs még fiókod? <a href="register.php" style="color: #393f81;">Akkor itt tudsz regisztrálni egyet!</a></p>
                  </form>

                </div>
              </div>
              <?php echo $msg ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>