<?php
session_start();
require_once('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: patient_login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: medical_history.php");
    exit;
}

$prescription_id = $_GET['id'];
$patient_id = $_SESSION['user_id'];

try {
    // Get prescription details
    $stmt = $con->prepare("
        SELECT p.*, d.full_name as doctor_name, d.qualification, d.license_number,
               pt.full_name as patient_name, pt.date_of_birth, pt.gender
        FROM prescriptions p 
        JOIN doctors d ON p.doctor_id = d.doctor_id 
        JOIN patients pt ON p.patient_id = pt.patient_id
        WHERE p.prescription_id = ? AND p.patient_id = ?
    ");
    $stmt->bind_param("ii", $prescription_id, $patient_id);
    $stmt->execute();
    $prescription = $stmt->get_result()->fetch_assoc();

    if (!$prescription) {
        header("Location: medical_history.php");
        exit;
    }

    // Set headers for PDF download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="prescription_' . $prescription_id . '.pdf"');

    // Create PDF content
    $html = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .header { text-align: center; margin-bottom: 20px; }
            .section { margin: 15px 0; }
            .medication { margin: 10px 0; }
            .footer { margin-top: 30px; text-align: center; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Medical Prescription</h1>
        </div>
        
        <div class="section">
            <h3>Patient Information</h3>
            <p>Name: ' . htmlspecialchars($prescription['patient_name']) . '</p>
            <p>Date of Birth: ' . date('F j, Y', strtotime($prescription['date_of_birth'])) . '</p>
            <p>Gender: ' . htmlspecialchars($prescription['gender']) . '</p>
        </div>

        <div class="section">
            <h3>Prescription Details</h3>
            <p>Date: ' . date('F j, Y', strtotime($prescription['prescribed_date'])) . '</p>
            <p>Valid Until: ' . date('F j, Y', strtotime($prescription['valid_until'])) . '</p>
        </div>

        <div class="section">
            <h3>Medications</h3>';
    
    $medications = json_decode($prescription['medications'], true);
    foreach ($medications as $med) {
        $html .= '
            <div class="medication">
                <p><strong>' . htmlspecialchars($med['name']) . '</strong></p>
                <p>Dosage: ' . htmlspecialchars($med['dosage']) . '</p>
                <p>Frequency: ' . htmlspecialchars($med['frequency']) . '</p>
            </div>';
    }

    $html .= '
        </div>

        <div class="section">
            <h3>Doctor Information</h3>
            <p>Name: Dr. ' . htmlspecialchars($prescription['doctor_name']) . '</p>
            <p>Qualification: ' . htmlspecialchars($prescription['qualification']) . '</p>
            <p>License Number: ' . htmlspecialchars($prescription['license_number']) . '</p>
        </div>';

    if ($prescription['notes']) {
        $html .= '
        <div class="section">
            <h3>Additional Notes</h3>
            <p>' . htmlspecialchars($prescription['notes']) . '</p>
        </div>';
    }

    $html .= '
        <div class="footer">
            <p>This is a digitally generated prescription. No signature required.</p>
            <p>Generated on: ' . date('F j, Y H:i:s') . '</p>
        </div>
    </body>
    </html>';

    // Convert HTML to PDF using TCPDF or similar library
    require_once('tcpdf/tcpdf.php');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator('WeCare');
    $pdf->SetAuthor('WeCare System');
    $pdf->SetTitle('Prescription #' . $prescription_id);
    $pdf->AddPage();
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('prescription_' . $prescription_id . '.pdf', 'D');

} catch (Exception $e) {
    error_log("Error in download_prescription.php: " . $e->getMessage());
    header("Location: medical_history.php");
    exit;
}
?> 