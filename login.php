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

<?php
// if the user is not logged in, show the login form
echo '
        <form action="login.php" method="post">
            <input type="text" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" value="Login">
        </form>
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