<?php
session_start();
require_once('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: patient_login.php");
    exit;
}

$patient_id = $_SESSION['user_id'];

try {
    // Get patient details
    $stmt = $con->prepare("SELECT * FROM patients WHERE patient_id = ?");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $patient = $stmt->get_result()->fetch_assoc();

    // Get all medical records
    $stmt = $con->prepare("
        SELECT m.*, d.full_name as doctor_name, d.qualification, d.license_no
        FROM medical_records m 
        JOIN doctors d ON m.doctor_id = d.doctor_id 
        WHERE m.patient_id = ? 
        ORDER BY m.record_date DESC
    ");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Set headers for PDF download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="all_medical_records.pdf"');

    // Create PDF content
    $html = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .header { text-align: center; margin-bottom: 20px; }
            .section { margin: 15px 0; border-bottom: 1px solid #ccc; padding-bottom: 15px; }
            .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
            .record-date { color: #666; font-size: 14px; }
            .doctor-info { color: #333; font-size: 14px; }
            .diagnosis { margin: 10px 0; }
            .treatment { margin: 10px 0; }
            .notes { margin: 10px 0; font-style: italic; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Complete Medical Records</h1>
            <h2>Patient Information</h2>
            <p>Name: ' . htmlspecialchars($patient['full_name']) . '</p>
            <p>Date of Birth: ' . date('F j, Y', strtotime($patient['date_of_birth'])) . '</p>
            <p>Gender: ' . htmlspecialchars($patient['gender']) . '</p>
        </div>';

    if (empty($records)) {
        $html .= '<div class="section"><p>No medical records found.</p></div>';
    } else {
        foreach ($records as $record) {
            $html .= '
            <div class="section">
                <div class="record-date">
                    <strong>Date:</strong> ' . date('F j, Y', strtotime($record['record_date'])) . '
                </div>
                <div class="doctor-info">
                    <strong>Doctor:</strong> Dr. ' . htmlspecialchars($record['doctor_name']) . '<br>
                    <strong>Qualification:</strong> ' . htmlspecialchars($record['qualification']) . '<br>
                    <strong>License Number:</strong> ' . htmlspecialchars($record['license_no']) . '
                </div>
                <div class="diagnosis">
                    <strong>Diagnosis:</strong><br>
                    ' . nl2br(htmlspecialchars($record['diagnosis'])) . '
                </div>
                <div class="treatment">
                    <strong>Treatment:</strong><br>
                    ' . nl2br(htmlspecialchars($record['treatment'])) . '
                </div>';
            
            if ($record['notes']) {
                $html .= '
                <div class="notes">
                    <strong>Additional Notes:</strong><br>
                    ' . nl2br(htmlspecialchars($record['notes'])) . '
                </div>';
            }

            if ($record['next_followup']) {
                $html .= '
                <div class="followup">
                    <strong>Next Follow-up:</strong> ' . date('F j, Y', strtotime($record['next_followup'])) . '
                </div>';
            }

            $html .= '</div>';
        }
    }

    $html .= '
        <div class="footer">
            <p>This is a digitally generated medical record. No signature required.</p>
            <p>Generated on: ' . date('F j, Y H:i:s') . '</p>
        </div>
    </body>
    </html>';

    // Convert HTML to PDF using TCPDF
    require_once('tcpdf/tcpdf.php');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator('WeCare');
    $pdf->SetAuthor('WeCare System');
    $pdf->SetTitle('Complete Medical Records - ' . $patient['full_name']);
    
    // Set margins
    $pdf->SetMargins(15, 15, 15);
    
    // Add a page
    $pdf->AddPage();
    
    // Write HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Output PDF
    $pdf->Output('all_medical_records.pdf', 'D');

} catch (Exception $e) {
    error_log("Error in download_records.php: " . $e->getMessage());
    header("Location: patient_dashboard.php?error=download_failed");
    exit;
}
?> 