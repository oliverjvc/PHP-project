<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Provera da li je korisnik prijavljen
    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];

        // Provera da li je 'book_id' postavljen u $_GET nizu
        if (isset($_GET["book_id"]) && !empty($_GET['book_id'])) {
            $book_id = $_GET["book_id"];
            $review_text = $_POST["review_text"];
            $rating = 5;


            // Ubacivanje recenzije u bazu podataka
            $insert_query = "INSERT INTO reviews (user_id, book_id, review_text, rating, review_date) VALUES ('$user_id', $book_id, '$review_text', $rating, NOW())";
            $result = mysqli_query($connection, $insert_query);

            if ($result) {
                echo "Recenzija uspešno dodata!";
                echo "<br>";
                echo "Bićete preusmereni na stranicu knjige za 3 sekunde...";
                header("refresh:3; url=index.php");
            } else {
                echo "Greška prilikom dodavanja recenzije: " . mysqli_error($connection);
            }
        } else {
            echo "Nevažeći podaci za slanje obrasca. Nedostaje 'book_id'.";
        }
    } else {
        echo "Morate biti prijavljeni da biste poslali recenziju.";
    }
}
?>

<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Napiši Recenziju</title>
    <!-- Dodaj Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .review-form {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>

<body>

    <!-- HTML obrazac za slanje recenzije -->

    <div class="container review-form">
        <!-- Zaštitni mehanizam protiv XSS napada -->
        <form method="post" action="review.php<?php echo isset($_GET['book_id']) ? '?book_id=' . htmlspecialchars($_GET['book_id']) : ''; ?>&user_id=<?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : ''; ?>&username=<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" class="mt-4">
            <input type="hidden" name="book_id" value="<?php echo isset($_GET['book_id']) ? htmlspecialchars($_GET['book_id']) : ''; ?>">
            <label for="review_text">Vaša Recenzija:</label>
            <textarea name="review_text" rows="4" class="form-control" required></textarea>
            <br>
            <button type="submit" class="btn btn-primary btn-block">Pošalji Recenziju</button>
        </form>
    </div>


</body>

</html>