<?php
require_once "Database.php";
require_once "../fpdf/fpdf.php";
session_start();

class Members extends Database
{
    public function __construct($first_name, $last_name, $email, $phone_number, $photo_path, $training_plan_id)
    {
        $db = new Database();
        $database = $db->database;
       
        $sql = $database->query("INSERT INTO members (first_name, last_name, email, phone_number, photo_path, training_plan_id) VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$photo_path', '$training_plan_id')");

        $member_id = $database->insert_id;

        
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Cell(40, 10, 'Access Card');
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Member ID: ' . $member_id);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Name: ' . $first_name . " " . $last_name);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Email: ' . $email);
        $pdf->Ln();

        
        $directory = $_SERVER['DOCUMENT_ROOT'] . '/gym_oop/access_cards/';
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = $directory . 'access_card_' . $member_id . '.pdf';
        $pdf->Output('F', $filename);

        
        $relative_path = '/gym_oop/access_cards/access_card_' . $member_id . '.pdf';

        
        $stmt = $database->prepare("UPDATE members SET access_card_pdf_path = ? WHERE member_id = ?");
        $stmt->bind_param("si", $relative_path, $member_id);
        $stmt->execute();

        $_SESSION['success_message'] = "Clan teretane uspesno dodat";
        header('Location: ../dashboard.php');
        exit();
    }
}
