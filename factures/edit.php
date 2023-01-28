<?php
session_start();

$title = 'Modifier une facture';
include "../connect.php";
include '../header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$id = $_GET['id'];
$stmt_fact = $pdo->prepare('SELECT c.prenom, df.quantite, df.prix, f.* FROM clients c 
    JOIN factures f on c.id = f.id_client JOIN details_factures df on df.id_facture = f.id WHERE f.id = ?');
$stmt_fact->execute([$id]);
$facture = $stmt_fact->fetch(PDO::FETCH_ASSOC);

$stmt_clients = $pdo->prepare('SELECT * FROM clients');
$stmt_clients->execute();
$clients = $stmt_clients->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    $stmt_fct = $pdo->prepare('UPDATE factures SET date_facture = ?, id_client = ?, status = ? WHERE id = ?');
//    $stmt_fct->execute([$_POST['date_facture'], $_POST['id_client'], $_POST['status'], $_GET['id']]);
//
//    $stmt_fct_det = $pdo->prepare('UPDATE details_factures SET quantite = ?, prix = ? WHERE id = ?');
//    $stmt_fct_det->execute([$_POST['qte'], $_POST['prix'], $_GET['id']]);

    header('Location: index.php');
    exit;
}
?>

<?php
echo '
<div class="d-flex justify-content-between align-items-center mt-5 mb-2">
<h1>Modifier une facture</h1>
</div>
';
?>

<?php
echo '
<section class="container">
    <form action="edit.php" method="post" class="row">    
        <div class="form-group mt-3">
            <label for="date_facture">Date</label>
            <input class="form-control" type="date" name="date_facture" id="date_facture" value="'.$facture['date_facture'].'">
        </div>
        <div class="form-group mt-3">
            <label for="id_client">Client</label>
            <select name="id_client" class="form-control" id="id_client">
                <option value="">Select client</option>
        ' ?>
<?php foreach ($clients as $client): ?>
    <option <?= $facture['id_client'] == $client['id'] ? ' selected="selected"' : ''; ?> value="<?php echo $client['id'] ?>"><?php echo $client['prenom'] . ' ' . $client['nom'] ?></option>
<?php endforeach; ?>
<?php echo '
            </select>
        </div>
        <div class="form-group mt-3">
            <label for="">Quantité</label>
            <input class="form-control" type="number" name="qte" value="' . $facture['quantite'] . '">
        </div>
        <div class="form-group mt-3">
            <label for="">Prix</label>
            <input class="form-control" type="number" name="prix" value="' . $facture['prix'] . '">
        </div>
        <div class="form-group mt-3">
            <label for="">Status</label>
            <select class="form-control" name="status" id="status">
            ' ?>
    <option <?= $facture['status'] == 'Payé' ? ' selected="selected"' : ''; ?> value="Payé">Payé</option>
    <option <?= $facture['status'] == 'Impayé' ? ' selected="selected"' : ''; ?> value="Impayé">Impayé</option>
<?php echo '
        </div>
        <div class="mt-5 row g-3 justify-content-end align-items-end d-flex">
            <input class="btn btn-primary mt-5 col-3" type="submit" value="Save">
            <a class="btn btn-outline-primary mt-5 col-2" href="index.php">Annuler</a>
        </div>
    </form>
</section>
';
?>