<?php
session_start();
include("db.php"); // Uključi konekciju sa bazom podataka

// Proveri da li je korisnik prijavljen
if (!isset($_SESSION["username"])) {
    // Preusmeri na stranicu za prijavu ako korisnik nije prijavljen
    header("Location: login.php");
    exit();
}

// Dobavi informacije o korisniku iz baze podataka
$username = $_SESSION["username"];
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($result);

// Dobavi korisnikovu korpu
$cart = isset($_SESSION["shopping_cart"]) ? $_SESSION["shopping_cart"] : [];

?>
<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Korisnički Profil</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <!-- Bootstrap Navigacija -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/Online Knjizara">Online Knjižara</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Početna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kategorije</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Online%20Knjizara/shopping_cart.php">Korpa</a>
                    </li>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><?php echo $_SESSION["username"]; ?></a>
                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                            <a class='dropdown-item' href='profile.php'>Profil</a>
                            <div class='dropdown-divider'></div>
                            <a class='dropdown-item' href='/Online%20Knjizara/logout.php'>Odjavi se</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Informacije o korisničkom profilu -->
    <div class="container mt-5">
        <h2>Korisnički Profil</h2>
        <p><strong>Korisničko ime:</strong> <?php echo $user['username']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
    </div>

    <!-- Korisnička korpa -->
    <div class="container mt-4">
        <h2>Korpa</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Knjiga</th>
                    <th>Količina</th>
                    <th>Cena</th>
                    <th>Ukupno</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ukupnaCena = 0;
                foreach ($cart as $proizvod) :
                ?>
                    <tr>
                        <td><?php echo $proizvod["ime"]; ?></td>
                        <td><?php echo $proizvod["kolicina"]; ?></td>
                        <td><?php echo $proizvod["cena"]; ?> din</td>
                        <td><?php echo $proizvod["cena"] * $proizvod["kolicina"]; ?> din</td>
                    </tr>
                <?php
                    $ukupnaCena += $proizvod["cena"] * $proizvod["kolicina"];
                endforeach;
                ?>
                <tr>
                    <td colspan="3" align="right"><strong>Ukupno:</strong></td>
                    <td><?php echo $ukupnaCena; ?> din</td>
                </tr>
            </tbody>
        </table>
    </div>


</body>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

</html>