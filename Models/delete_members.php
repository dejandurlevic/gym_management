<?php

require_once 'Database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
$member_id_delete = $_POST['member_id'];

$db = new Database();
$database = $db->database;

$result = $database->query("DELETE FROM members WHERE member_id = $member_id_delete");
$message = "";

if($result){
    $message = "Clan je obrisan";
}else{
    $message = "Clan nije obrisan";
}
$_SESSION['success_message'] = $message;
header('Location: ../members.php');
exit();
}