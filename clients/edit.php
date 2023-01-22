<?php
session_start();

include '../connect.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$stmt_client = $pdo->prepare('SELECT * FROM clients WHERE id = ?');
$stmt_client->execute([$_GET['id']]);
$client = $stmt_client->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt_update = $pdo->prepare('UPDATE clients SET prenom = ?, nom = ?, num_tel = ?, email = ?, adresse = ?, ville = ?, code_postale = ? WHERE id = ?');
    $stmt_update->execute([$_POST['prenom'], $_POST['nom'], $_POST['num_tel'], $_POST['email'], $_POST['adresse'], $_POST['ville'], $_POST['code_postale'], $_POST['id']]);
    header('Location: index.php');
    exit;
}
?>

<?php
echo '<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../theme.css">
</sty>
    <title>Dashboard</title>
</head>
<body>
<h1>Editer client</h1>

<form action="edit.php" method="post">
    <input type="hidden" name="id" value="' . $client['id'] . '">
    <input type="text" name="prenom" value="' . $client['prenom'] . '">
    <input type="text" name="nom" value="' . $client['nom'] . '">
    <input type="text" name="num_tel" value="' . $client['num_tel'] . '">
    <input type="text" name="email" value="' . $client['email'] . '">
    <input type="text" name="adresse" value="' . $client['adresse'] . '">
    <input type="text" name="ville" value="' . $client['ville'] . '">
    <input type="text" name="code_postale" value="' . $client['code_postale'] . '">
    <input type="submit" value="Save">
</form>

<a href="index.php">Annuler</a>
';
?>