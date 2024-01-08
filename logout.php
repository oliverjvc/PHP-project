<?php
session_start();

// Uništi sesiju
session_destroy();

// Preusmeri na glavnu stranicu nakon odjave
header("Location: index.php");
exit();
?>
