<?php
// start the session
session_start();
include 'connect.php';
// login page

// if the user is already logged in, redirect to the dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: factures/index.php');
    exit;
}
// if the user is not logged in, show the login form
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../theme.css">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
              crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
                crossorigin="anonymous"></script>
        <title>Gestion des factures</title>
        <style>

        </style>
    </head>
<body>
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    Gestion de factures
                </a>
            </div>
        </div>
    </header>
<main class="d-flex align-items-center justify-content-center">

<?php
// if the user is not logged in, show the login form
echo '
 <form class="w-25 mt-5" action="login.php" method="post">
  <div class="form-group m-1">
    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="form-group m-1">
    <input name="password" type="password" class="form-control" id="exampleInputPassword1">
  </div>
  <button type="submit" class="btn btn-primary ms-1">Se connecter</button>
</form>
</main>
    </body>
    </html>

';
?>

<?php
// if the user has submitted the login form, check the credentials
if (isset($_POST['email'], $_POST['password'])) {
    // connect to the database
    include 'connect.php';

    // prepare the SQL query
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND password = ?');

    // execute the SQL query
    $stmt->execute([$_POST['email'], $_POST['password']]);

    // fetch the user record
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // if the user record exists, set the session variables
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header('Location: factures/index.php');
        exit;
    } else {
        echo 'Incorrect username or password!';
    }
}