<?php
session_start();
include("db.php"); // Povezivanje s bazom podataka

// Prikaz knjiga
$query = "SELECT * FROM books";
$result = mysqli_query($connection, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Online Knjižara - Knjige</title>
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
                        <a class="nav-link" href="#">Početna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">Kategorije</a>
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

    <!-- Kartice knjiga sa dugmicima za dodavanje u korpu i recenziju -->
    <div class="container mt-4">
        <h2>Lista knjiga</h2>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="col-lg-3 mb-4">
                    <div class="card">
                        <img src="<?php echo $row['image_url']; ?>" class="card-img-top" alt="Book Cover">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                            <p class="card-text">Autor: <?php echo $row['author']; ?></p>
                            <p class="card-text">Žanr: <?php echo $row['genre']; ?></p>
                            <p class="card-text">Cena: <?php echo $row['price']; ?> din</p>
                            <!-- Dodaj u korpu -->
                            <form method="post" action="add_to_cart.php">
                                <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">
                                <input type="number" name="quantity" value="1" min="1">
                                <button type="submit" name="add_to_cart" class="btn btn-primary">Dodaj u korpu</button>
                            </form>

                            <!-- Dugme recenzija -->
                            <a href="review.php?book_id=<?php echo $row['id']; ?>" class="btn btn-success mt-2">Recenzija</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

<!-- Bootstrap JS (mora) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

</html>