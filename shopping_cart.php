<?php
session_start();
include("db.php"); // Povezivanje s bazom podataka


if (isset($_POST["empty_cart"])) {
    unset($_SESSION["shopping_cart"]);
}

?>
<!DOCTYPE html>
<html>

<head>
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
                        echo "<a class='dropdown-item' href='profile.php'>Profile</a>";
                        echo "<div class='dropdown-divider'></div>";
                        echo "<a class='dropdown-item' href='/Online%20Knjizara/logout.php'>Sign Out</a>";
                        echo "</div>";
                        echo "</li>";
                    } else {
                        echo "<li class='nav-item'><a class='nav-link' href='/Online%20Knjizara/login.php'>Login</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <title>Online Knjižara - Korpa za Kupovinu</title>
    <?php
    if (isset($_POST["empty_cart"])) {
        unset($_SESSION["shopping_cart"]);
    }

    ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            function removeFromCart(bookId) {
                $.ajax({
                    url: "remove_from_cart.php",
                    type: "GET",
                    data: {
                        book_id: bookId
                    },
                    success: function(response) {
                        // Prikaz korpe za kupovinu
                        $("#cart-section").html(response);
                    }
                });
            }
        </script>
    </head>

<body>
    <!-- Prikaz korpe za kupovinu -->
    <div class="container">
        <h1>Korpa za Kupovinu</h1>
        <form method="post">
            <input type="submit" name="empty_cart" value="Isprazni korpu">
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Naziv knjige</th>
                    <th>Cena</th>
                    <th>Količina</th>
                    <th>Ukupno</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody id="cart-section">
                <?php
                if (!empty($_SESSION["shopping_cart"])) {
                    $totalPrice = 0;

                    foreach ($_SESSION["shopping_cart"] as $product) :
                ?>
                        <tr>
                            <td><?php echo $product["name"]; ?></td>
                            <td><?php echo $product["price"]; ?> din</td>
                            <td><?php echo $product["quantity"]; ?></td>
                            <td><?php echo $product["price"] * $product["quantity"]; ?> din</td>
                            <td>
                                <button class="btn btn-danger" onclick="removeFromCart(<?php echo $product['id']; ?>)">Ukloni</button>
                            </td>
                        </tr>
                    <?php
                        $totalPrice += $product["price"] * $product["quantity"];
                    endforeach;
                    ?>
                    <tr>
                        <td colspan="4" align="right"><strong>Total:</strong></td>
                        <td><?php echo $totalPrice; ?> din</td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right">
                            <a href="checkout.php" class="btn btn-primary">Poruči</a>
                        </td>
                    </tr>
                <?php
                } else {
                    echo "<tr><td colspan='5'>Korpa je prazna</td></tr>";
                }
                ?>
            </tbody>

        </table>
    </div>
</body>

</html>