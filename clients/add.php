<?php
session_start();

$title = 'Ajouter un client';
include "../connect.php";
include '../header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt_client = $pdo->prepare('INSERT INTO clients (prenom, nom, image, num_tel, email, adresse, ville, code_postale) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt_client->execute([$_POST['prenom'], $_POST['nom'], $_POST['image'], $_POST['num_tel'], $_POST['email'], $_POST['adresse'], $_POST['ville'], $_POST['code_postale']]);

    header('Location: index.php');
    exit;
}
?>

<?php
echo '
<div class="d-flex justify-content-between align-items-center mt-5 mb-2">
<h1>Ajouter un client</h1>
</div>
';
?>

<?php
echo '
<section class="container">
    <form action="add.php" method="post" class="row">    
        <div class="form-group mt-3">
            <label for="">Path to image</label>
            <input class="form-control" type="text" name="image">
        </div>
        <div class="form-group mt-3">
            <label for="">Prénom</label>
            <input class="form-control" type="text" name="prenom">
        </div>
        <div class="form-group mt-3">
            <label for="">Nom</label>
            <input class="form-control" type="text" name="nom">
        </div>
        <div class="form-group mt-3">
            <label for="">Numéro de téléphone</label>
            <input class="form-control" type="tel" name="num_tel">
        </div>
        <div class="form-group mt-3">
            <label for="">Email</label>
            <input class="form-control" type="email" name="email">
        </div>
        <div class="form-group mt-3">
            <label for="">Adresse</label>
            <input class="form-control" type="text" name="adresse">
        </div>
        <div class="form-group mt-3">
            <label for="">Ville</label>
            <input class="form-control" type="text" name="ville">
        </div>
        <div class="form-group mt-3">
            <label for="">Code postal</label>
            <input class="form-control" type="number" name="code_postale">   
        </div>
        <div class="mt-5 mb-5 row g-3 justify-content-end align-items-end d-flex">
                    <a class="btn btn-outline-primary col-2 me-2" href="index.php">Annuler</a>
            <input class="btn btn-primary col-3" type="submit" value="Save">
        </div>
    </form>

</section>
';
?>