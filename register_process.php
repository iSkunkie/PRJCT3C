<?php
session_start();

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

header('Location: register.php');
exit();
