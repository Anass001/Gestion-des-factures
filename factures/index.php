<?php

session_start();

$title = 'Factures';
include "../connect.php";
include '../header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$stmt_fact = $pdo->prepare('SELECT c.prenom, df.quantite, df.prix, f.* FROM clients c 
    JOIN factures f on c.id = f.id_client JOIN details_factures df on df.id_facture = f.id');
$stmt_fact->execute();

$factures = $stmt_fact->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
echo '
<div class="d-flex justify-content-between align-items-center mt-5 mb-2">
<h1>Factures</h1>
<a href="add.php" class="btn btn-primary">Ajouter</a>
</div>
';
?>
<?php
echo '
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Client</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    ';

foreach ($factures as $facture) {
    echo '
            <tr>
                <td>' . $facture['id'] . '</td>
                <td>' . $facture['date_facture'] . '</td>
                <td>' . $facture['prenom'] . '</td>
                <td>' . $facture['quantite'] . '</td>
                <td>' . $facture['prix'] . '</td>
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
    </main>
    </body>
    </html>
    ';
?>
