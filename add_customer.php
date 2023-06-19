<?php
session_start();

class CustomerAdder
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

    public function addCustomer($data)
    {
        // Retrieve the form data
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $address = $data['address'];
        $zipcode = $data['zipcode'];
        $phonenumber = $data['phonenumber'];

        // Validate the form data (you can add your own validation logic here)

        // Insert the customer into the database
        $query = "INSERT INTO customer (firstname, lastname, address, zipcode, phonenumber) VALUES ('$firstname', '$lastname', '$address', '$zipcode', '$phonenumber')";

        if ($this->db->query($query) === true) {
            return 'Customer added successfully!';
        } else {
            return 'Error adding customer: ' . $this->db->error;
        }
    }

    public function closeDatabase()
    {
        $this->db->close();
    }
}

$adder = new CustomerAdder();

if (!$adder->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['add'])) {
    $message = $adder->addCustomer($_POST);
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

    <?php if (isset($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST" action="add_customer.php">
        <label>Firstname:</label>
        <input type="text" name="firstname" required><br>

        <label>Lastname:</label>
        <input type="text" name="lastname" required><br>

        <label>Address:</label>
        <input type="text" name="address" required><br>

        <label>Zipcode:</label>
        <input type="text" name="zipcode" required><br>

        <label>Phonenumber:</label>
        <input type="text" name="phonenumber" required><br>

        <input type="submit" name="add" value="Add Customer">
    </form>

    <?php
    $adder->closeDatabase();
    ?>
</body>

</html>