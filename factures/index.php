<?php

session_start();

include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$stmt_fact = $pdo->prepare('SELECT * FROM factures');
$stmt_client = $pdo->prepare('SELECT * FROM clients');

$stmt_fact->execute();
$stmt_client->execute();

$factures = $stmt_fact->fetchAll(PDO::FETCH_ASSOC);
$clients = $stmt_client->fetchAll(PDO::FETCH_ASSOC);
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
<h1>Factures</h1>
<h2>Nombre de factures: ' . count($factures) . '</h2>

<h2><a href="../clients/index.php">Clients</a></h2>
<a href="../logout.php">Logout</a>
<a href="add.php">+ Ajouter</a>
';
?>
<?php
echo '
    <table>
        <thead>
            <tr>
                <td>id</td>
                <td>date</td>
                <td>client</td>
                <td>total</td>
                <td>paid</td>
                <td>actions</td>
            </tr>
        </thead>
        <tbody>
    ';

foreach ($factures as $facture) {
    echo '
            <tr>
                <td>' . $facture['id'] . '</td>
                <td>' . $facture['date_facture'] . '</td>
                <td>' ?>
    <?php foreach ($clients as $client) {
        if ($client['id'] == $facture['id_client']) {
            echo $client['prenom'] . ' ' . $client['nom'];
        }
    } ?>
    <?php echo
        '</td>
                <td>' . $facture['montant_total'] . '</td>
                <td>' . $facture['status'] . '</td>
                <td>
                    <a href="edit.php?id=' . $facture['id'] . '">Edit</a>
                    <a href="delete.php?id=' . $facture['id'] . '">Delete</a>
                </td>
            </tr>
        ';
}

echo '
        </tbody>
    </table>
    </body>
    </html>
    ';
?>
