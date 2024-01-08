<?php
session_start();
include("db.php"); // Povezivanje sa bazom podataka

// Dobavljanje jedinstvenih kategorija iz baze podataka
$query = "SELECT DISTINCT genre FROM books";
$result = mysqli_query($connection, $query);

// Obrada izbora kategorije
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_category"])) {
    $selected_category = $_POST["category"];

    // Dobavljanje knjiga na osnovu izabrane kategorije
    $category_query = "SELECT * FROM books WHERE genre='$selected_category'";
    $category_result = mysqli_query($connection, $category_query);
} else {
    // Upit za dobavljanje svih knjiga
    $default_query = "SELECT * FROM books";
    $category_result = mysqli_query($connection, $default_query);
}

?>

<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Knjižara - Kategorije</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <?php
                    if (isset($_SESSION["username"])) {
                        echo "<li class='nav-item dropdown'>";
                        echo "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" . $_SESSION["username"] . "</a>";
                        echo "<div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
                        echo "<a class='dropdown-item' href='profile.php'>Profil</a>";
                        echo "<div class='dropdown-divider'></div>";
                        echo "<a class='dropdown-item' href='/Online%20Knjizara/logout.php'>Odjavi se</a>";
                        echo "</div>";
                        echo "</li>";
                    } else {
                        echo "<li class='nav-item'><a class='nav-link' href='/Online%20Knjizara/login.php'>Prijava</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Forma za izbor kategorije -->
    <div class="container mt-4">
        <h2>Kategorije</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="category">Izaberite kategoriju:</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="Fiction">Fikcija</option>
                    <option value="Classics">Klasična dela</option>
                    <option value="Dystopian">Distopija</option>
                </select>
            </div>
            <button type="submit" name="confirm_category" class="btn btn-primary">Potvrdi</button>
        </form>

        <!-- Prikaz knjiga na osnovu izabrane kategorije -->
        <div class="row mt-4">
            <?php while ($row = mysqli_fetch_assoc($category_result)) : ?>
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <img src="<?php echo $row['image_url']; ?>" class="card-img-top" alt="Naslovna Strana Knjige">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                            <p class="card-text">Autor: <?php echo $row['author']; ?></p>
                            <p class="card-text">Žanr: <?php echo $row['genre']; ?></p>
                            <p class="card-text">Cena: <?php echo $row['price']; ?> din</p>
                            <!-- Forma za dodavanje u korpu -->
                            <form method="post" action="add_to_cart.php">
                                <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">
                                <input type="number" name="quantity" value="1" min="1">
                                <button type="submit" name="add_to_cart" class="btn btn-primary">Dodaj u korpu</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
