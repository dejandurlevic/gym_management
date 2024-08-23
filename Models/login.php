<?php
session_start();

require_once 'Database.php';
require_once 'AdminUser.php';

if (!isset($_POST['username']) || empty($_POST['username'])) {
    die('You must forward username');
}
if (!isset($_POST['password']) || empty($_POST['password'])) {
    die('You must forward password');
}

$username = $_POST['username'];
$password = $_POST['password'];

// We create an instance of the Database class
$db = new Database();
$database = $db->database;

$result = $database->query("SELECT * FROM admins WHERE username = '$username'");

if($result->num_rows > 0){
    $row = $result->fetch_assoc(); // We get the results as an associative array
    $hashedPassword = $row['password']; // Password from the database

    // Create an instance of the AdminUser class
    $adminUser = new AdminUser($username, $hashedPassword);

    // We are checking whether the entered password is correct
    if($adminUser->verifyPassword($password)){
        $_SESSION['admin_id'] = $row['admin_id'];
        echo "The password is correct";
        header('Location: ../dashboard.php'); // Redirection to dashboard
        exit(); 
    } else {
        $_SESSION['error'] = "The password is not correct";
        header('Location: ../index.php');
        exit(); 
    }
    
} else {
    $_SESSION['error'] = "The username is not correct";
    header('Location: ../index.php');
    exit(); 
}

