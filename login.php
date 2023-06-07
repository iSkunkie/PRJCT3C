<?php
session_start();

require_once 'Auth.php';

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'garage2';

$auth = new Auth($host, $username, $password, $database);

if ($auth->isLoggedIn()) {
    header('Location: admin_panel.php');
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($auth->login($username, $password)) {
        header('Location: admin_panel.php');
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!-- HTML form for login -->
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" action="login_process.php">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" name="login" value="Login">
    </form>
</body>

</html>