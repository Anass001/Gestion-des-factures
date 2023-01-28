<?php
session_start();

$title = 'Clients';
include '../connect.php';
include '../header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$stmt_client = $pdo->prepare('SELECT * FROM clients');

$stmt_client->execute();

$clients = $stmt_client->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
echo '
<div class="d-flex justify-content-between align-items-center mt-5 mb-2">
<h1>Clients</h1>
<a href="add.php" class="btn btn-primary">Ajouter</a>
</div>
';
?>
<?php
echo '
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
            <tr>
                <td>#</td>
                <td>Image</td>
                <td>Prénom</td>
                <td>Nom</td>
                <td>Num Tél</td>
                <td>E-mail</td>
                <td>Adresse</td>
                <td>Ville</td>
                <td>Code postale</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
    ';

foreach ($clients as $client) {
    echo '
            <tr>
                <td>' . $client['id'] . '</td>
                <td><img width="30px" height="30px" src="' . $client['image'] . '" alt="client image"/></td>
                <td>' . $client['prenom'] . '</td>
                <td>' . $client['nom'] . '</td>
                <td>' . $client['num_tel'] . '</td>
                <td>' . $client['email'] . '</td>
                <td>' . $client['adresse'] . '</td>
                <td>' . $client['ville'] . '</td>
                <td>' . $client['code_postale'] . '</td>
                <td>
                    <a href="edit.php?id=' . $client['id'] . '">Edit</a>
                    <a href="delete.php?id=' . $client['id'] . '">Delete</a>
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
