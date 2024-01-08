<?php
session_start();
include("db.php"); // Povezivanje sa bazom podataka

// Proveri da li je korisnik prijavljen
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Proveri da li korpa nije prazna
if (empty($_SESSION["shopping_cart"])) {
    header("Location: shopping_cart.php");
    exit();
}

$addressError = $phoneError = '';

// Obradi proces naplate
if (isset($_POST["checkout"])) {
    // Validiraj i obradi podatke iz forme
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $paymentOption = isset($_POST["payment_option"]) ? $_POST["payment_option"] : '';

    // Validiraj adresu
    if (empty($address) || strlen($address) < 5) {
        $addressError = "Unesite ispravnu adresu (minimum 5 karaktera).";
    }

    // Validiraj broj telefona
    if (empty($phone) || !preg_match("/^[0-9]+$/", $phone) || strlen($phone) < 10) {
        $phoneError = "Unesite ispravan broj telefona (numerčki, minimum 10 karaktera).";
    }

    // Ako postoje greške u validaciji, ne nastavljaj s procesom naplate
    if (!empty($addressError) || !empty($phoneError)) {
        echo '<div class="alert alert-danger" role="alert">Postoje greške u vašem obrascu. Molimo vas da proverite i pokušate ponovo.</div>';
    } else {
        // Nakon procesiranja, isprazni korpu
        unset($_SESSION["shopping_cart"]);
        header("Location: thank_you.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Knjižara - Checkout</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <h2>Provera</h2>

        <!-- Prikazi informacije o korisniku iz sesije -->
        <p>Dobrodošli, <?php echo $_SESSION["username"]; ?>! Pregledajte svoju porudžbinu i nastavite ka proveri.</p>

        <!-- Prikazi stavke korpe -->
        <table class="table">
            <thead>
                <tr>
                    <th>Knjiga</th>
                    <th>Cena</th>
                    <th>Količina</th>
                    <th>Ukupno</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPrice = 0;

                foreach ($_SESSION["shopping_cart"] as $product) :
                ?>
                    <tr>
                        <td><?php echo $product["name"]; ?></td>
                        <td><?php echo $product["price"]; ?> din</td>
                        <td><?php echo $product["quantity"]; ?></td>
                        <td><?php echo $product["price"] * $product["quantity"]; ?> din</td>
                    </tr>
                <?php
                    $totalPrice += $product["price"] * $product["quantity"];
                endforeach;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" align="right"><strong>Ukupno:</strong></td>
                    <td><?php echo $totalPrice; ?> din</td>
                </tr>
            </tfoot>
        </table>

        <!-- Forma za proveru -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="address">Adresa:</label>
                <input type="text" class="form-control" id="address" name="address" required>
                <?php if (!empty($addressError)) echo '<p class="text-danger">' . $addressError . '</p>'; ?>
            </div>
            <div class="form-group">
                <label for="phone">Broj telefona:</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
                <?php if (!empty($phoneError)) echo '<p class="text-danger">' . $phoneError . '</p>'; ?>
            </div>
            <div class="form-group">
                <label>Opcije plaćanja:</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="onlinePayment" name="payment_option" value="online" required disabled>
                    <label class="form-check-label" for="onlinePayment">Plati Online (uskoro)</label>
                </div>

                <div class="form-check">
                    <input type="radio" class="form-check-input" id="inPersonPayment" name="payment_option" value="in_person" required>
                    <label class="form-check-label" for="inPersonPayment">Plati pouzećem</label>
                </div>
            </div>
            <!-- Onemogući dugme za proveru ako postoje greške u validaciji -->
            <button type="submit" name="checkout" class="btn btn-primary">
                Poruči
            </button>
        </form>

    </div>

</body>

</html>
