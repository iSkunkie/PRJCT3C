<?php

class Auth
{
    private $db;

    public function __construct($host, $username, $password, $database)
    {
        $this->db = new mysqli($host, $username, $password, $database);

        if ($this->db->connect_error) {
            die('Connection failed: ' . $this->db->connect_error);
        }
    }

    public function register($username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare('INSERT INTO accounts (username, password) VALUES (?, ?)');
        $stmt->bind_param('ss', $username, $hashedPassword);
        $stmt->execute();
        $stmt->close();
    }

    public function login($username, $password)
    {
        $stmt = $this->db->prepare('SELECT password FROM accounts WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['username'] = $username;
            return true;
        }

        return false;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['username']);
    }

    public function logout()
    {
        unset($_SESSION['username']);
        session_destroy();
    }
}
