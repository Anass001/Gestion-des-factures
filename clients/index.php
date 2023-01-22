<?php
session_start();

include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../login.php');
    exit;
}

$stmt_client = $pdo->prepare('SELECT * FROM clients');

$stmt_client->execute();

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
<h1>Clients</h1>
<h2>Nombre de clients: ' . count($clients) . '</h2>

<h2><a href="../factures/index.php">Factures</a></h2>

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
                <td>image</td>
                <td>prenom</td>
                <td>nom</td>
                <td>num tel</td>
                <td>email</td>
                <td>adresse</td>
                <td>ville</td>
                <td>code postale</td>
                <td>actions</td>
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
    </body>
    </html>
    ';
?>
