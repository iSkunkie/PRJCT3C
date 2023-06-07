<?php
require_once 'Auth.php';

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'garage2';

$auth = new Auth($host, $username, $password, $database);

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $auth->register($username, $password);
    $success = 'Registration successful!';
}
?>

<!-- HTML form for registration -->
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
</head>

<body>
    <h2>Register</h2>
    <?php if (isset($success)) { ?>
        <p><?php echo $success; ?></p>
    <?php } ?>
    <form method="POST" action="register_process.php">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" name="register" value="Register">
    </form>
</body>

</html>