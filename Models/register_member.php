<?php


if (!isset($_POST['first_name']) || empty($_POST['first_name'])) {
    die('You must forward first name');
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
if (!isset($_POST['training_plan_id']) || empty($_POST['training_plan_id'])) {
    die('You must chose training plan');
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$photo_path = $_POST['photo_path'];
$training_plan_id = $_POST['training_plan_id'];

require_once "Members.php";

$member = new Members($first_name, $last_name, $email, $phone_number, $photo_path, $training_plan_id);







