<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Fetch the customers from the database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'garage2';

$db = new mysqli($host, $username, $password, $database);

if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

// Search functionality
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT * FROM customer WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%'";
} else {
    $query = 'SELECT * FROM customer';
}

$result = $db->query($query);

$customers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}

$db->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Customer List</title>
</head>

<body>
    <h2>Customer List</h2>
    <a href="admin_panel.php">Back to Admin Panel</a><br>
    <a href="add_customer.php">Add New Customer</a><br>

    <!-- Search form -->
    <form method="GET" action="customer_list.php">
        <input type="text" name="search" placeholder="Search by name" value="<?php echo $search; ?>">
        <input type="submit" value="Search">
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Address</th>
            <th>Zipcode</th>
            <th>Phonenumber</th>
            <th>Action</th>
        </tr>
        <?php foreach ($customers as $customer) { ?>
            <tr>
                <td><?php echo $customer['customerid']; ?></td>
                <td><?php echo $customer['firstname']; ?></td>
                <td><?php echo $customer['lastname']; ?></td>
                <td><?php echo $customer['adress']; ?></td>
                <td><?php echo $customer['zipcode']; ?></td>
                <td><?php echo $customer['phonenumber']; ?></td>
                <td>
                    <a href="edit_customer.php?id=<?php echo $customer['customerid']; ?>">Edit</a>
                    <a href="delete_customer.php?id=<?php echo $customer['customerid']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>