<?php
$title = 'Supprimer une facture';
include "../connect.php";
include '../header.php';
$id = $_GET['id'];
$sql = "DELETE FROM factures WHERE id = $id";
$pdo->exec($sql);

header('Location: index.php');