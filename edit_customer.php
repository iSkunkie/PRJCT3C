<?php
session_start();

class CustomerEditor
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

    public function getCustomer($id)
    {
        $query = "SELECT * FROM customer WHERE customerid = '$id'";
        $result = $this->db->query($query);

        if ($result->num_rows === 0) {
            return null;
        }

        return $result->fetch_assoc();
    }

    public function updateCustomer($id, $data)
    {
        // Retrieve the form data
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $address = $data['address'];
        $zipcode = $data['zipcode'];
        $phonenumber = $data['phonenumber'];

        // Validate the form data (you can add your own validation logic here)

        // Update the customer in the database
        $query = "UPDATE customer SET firstname = '$firstname', lastname = '$lastname', address = '$address', zipcode = '$zipcode', phonenumber = '$phonenumber' WHERE customerid = '$id'";

        if ($this->db->query($query) === true) {
            return 'Customer updated successfully!';
        } else {
            return 'Error updating customer: ' . $this->db->error;
        }
    }

    public function closeDatabase()
    {
        $this->db->close();
    }
}

$editor = new CustomerEditor();

if (!$editor->isLoggedIn()) {
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

$customer = $editor->getCustomer($id);

if (!$customer) {
    header('Location: customer_list.php');
    exit();
}

if (isset($_POST['update'])) {
    $message = $editor->updateCustomer($id, $_POST);
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Customer</title>
</head>

<body>
    <h2>Edit Customer</h2>
    <a href="customer_list.php">Back to Customer List</a><br>

    <?php if (isset($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST" action="edit_customer.php?id=<?php echo $id; ?>">
        <label>Firstname:</label>
        <input type="text" name="firstname" value="<?php echo $customer['firstname']; ?>" required><br>

        <label>Lastname:</label>
        <input type="text" name="lastname" value="<?php echo $customer['lastname']; ?>" required><br>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo $customer['address']; ?>" required><br>

        <label>Zipcode:</label>
        <input type="text" name="zipcode" value="<?php echo $customer['zipcode']; ?>" required><br>

        <label>Phonenumber:</label>
        <input type="text" name="phonenumber" value="<?php echo $customer['phonenumber']; ?>" required><br>

        <input type="submit" name="update" value="Update Customer">
    </form>

    <?php
    $editor->closeDatabase();
    ?>
</body>

</html>