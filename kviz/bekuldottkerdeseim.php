<?php
session_start();
require("connection.php");

$conn = new OracleConnection();

$kerdeseim = $conn->sajat_kerdesek_lekerese($_SESSION["felhasznalonev"]);

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

<body>
    <section class="vh-600" style="background-color: #f0ffab;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black mt-5 mb-5 shadow" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="ms-4 px-3 pb-5">
                                <a href="mainpage.php" class="btn btn-dark btn-sm">Vissza</a>
                            </div>
                            <div class="">
                                <h3 class="text-center mb-5">Beküldött kérdéseim</h3>
                                <input class="w-100 rounded mb-3 shadow p-1" type="text" id="myInput" onkeyup="filterTable()" placeholder="Kérdés keresése...">
                                <table class="table rounded-2 table-striped" id="myTable">
                                    <thead class="table-dark">
                                        <th></th>
                                        <th>kérdés szövege</th>
                                        <th>válasz</th>
                                        <th>válasz</th>
                                        <th>válasz</th>
                                        <th>válasz</th>
                                        <th>nehézségi szint</th>
                                    </thead>

                                    <form action="kerdes_modositas_torles.php" method="post">
                                        <tbody>
                                            <?php
                                            foreach ($kerdeseim as $key => $kerdes) {
                                                echo "<tr>";
                                                echo "<td><input type='radio' id='html' name='kerdes_id' value='" . $kerdes["ID"] . "'></td>";
                                                echo "<td>" . $kerdes["SZOVEG"] . "</td>";
                                                echo "<td class='text-danger'>" . $kerdes["VALASZ1"] . "</td>";
                                                echo "<td class='text-danger'>" . $kerdes["VALASZ2"] . "</td>";
                                                echo "<td class='text-danger'>" . $kerdes["VALASZ3"] . "</td>";
                                                echo "<td class='text-success'>" . $kerdes["HELYES_VALASZ"] . "</td>";
                                                echo "<td>" . $kerdes["NEHEZSEG"] . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                </table>
                                <div class="d-grid gap-2 col-3 pt-5 mx-auto">
                                    <button type="submit" class="btn btn-dark" name="modositas" value="mod">módosítás</button>
                                    <button type="submit" class="btn btn-dark" name="torles" value="del" onclick="confirm('Biztosan szeretné törölni?')">törlés</button>
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
<script>
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

</html>