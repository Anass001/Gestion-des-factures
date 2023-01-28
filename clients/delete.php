<?php
$title = 'Supprimer un client';
include "../connect.php";
include '../header.php';

$id = $_GET['id'];
$sql = "DELETE FROM clients WHERE id = $id";
$pdo->exec($sql);

header('Location: index.php');