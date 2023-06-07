<?php
session_start();

require_once 'Auth.php';

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'garage2';

$auth = new Auth($host, $username, $password, $database);

if ($auth->isLoggedIn()) {
    header('Location: admin_panel.php');
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($auth->login($username, $password)) {
        header('Location: admin_panel.php');
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}

header('Location: login.php');
exit();
