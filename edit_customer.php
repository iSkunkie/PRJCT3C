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

// Fetch the customer from the database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'garage2';

$db = new mysqli($host, $username, $password, $database);

if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

$query = "SELECT * FROM customer WHERE customerid = '$id'";
$result = $db->query($query);

if ($result->num_rows === 0) {
    header('Location: customer_list.php');
    exit();
}

$customer = $result->fetch_assoc();

if (isset($_POST['update'])) {
    // Retrieve the form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $adress = $_POST['adress'];
    $zipcode = $_POST['zipcode'];
    $phonenumber = $_POST['phonenumber'];

    // Validate the form data (you can add your own validation logic here)

    // Update the customer in the database
    $query = "UPDATE customer SET firstname = '$firstname', lastname = '$lastname', adress = '$adress', zipcode = '$zipcode', phonenumber = '$phonenumber' WHERE customerid = '$id'";

    if ($db->query($query) === true) {
        $success = 'Customer updated successfully!';
    } else {
        $error = 'Error updating customer: ' . $db->error;
    }
}

$db->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Customer</title>
</head>

<body>
    <h2>Edit Customer</h2>
    <a href="customer_list.php">Back to Customer List</a><br>

    <?php if (isset($success)) { ?>
        <p><?php echo $success; ?></p>
    <?php } ?>

    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST" action="edit_customer.php?id=<?php echo $id; ?>">
        <label>Firstname:</label>
        <input type="text" name="firstname" value="<?php echo $customer['firstname']; ?>" required><br>

        <label>Lastname:</label>
        <input type="text" name="lastname" value="<?php echo $customer['lastname']; ?>" required><br>

        <label>Adress:</label>
        <input type="text" name="adress" value="<?php echo $customer['adress']; ?>" required><br>

        <label>Zipcode:</label>
        <input type="text" name="zipcode" value="<?php echo $customer['zipcode']; ?>" required><br>

        <label>Phonenumber:</label>
        <input type="text" name="phonenumber" value="<?php echo $customer['phonenumber']; ?>" required><br>

        <input type="submit" name="update" value="Update Customer">
    </form>
</body>

</html>