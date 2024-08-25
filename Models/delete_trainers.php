<?php

require_once 'Database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
$trainer_id_delete = $_POST['trainer_id'];

$db = new Database();
$database = $db->database;

$result = $database->query("DELETE FROM trainers WHERE trainer_id = $trainer_id_delete");
$message = "";

if($result){
    $message = "Trener je obrisan";
}else{
    $message = "Trener nije obrisan";
}
$_SESSION['success_message'] = $message;
header('Location: ../trainers.php');
exit();
}