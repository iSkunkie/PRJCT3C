<?php
session_start();

class CustomerDeleter
{
    private $db;

    public function __construct()
    {
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'garage2';

        $this->db = new mysqli($host, $username, $password, $database);

        if ($this->db->connect_error) {
            die('Connection failed: ' . $this->db->connect_error);
        }
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['username']);
    }

    public function deleteCustomer($id)
    {
        $query = "DELETE FROM customer WHERE customerid = '$id'";

        if ($this->db->query($query) === true) {
            return 'Customer deleted successfully!';
        } else {
            return 'Error deleting customer: ' . $this->db->error;
        }
    }

    public function closeDatabase()
    {
        $this->db->close();
    }
}

$deleter = new CustomerDeleter();

if (!$deleter->isLoggedIn()) {
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

$message = $deleter->deleteCustomer($id);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Customer</title>
</head>

<body>
    <h2>Delete Customer</h2>
    <a href="customer_list.php">Back to Customer List</a><br>

    <?php if (isset($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>

    <?php
    $deleter->closeDatabase();
    ?>
</body>

</html>