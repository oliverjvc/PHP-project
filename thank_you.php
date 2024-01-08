<?php

class ThankYouPage {
    public function render() {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Hvala Vam</title>
            <!-- Bootstrap -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>

        <body>

            <div class="container mt-5">
                <h2>Hvala Vam!</h2>
                <p>Vaša porudžbina je uspešno obrađena. Zahvaljujemo se na vašem poverenju!</p>
            </div>

            <!-- JavaScript za preusmeravanje nakon nekoliko sekundi -->
            <script>
                setTimeout(function () {
                    window.location.href = "index.php";
                }, 3000); // Preusmeri nakon 3 sekunde
            </script>

        </body>

        </html>
        <?php
    }
}

$thankYouPage = new ThankYouPage();
$thankYouPage->render();
?>
