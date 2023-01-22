<?php
include "../connect.php";

$id = $_GET['id'];
$sql = "DELETE FROM factures WHERE id = $id";
$pdo->exec($sql);

header('Location: index.php');