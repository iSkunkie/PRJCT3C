<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['add'])) {
    // Retrieve the form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $adress = $_POST['adress'];
    $zipcode = $_POST['zipcode'];
    $phonenumber = $_POST['phonenumber'];

    // Validate the form data (you can add your own validation logic here)

    // Insert the customer into the database
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'garage2';

    $db = new mysqli($host, $username, $password, $database);

    if ($db->connect_error) {
        die('Connection failed: ' . $db->connect_error);
    }

    $query = "INSERT INTO customer (firstname, lastname, adress, zipcode, phonenumber) VALUES ('$firstname', '$lastname', '$adress', '$zipcode', '$phonenumber')";

    if ($db->query($query) === true) {
        $success = 'Customer added successfully!';
    } else {
        $error = 'Error adding customer: ' . $db->error;
    }

    $db->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Customer</title>
</head>

<body>
    <h2>Add Customer</h2>
    <a href="customer_list.php">Back to Customer List</a><br>

    <?php if (isset($success)) { ?>
        <p><?php echo $success; ?></p>
    <?php } ?>

    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST" action="add_customer.php">
        <label>Firstname:</label>
        <input type="text" name="firstname" required><br>

        <label>Lastname:</label>
        <input type="text" name="lastname" required><br>

        <label>Adress:</label>
        <input type="text" name="adress" required><br>

        <label>Zipcode:</label>
        <input type="text" name="zipcode" required><br>

        <label>Phonenumber:</label>
        <input type="text" name="phonenumber" required><br>

        <input type="submit" name="add" value="Add Customer">
    </form>
</body>

</html>