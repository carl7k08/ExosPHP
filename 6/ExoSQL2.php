<?php

try {
    $dbh = new PDO('mysql:host=localhost;dbname=jo;charset=utf8', 'root', '');
} catch (PDOException $e) {
    die($e->getMessage());
}

$colonnes_autorisees = ['nom', 'pays', 'course', 'temps'];

$tri_colonne = 'temps';
if (isset($_GET['col']) && in_array($_GET['col'], $colonnes_autorisees)) {
    $tri_colonne = $_GET['col'];
}

$tri_direction = 'ASC';
if (isset($_GET['dir']) && strtoupper($_GET['dir']) === 'DESC') {
    $tri_direction = 'DESC';
}
