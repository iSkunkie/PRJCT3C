<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Get the customer ID from the URL parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: customer_list.php');
    exit();
}

// Delete the customer from the database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'garage2';

$db = new mysqli($host, $username, $password, $database);

if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

$query = "DELETE FROM customer WHERE customerid = '$id'";

if ($db->query($query) === true) {
    $success = 'Customer deleted successfully!';
} else {
    $error = 'Error deleting customer: ' . $db->error;
}

$db->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Customer</title>
</head>

<body>
    <h2>Delete Customer</h2>
    <a href="customer_list.php">Back to Customer List</a><br>

    <?php if (isset($success)) { ?>
        <p><?php echo $success; ?></p>
    <?php } ?>

    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
</body>

</html>