<?php
session_start();

include '../connect.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$stmt_client = $pdo->prepare('SELECT * FROM clients');
$stmt_client->execute();
$clients = $stmt_client->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('INSERT INTO factures (date_facture, id_client, montant_total, status) VALUES (?, ?, ?, ?)');
    $stmt->execute([$_POST['date_facture'], $_POST['id_client'], $_POST['total'], $_POST['paid']]);
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
<h1>Add client</h1>

<form action="add.php" method="post">    
    <select name="id_client">
        <option value="">Select client</option>
        ' ?>
<?php foreach ($clients as $client): ?>
    <option value="<?php echo $client['id'] ?>"><?php echo $client['prenom'] . ' ' . $client['nom'] ?></option>
<?php endforeach; ?>
<?php echo '
    </select>
    <input type="date" name="date_facture">
    <input type="number" name="total">
    <input type="text" name="paid">
    <input type="submit" value="Save">
</form>

<a href="index.php">Annuler</a>
';
?>