<?php
session_start();
include("db.php");

function check_credentials($username, $password)
{
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "root";
    $db_name = "online_bookstore";

    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $escaped_username = $conn->real_escape_string($username);

    $query = "SELECT id, password FROM users WHERE username='$escaped_username'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            $conn->close();
            return $user_id;
        }
    }

    $conn->close();
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $user_id = check_credentials($username, $password);

    if ($user_id !== false) {
        $_SESSION["user_id"] = $user_id;
        $_SESSION["username"] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Pogrešno korisničko ime ili lozinka";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Online Knjižara - Prijava i Registracija</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container1 {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>

<body>
    <!-- Bootstrap Navigacija -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/Online Knjizara">Online knjižara</a>
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
                    <?php
                    if (isset($_SESSION["username"])) {
                        echo "<li class='nav-item'><a class='nav-link' href='#'>" . $_SESSION["username"] . "</a></li>";
                    } else {
                        echo "<li class='nav-item'><a class='nav-link' href='/Online%20Knjizara/login.php'>Prijava</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container1">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center">Prijava</h1>
                <!-- Forma za registraciju i prijavu -->
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="username">Korisničko ime:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Lozinka:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Prijavi se</button>
                </form>
                <p class='text-center'>Nemate nalog? <a href="registration.php">Registrujte se ovde</a></p>
                <?php
                if (isset($error_message)) {
                    echo "<p class='text-center'>" . htmlspecialchars($error_message) . "</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>