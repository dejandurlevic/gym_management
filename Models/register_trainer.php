<?php
require_once 'Database.php';
session_start();

if (!isset($_POST['fullName']) || empty($_POST['fullName'])) {
    die('You must forward full name');
}
if (!isset($_POST['last_name']) || empty($_POST['last_name'])) {
    die('You must forward last name');
}

if (!isset($_POST['email']) || empty($_POST['email'])) {
    die('You must forward email');
}
if (!isset($_POST['phone_number']) || empty($_POST['phone_number'])) {
    die('You must forward phone number');
}


$first_name = $_POST['fullName'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];


$db = new Database();
$database = $db->database;

$result = $database->query("INSERT INTO trainers (fullName, last_name, email, phone_number) VALUES ('$first_name', '$last_name', '$email', '$phone_number')");
$message = "";

if($result){
    $message = "Trener uspesno registrovan";
}else{
    $message = "Trener nije registrovan";
}
$_SESSION['success_message'] = $message;
header('Location: ../trainers.php');
exit();
