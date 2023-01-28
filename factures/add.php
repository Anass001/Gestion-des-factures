<?php
session_start();

$title = 'Ajouter une facture';
include "../connect.php";
include '../header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$stmt_client = $pdo->prepare('SELECT * FROM clients');
$stmt_client->execute();
$clients = $stmt_client->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt_fct = $pdo->prepare('INSERT INTO factures (date_facture, id_client, status) VALUES (?, ?, ?)');
    $stmt_fct->execute([$_POST['date_facture'], $_POST['id_client'], $_POST['status']]);

    $stmt_fct_det = $pdo->prepare('INSERT INTO details_factures (id_facture, quantite, prix) VALUES (?, ?, ?)');
    $stmt_fct_det->execute([$pdo->lastInsertId(), $_POST['qte'], $_POST['prix']]);

    header('Location: index.php');
    exit;
}
?>

<?php
echo '
<div class="d-flex justify-content-between align-items-center mt-5 mb-2">
<h1>Ajouter une facture</h1>
</div>
';
?>

<?php
echo '
<section class="container">
    <form action="add.php" method="post" class="row">    
        <div class="form-group mt-3">
            <label for="date_facture">Date</label>
            <input class="form-control" type="date" name="date_facture" id="date_facture">
        </div>
        <div class="form-group mt-3">
            <label for="id_client">Client</label>
            <select name="id_client" class="form-control" id="id_client">
                <option value="">Select client</option>
        ' ?>
<?php foreach ($clients as $client): ?>
    <option value="<?php echo $client['id'] ?>"><?php echo $client['prenom'] . ' ' . $client['nom'] ?></option>
<?php endforeach; ?>
<?php echo '
            </select>
        </div>
        <div class="form-group mt-3">
            <label for="">Quantité</label>
            <input class="form-control" type="number" name="qte">
        </div>
        <div class="form-group mt-3">
            <label for="">Prix</label>
            <input class="form-control" type="number" name="prix">
        </div>
        <div class="form-group mt-3">
            <label for="">Status</label>
            <select class="form-control" name="status" id="status">
                <option value="Payé">Payé</option>
                <option value="Impayé">Impayé</option>
        </div>
        <div class="mt-5 row g-3 justify-content-end align-items-end d-flex">
            <input class="btn btn-primary mt-5 col-3" type="submit" value="Save">
            <a class="btn btn-outline-primary mt-5 col-2" href="index.php">Annuler</a>
        </div>
    </form>

</section>
';
?>