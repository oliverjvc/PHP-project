<?php
session_start();
include("db.php"); // Povezivanje sa bazom podataka

if(isset($_POST["add_to_cart"])){
    $book_id = $_POST["book_id"];
    $quantity = $_POST["quantity"];

    // Dohvati detalje knjige iz baze podataka
    $book_query = "SELECT * FROM books WHERE id = ?";
    $stmt = mysqli_prepare($connection, $book_query);
    mysqli_stmt_bind_param($stmt, "i", $book_id);
    mysqli_stmt_execute($stmt);

    $book_result = mysqli_stmt_get_result($stmt);

    // Proveri da li je upit uspešno izvršen
    if (!$book_result) {
        die("Error in query: " . mysqli_error($connection));
    }

    $book = mysqli_fetch_assoc($book_result);

    // Zatvori upit
    mysqli_stmt_close($stmt);

    // Dodaj knjigu u korpu
    $cart_item = [
        "id" => $book_id,
        "name" => $book["title"],
        "price" => $book["price"],
        "quantity" => $quantity,
    ];

    // Inicijalizuj korpu ako nije postavljena
    if(!isset($_SESSION["shopping_cart"])){
        $_SESSION["shopping_cart"] = [];
    }

    // Proveri da li je knjiga već u korpi, ažuriraj količinu
    $found = false;
    foreach($_SESSION["shopping_cart"] as &$item){
        if($item["id"] == $book_id){
            $item["quantity"] += $quantity;
            $found = true;
        }
    }

    // Ako nije pronađena u korpi, dodaj je
    if(!$found){
        array_push($_SESSION["shopping_cart"], $cart_item);
    }

    // Preusmeri nazad na stranicu sa listom knjiga
    header("Location: index.php");
    exit();
}
?>
