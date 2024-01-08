<?php
session_start();

if (isset($_GET["book_id"])) {
    $idKnjigeZaUklanjanje = $_GET["book_id"];

    if (!empty($_SESSION["shopping_cart"])) {
        // Prolazi kroz korpu i traži i uklanja proizvod
        foreach ($_SESSION["shopping_cart"] as $kljuc => $proizvod) {
            if ($proizvod["id"] == $idKnjigeZaUklanjanje) {
                // Uklanja proizvod iz korpe
                unset($_SESSION["shopping_cart"][$kljuc]);
                break; // Zaustavi petlju nakon uklanjanja
            }
        }
    }
    echo "Proizvod uspešno uklonjen";
} else {
    echo "Nevažeći zahtev";
}
?>
