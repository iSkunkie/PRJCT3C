<?php
session_start();

class CustomerList
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

    public function getCustomers($search = '')
    {
        $customers = [];

        if (!empty($search)) {
            $query = "SELECT * FROM customer WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%'";
        } else {
            $query = 'SELECT * FROM customer';
        }

        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
        }

        return $customers;
    }

    public function closeDatabase()
    {
        $this->db->close();
    }
}

$crud = new CustomerList();

if (!$crud->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

$customers = $crud->getCustomers($search);

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

    <?php
    $crud->closeDatabase();
    ?>
</body>

</html>