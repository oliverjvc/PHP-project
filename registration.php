<?php
// PUTANJA: /c:/wamp64/www/Online Knjizara/registration.php

// Detalji za povezivanje s bazom podataka
$db_host = "localhost";
$db_user = "root";
$db_password = "root";
$db_name = "online_bookstore";

// Uspostavljanje veze s bazom podataka
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Provera veze
if ($conn->connect_error) {
    die("Neuspela veza: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dobijanje podataka iz forme
    $korisnickoIme = $_POST["username"];
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

    if (!$email) {
        echo "Nevažeća adresa e-pošte.";
        exit();
    }

    $sifra = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Validacija podataka forme (možete dodati više logike za validaciju ovde)
    if (empty($korisnickoIme) || empty($email) || empty($sifra)) {
        echo "Popunite sva polja.";
    } else {
        // Zaštita od SQL ubrizgavanja
        $escKorisnickoIme = $conn->real_escape_string($korisnickoIme);
        $escEmail = $conn->real_escape_string($email);

        // Ubacivanje korisničkih podataka u bazu podataka
        $upit = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($upit);
        $stmt->bind_param("sss", $escKorisnickoIme, $escEmail, $sifra);

        if ($stmt->execute()) {
            // Preusmeravanje na početnu stranicu
            header("Location: index.php");
            exit();
        } else {
            echo "Greška: " . $conn->error;
        }
    }
}

// Zatvaranje veze s bazom podataka
$conn->close();
?>

<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registraciona Stranica</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                    <li class="nav-item">
                        <a class="nav-link" href="/Online%20Knjizara/login.php">Prijava</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Registracija</h1>
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label for="username">Korisničko ime:</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Šifra:</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>

                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="Registruj se">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>