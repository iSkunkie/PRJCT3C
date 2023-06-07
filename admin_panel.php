<?php
session_start();

class Auth
{
    public function isLoggedIn()
    {
        return isset($_SESSION['username']);
    }

    public function logout()
    {
        unset($_SESSION['username']);
        session_destroy();
    }
}

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['logout'])) {
    $auth->logout();
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<!-- HTML content for the admin panel -->
<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
</head>

<body>
    <h2>Welcome to the Admin Panel, <?php echo $_SESSION['username']; ?>!</h2>
    <a href="customer_list.php">Manage Customers</a><br>
    <form method="POST" action="">
        <input type="submit" name="logout" value="Logout">
    </form>
</body>

</html>