<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once('config.php');

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

// At the top of the file, after session_start():
$active_tab = isset($_POST['active_tab']) ? $_POST['active_tab'] : 'patients';

// Handle Delete Operations
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'delete_patient' && isset($_POST['patient_id'])) {
        $patient_id = (int)$_POST['patient_id'];
        
        try {
            // First check if patient has any appointments
            $check_query = "SELECT COUNT(*) as count FROM appointments WHERE patient_id = ?";
            $check_stmt = $con->prepare($check_query);
            $check_stmt->bind_param("i", $patient_id);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                $error_message = "Cannot delete patient with existing appointments";
            } else {
                // Delete the patient
                $delete_query = "DELETE FROM patients WHERE patient_id = ?";
                $stmt = $con->prepare($delete_query);
                $stmt->bind_param("i", $patient_id);
                
                if ($stmt->execute()) {
                    $success_message = "Patient deleted successfully!";
                } else {
                    $error_message = "Error deleting patient!";
                }
            }
        } catch (Exception $e) {
            $error_message = $e->getMessage();
        }
    }
    
    if ($_POST['action'] === 'delete_doctor' && isset($_POST['doctor_id'])) {
        $doctor_id = (int)$_POST['doctor_id'];
        
        try {
            // First check if doctor has any appointments
            $check_query = "SELECT COUNT(*) as count FROM appointments WHERE doctor_id = ?";
            $check_stmt = $con->prepare($check_query);
            $check_stmt->bind_param("i", $doctor_id);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                throw new Exception("Cannot delete doctor with existing appointments");
            }
            
            // Delete the doctor
            $delete_query = "DELETE FROM doctors WHERE doctor_id = ?";
            $stmt = $con->prepare($delete_query);
            $stmt->bind_param("i", $doctor_id);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("Error deleting doctor");
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }
}

// Handle Add Operations
if (isset($_POST['add_patient'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        // Check if email already exists
        $check_email = $con->prepare("SELECT COUNT(*) FROM patients WHERE email = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $check_email->bind_result($email_count);
        $check_email->fetch();
        $check_email->close();

        if ($email_count > 0) {
            throw new Exception("A patient with this email already exists.");
        }

        $add_query = "INSERT INTO patients (full_name, email, phone, password) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($add_query);
        $stmt->bind_param("ssss", $full_name, $email, $phone, $password);
        
        if ($stmt->execute()) {
            $success_message = "Patient added successfully!";
        } else {
            throw new Exception("Error adding patient: " . $stmt->error);
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

if (isset($_POST['add_doctor'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $specialization = $_POST['specialization'];
    $license_no = $_POST['license_no'];
    $qualification = $_POST['qualification'];
    $experience = $_POST['experience'];
    $phone = $_POST['phone'] ?? null;
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        // Check if email already exists
        $check_email = $con->prepare("SELECT COUNT(*) FROM doctors WHERE email = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $check_email->bind_result($email_count);
        $check_email->fetch();
        $check_email->close();

        if ($email_count > 0) {
            throw new Exception("A doctor with this email already exists.");
        }

        // Check if license number already exists
        $check_license = $con->prepare("SELECT COUNT(*) FROM doctors WHERE license_no = ?");
        $check_license->bind_param("s", $license_no);
        $check_license->execute();
        $check_license->bind_result($license_count);
        $check_license->fetch();
        $check_license->close();

        if ($license_count > 0) {
            throw new Exception("A doctor with this license number already exists.");
        }

        $add_query = "INSERT INTO doctors (full_name, email, specialization, license_no, qualification, experience, phone, password, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $stmt = $con->prepare($add_query);
        $stmt->bind_param("ssssssis", $full_name, $email, $specialization, $license_no, $qualification, $experience, $phone, $password);
        
        if ($stmt->execute()) {
            $success_message = "Doctor added successfully!";
        } else {
            throw new Exception("Error adding doctor: " . $stmt->error);
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Handle Edit Operations
if (isset($_POST['update_patient'])) {
    $id = $_POST['edit_patient_id'];
    $name = $_POST['edit_full_name'];
    $email = $_POST['edit_email'];
    $phone = $_POST['edit_phone'];
    $password = $_POST['edit_password'];

    try {
        // Check if email already exists for other patients
        $check_email = $con->prepare("SELECT COUNT(*) FROM patients WHERE email = ? AND patient_id != ?");
        $check_email->bind_param("si", $email, $id);
        $check_email->execute();
        $check_email->bind_result($email_count);
        $check_email->fetch();
        $check_email->close();

        if ($email_count > 0) {
            throw new Exception("A patient with this email already exists.");
        }

        if (!empty($password)) {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $update_query = "UPDATE patients SET full_name=?, email=?, phone=?, password=? WHERE patient_id=?";
            $stmt = $con->prepare($update_query);
            $stmt->bind_param("ssssi", $name, $email, $phone, $password_hashed, $id);
        } else {
            $update_query = "UPDATE patients SET full_name=?, email=?, phone=? WHERE patient_id=?";
            $stmt = $con->prepare($update_query);
            $stmt->bind_param("sssi", $name, $email, $phone, $id);
        }

        if ($stmt->execute()) {
            $success_message = "Patient updated successfully!";
        } else {
            throw new Exception("Error updating patient: " . $stmt->error);
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

if (isset($_POST['update_doctor'])) {
    $id = $_POST['edit_doctor_id'];
    $name = $_POST['edit_doctor_full_name'];
    $email = $_POST['edit_doctor_email'];
    $specialization = $_POST['edit_doctor_specialization'];
    $license_no = $_POST['edit_doctor_license_no'];
    $qualification = $_POST['edit_doctor_qualification'];
    $experience = $_POST['edit_doctor_experience'];
    $phone = $_POST['edit_doctor_phone'];
    $password = $_POST['edit_doctor_password'];

    try {
        // Check if email already exists for other doctors
        $check_email = $con->prepare("SELECT COUNT(*) FROM doctors WHERE email = ? AND doctor_id != ?");
        $check_email->bind_param("si", $email, $id);
        $check_email->execute();
        $check_email->bind_result($email_count);
        $check_email->fetch();
        $check_email->close();

        if ($email_count > 0) {
            throw new Exception("A doctor with this email already exists.");
        }

        // Check if license number already exists for other doctors
        $check_license = $con->prepare("SELECT COUNT(*) FROM doctors WHERE license_no = ? AND doctor_id != ?");
        $check_license->bind_param("si", $license_no, $id);
        $check_license->execute();
        $check_license->bind_result($license_count);
        $check_license->fetch();
        $check_license->close();

        if ($license_count > 0) {
            throw new Exception("A doctor with this license number already exists.");
        }

        if (!empty($password)) {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $update_query = "UPDATE doctors SET full_name=?, email=?, specialization=?, license_no=?, qualification=?, experience=?, phone=?, password=? WHERE doctor_id=?";
            $stmt = $con->prepare($update_query);
            $stmt->bind_param("ssssssisi", $name, $email, $specialization, $license_no, $qualification, $experience, $phone, $password_hashed, $id);
        } else {
            $update_query = "UPDATE doctors SET full_name=?, email=?, specialization=?, license_no=?, qualification=?, experience=?, phone=? WHERE doctor_id=?";
            $stmt = $con->prepare($update_query);
            $stmt->bind_param("sssssssi", $name, $email, $specialization, $license_no, $qualification, $experience, $phone, $id);
        }

        if ($stmt->execute()) {
            $success_message = "Doctor updated successfully!";
        } else {
            throw new Exception("Error updating doctor: " . $stmt->error);
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Handle Doctor Verification
if (isset($_POST['verify_doctor'])) {
    $doctor_id = $_POST['doctor_id'];
    $update_query = "UPDATE doctors SET is_verified = 1 WHERE doctor_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("i", $doctor_id);
    if ($stmt->execute()) {
        $success_message = "Doctor verified successfully!";
    } else {
        $error_message = "Error verifying doctor!";
    }
}

// Handle Doctor Status Toggle
if (isset($_POST['action']) && $_POST['action'] === 'toggle_status' && isset($_POST['doctor_id'])) {
    $doctor_id = (int)$_POST['doctor_id'];
    
    try {
        // Get current status
        $check_query = "SELECT is_active FROM doctors WHERE doctor_id = ?";
        $check_stmt = $con->prepare($check_query);
        $check_stmt->bind_param("i", $doctor_id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $row = $result->fetch_assoc();
        $current_status = $row['is_active'];
        
        // Toggle status
        $new_status = $current_status ? 0 : 1;
        
        // Update status
        $update_query = "UPDATE doctors SET is_active = ? WHERE doctor_id = ?";
        $update_stmt = $con->prepare($update_query);
        $update_stmt->bind_param("ii", $new_status, $doctor_id);
        
        if ($update_stmt->execute()) {
            $success_message = "Doctor status updated successfully!";
            // Redirect back to admin dashboard with doctors tab active
            header("Location: admin_dashboard.php?active_tab=doctors");
            exit();
        } else {
            throw new Exception("Error updating doctor status: " . $update_stmt->error);
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Handle Patient Status Toggle
if (isset($_POST['toggle_patient_status'])) {
    $patient_id = $_POST['patient_id'];
    $current_status = $_POST['current_status'];
    $new_status = $current_status ? 0 : 1;
    
    $update_query = "UPDATE patients SET is_active = ? WHERE patient_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("ii", $new_status, $patient_id);
    if ($stmt->execute()) {
        $success_message = "Patient status updated successfully!";
    } else {
        $error_message = "Error updating patient status!";
    }
}

// Handle Doctor Profile Update
if (isset($_POST['update_doctor_profile'])) {
    $doctor_id = $_POST['doctor_id'];
    $bio = $_POST['bio'];
    $consultation_fee = $_POST['consultation_fee'];
    $available_days = implode(',', $_POST['available_days']);
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $update_query = "UPDATE doctors SET bio = ?, consultation_fee = ?, available_days = ?, start_time = ?, end_time = ? WHERE doctor_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("sdsssi", $bio, $consultation_fee, $available_days, $start_time, $end_time, $doctor_id);
    if ($stmt->execute()) {
        $success_message = "Doctor profile updated successfully!";
    } else {
        $error_message = "Error updating doctor profile!";
    }
}

// Handle Patient Profile Update
if (isset($_POST['update_patient_profile'])) {
    $patient_id = $_POST['patient_id'];
    $medical_history = $_POST['medical_history'];
    $allergies = $_POST['allergies'];
    $emergency_contact = $_POST['emergency_contact'];

    $update_query = "UPDATE patients SET medical_history = ?, allergies = ?, emergency_contact = ? WHERE patient_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("sssi", $medical_history, $allergies, $emergency_contact, $patient_id);
    if ($stmt->execute()) {
        $success_message = "Patient profile updated successfully!";
    } else {
        $error_message = "Error updating patient profile!";
    }
}

// Fetch all patients
$patients_query = "SELECT * FROM patients ORDER BY patient_id DESC";
$patients_result = $con->query($patients_query);

// Fetch all doctors
$doctors_query = "SELECT * FROM doctors ORDER BY doctor_id DESC";
$doctors_result = $con->query($doctors_query);

// Fetch all specializations
$specializations_query = "SELECT * FROM specializations ORDER BY name";
$specializations_result = $con->query($specializations_query);

// Fetch all appointments
$appointments_query = "SELECT a.*, p.full_name as patient_name, d.full_name as doctor_name 
                      FROM appointments a 
                      JOIN patients p ON a.patient_id = p.patient_id 
                      JOIN doctors d ON a.doctor_id = d.doctor_id 
                      ORDER BY a.appointment_date DESC";
$appointments_result = $con->query($appointments_query);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - WeCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/login.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* General Styles */
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Dashboard Cards */
        .dashboard-card {
            transition: transform 0.2s;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .dashboard-card .card-body {
            padding: 1.5rem;
        }
        .dashboard-card h5 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .dashboard-card h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
        }

        /* Navigation Tabs */
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 20px;
            background: white;
            padding: 0 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            padding: 15px 25px;
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
        }
        .nav-tabs .nav-link:hover {
            color: #007bff;
            background: none;
        }
        .nav-tabs .nav-link.active {
            color: #007bff;
            font-weight: bold;
            border: none;
            border-bottom: 3px solid #007bff;
        }
        .nav-tabs .nav-link i {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        /* Tables */
        .table-responsive {
            max-height: 600px;
            overflow-y: auto;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            background: white;
        }
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
            padding: 15px;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }
        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        /* Forms */
        .add-form {
            background: #ffffff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
            transform: translateY(-1px);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        .btn-sm {
            padding: 8px 15px;
            font-size: 0.85rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            padding: 20px;
        }
        .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: #2c3e50;
        }
        .card-body {
            padding: 25px;
        }

        /* Badges */
        .badge {
            padding: 8px 12px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .badge-info {
            background-color: #17a2b8;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Icons */
        .fas {
            margin-right: 8px;
        }

        /* Container */
        .container-fluid {
            padding: 30px;
        }

        /* Header */
        h1 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0;
            font-size: 2rem;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 20px;
        }
        .modal-body {
            padding: 25px;
        }
        .modal-footer {
            border-top: 1px solid #eee;
            padding: 20px;
        }

        /* Action Buttons Group */
        .action-buttons {
            display: flex;
            gap: 5px;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: nowrap;
            min-width: 120px;
        }
        .action-buttons .btn {
            padding: 6px 10px;
            min-width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .action-buttons .btn i {
            margin: 0;
            font-size: 14px;
        }
        .action-buttons form {
            margin: 0;
            display: inline-flex;
        }
        .action-buttons .btn-sm {
            padding: 6px 10px;
            font-size: 0.85rem;
        }
        .action-buttons .btn-danger,
        .action-buttons .btn-success,
        .action-buttons .btn-warning,
        .action-buttons .btn-info,
        .action-buttons .btn-primary {
            color: white;
        }
        .action-buttons .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Status Badges */
        .status-badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
            display: inline-block;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 15px;
            }
            .dashboard-card {
                margin-bottom: 15px;
            }
            .table-responsive {
                max-height: 400px;
            }
            .btn-sm {
                padding: 6px 10px;
            }
            .nav-tabs .nav-link {
                padding: 10px 15px;
            }
        }

        /* Custom Scrollbar */
        .table-responsive::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Switch Toggle Styles */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
            margin: 0;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #dc3545;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #28a745;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .switch-label {
            font-size: 12px;
            margin-left: 8px;
            color: #6c757d;
        }

        .switch-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1><i class="fas fa-user-shield"></i> Admin Dashboard</h1>
                    <a href="index.php" class="btn btn-danger btn-lg">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <?php if(isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_message); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white dashboard-card">
                    <div class="card-body">
                        <h5><i class="fas fa-users"></i> Total Patients</h5>
                        <h2><?php echo $patients_result->num_rows; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white dashboard-card">
                    <div class="card-body">
                        <h5><i class="fas fa-user-md"></i> Total Doctors</h5>
                        <h2><?php echo $doctors_result->num_rows; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white dashboard-card">
                    <div class="card-body">
                        <h5><i class="fas fa-calendar-check"></i> Total Appointments</h5>
                        <h2><?php echo $appointments_result->num_rows; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white dashboard-card">
                    <div class="card-body">
                        <h5><i class="fas fa-clock"></i> Today's Appointments</h5>
                        <h2><?php 
                            $today = date('Y-m-d');
                            $today_query = "SELECT COUNT(*) as count FROM appointments WHERE appointment_date = '$today'";
                            $today_result = $con->query($today_query);
                            echo $today_result->fetch_assoc()['count'];
                        ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Tabs -->
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_tab === 'patients' ? 'active' : ''; ?>" id="patients-tab" data-toggle="tab" href="#patients" role="tab">
                            <i class="fas fa-users"></i> Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_tab === 'doctors' ? 'active' : ''; ?>" id="doctors-tab" data-toggle="tab" href="#doctors" role="tab">
                            <i class="fas fa-user-md"></i> Doctors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_tab === 'appointments' ? 'active' : ''; ?>" id="appointments-tab" data-toggle="tab" href="#appointments" role="tab">
                            <i class="fas fa-calendar-check"></i> Appointments
                        </a>
                    </li>
                </ul>

                <div class="tab-content mt-3" id="dashboardTabsContent">
                    <!-- Patients Tab -->
                    <div class="tab-pane fade <?php echo $active_tab === 'patients' ? 'show active' : ''; ?>" id="patients" role="tabpanel">
                        <!-- Add Patient Form -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-user-plus"></i> Add New Patient</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <input type="hidden" name="active_tab" value="patients">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="tel" class="form-control" name="phone" placeholder="Phone" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="add_patient" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add Patient
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Patients Table -->
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                                <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                            <?php while($patient = $patients_result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $patient['patient_id']; ?></td>
                                                <td><?php echo $patient['full_name']; ?></td>
                                                <td><?php echo $patient['email']; ?></td>
                                                <td><?php echo $patient['phone']; ?></td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <button class="btn btn-info btn-sm" onclick="viewPatient(<?php echo $patient['patient_id']; ?>)" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPatientModal" 
                                                            onclick="fillEditPatientModal(
                                                                '<?php echo $patient['patient_id']; ?>',
                                                                '<?php echo htmlspecialchars($patient['full_name'], ENT_QUOTES); ?>',
                                                                '<?php echo htmlspecialchars($patient['email'], ENT_QUOTES); ?>',
                                                                '<?php echo htmlspecialchars($patient['phone'], ENT_QUOTES); ?>'
                                                            )" title="Edit Patient">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form method="POST" action="" style="display: inline;">
                                                            <input type="hidden" name="action" value="delete_patient">
                                                            <input type="hidden" name="patient_id" value="<?php echo $patient['patient_id']; ?>">
                                                            <input type="hidden" name="active_tab" value="patients">
                                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('Are you sure you want to delete this patient?')" title="Delete Patient">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                            </tbody>
                        </table>
                                </div>
                    </div>
                </div>
            </div>

                    <!-- Doctors Tab -->
                    <div class="tab-pane fade <?php echo $active_tab === 'doctors' ? 'show active' : ''; ?>" id="doctors" role="tabpanel">
                        <!-- Add Doctor Form -->
                        <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-user-md"></i> Add New Doctor</h5>
                    </div>
                    <div class="card-body">
                                <form method="POST" action="">
                                    <input type="hidden" name="active_tab" value="doctors">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="form-control" name="specialization" required>
                                                    <option value="">Select Specialization</option>
                                                    <?php while($spec = $specializations_result->fetch_assoc()): ?>
                                                        <option value="<?php echo htmlspecialchars($spec['name']); ?>">
                                                            <?php echo htmlspecialchars($spec['name']); ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="license_no" placeholder="License Number" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="qualification" placeholder="Qualification" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="experience" placeholder="Years of Experience" required min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="tel" class="form-control" name="phone" placeholder="Phone Number">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="add_doctor" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Add Doctor
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Doctors Table -->
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Specialization</th>
                                    <th>Status</th>
                                    <th>Verification</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                            <?php while($doctor = $doctors_result->fetch_assoc()): 
                                                // Set default values if not set
                                                $is_active = isset($doctor['is_active']) ? $doctor['is_active'] : 1;
                                                $is_verified = isset($doctor['is_verified']) ? $doctor['is_verified'] : 0;
                                            ?>
                                            <tr>
                                                <td><?php echo $doctor['doctor_id']; ?></td>
                                                <td><?php echo htmlspecialchars($doctor['full_name']); ?></td>
                                                <td><?php echo htmlspecialchars($doctor['email']); ?></td>
                                                <td><?php echo htmlspecialchars($doctor['specialization']); ?></td>
                                                <td>
                                                    <span class="badge <?php echo $is_active ? 'badge-success' : 'badge-danger'; ?>">
                                                        <?php echo $is_active ? 'Active' : 'Inactive'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge <?php echo $is_verified ? 'badge-success' : 'badge-warning'; ?>">
                                                        <?php echo $is_verified ? 'Verified' : 'Pending'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <button class="btn btn-info btn-sm" onclick="viewDoctor(<?php echo $doctor['doctor_id']; ?>)" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editDoctorModal" 
                                                            onclick="fillEditDoctorModal(
                                                                '<?php echo $doctor['doctor_id']; ?>',
                                                                '<?php echo htmlspecialchars($doctor['full_name'], ENT_QUOTES); ?>',
                                                                '<?php echo htmlspecialchars($doctor['email'], ENT_QUOTES); ?>',
                                                                '<?php echo htmlspecialchars($doctor['specialization'], ENT_QUOTES); ?>',
                                                                '<?php echo htmlspecialchars($doctor['license_no'], ENT_QUOTES); ?>',
                                                                '<?php echo htmlspecialchars($doctor['qualification'], ENT_QUOTES); ?>',
                                                                '<?php echo htmlspecialchars($doctor['experience'], ENT_QUOTES); ?>',
                                                                '<?php echo htmlspecialchars($doctor['phone'], ENT_QUOTES); ?>'
                                                            )" title="Edit Doctor">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <?php if (!$is_verified): ?>
                                                        <form method="POST" action="">
                                                            <input type="hidden" name="doctor_id" value="<?php echo $doctor['doctor_id']; ?>">
                                                            <input type="hidden" name="active_tab" value="doctors">
                                                            <button type="submit" name="verify_doctor" class="btn btn-success btn-sm" title="Verify Doctor">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <?php endif; ?>
                                                        <div class="switch-container" id="toggleContainer_<?php echo $doctor['doctor_id']; ?>">
                                                            <label class="switch" title="<?php echo $is_active ? 'Deactivate Doctor' : 'Activate Doctor'; ?>">
                                                                <input type="checkbox" <?php echo $is_active ? 'checked' : ''; ?> 
                                                                       onchange="toggleDoctorStatus(<?php echo $doctor['doctor_id']; ?>, this.checked)">
                                                                <span class="slider"></span>
                                                            </label>
                                                            <span class="switch-label" id="status_label_<?php echo $doctor['doctor_id']; ?>">
                                                                <?php echo $is_active ? 'Active' : 'Inactive'; ?>
                                                            </span>
                                                        </div>
                                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#doctorProfileModal" 
                                                            onclick="fillDoctorProfileModal(<?php echo $doctor['doctor_id']; ?>)" title="Profile Settings">
                                                            <i class="fas fa-user-md"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                            onclick="deleteDoctor(<?php echo $doctor['doctor_id']; ?>)" title="Delete Doctor">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                            </tbody>
                        </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Appointments Tab -->
                    <div class="tab-pane fade <?php echo $active_tab === 'appointments' ? 'show active' : ''; ?>" id="appointments" role="tabpanel">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-calendar-check"></i> All Appointments</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Patient</th>
                                                <th>Doctor</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            // Reset the appointments result pointer
                                            $appointments_result->data_seek(0);
                                            while($appointment = $appointments_result->fetch_assoc()): 
                                                // Format the date
                                                $appointment_date = date('d M Y', strtotime($appointment['appointment_date']));
                                                // Format the time
                                                $appointment_time = date('h:i A', strtotime($appointment['appointment_time']));
                                            ?>
                                            <tr>
                                                <td><?php echo $appointment['appointment_id']; ?></td>
                                                <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                                                <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                                                <td><?php echo $appointment_date; ?></td>
                                                <td><?php echo $appointment_time; ?></td>
                                                <td>
                                                    <?php
                                                    $status_class = '';
                                                    switch($appointment['status']) {
                                                        case 'Scheduled':
                                                            $status_class = 'badge-info';
                                                            break;
                                                        case 'Completed':
                                                            $status_class = 'badge-success';
                                                            break;
                                                        case 'Cancelled':
                                                            $status_class = 'badge-danger';
                                                            break;
                                                        default:
                                                            $status_class = 'badge-secondary';
                                                    }
                                                    ?>
                                                    <span class="badge <?php echo $status_class; ?>">
                                                        <?php echo htmlspecialchars($appointment['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <button class="btn btn-info btn-sm" onclick="viewAppointment(<?php echo $appointment['appointment_id']; ?>)" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-warning btn-sm" onclick="editAppointment(<?php echo $appointment['appointment_id']; ?>)" title="Edit Appointment">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form method="POST" action="" style="display: inline;">
                                                            <input type="hidden" name="action" value="delete_appointment">
                                                            <input type="hidden" name="appointment_id" value="<?php echo $appointment['appointment_id']; ?>">
                                                            <input type="hidden" name="active_tab" value="appointments">
                                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('Are you sure you want to delete this appointment?')" title="Delete Appointment">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Patient Modal -->
    <div class="modal fade" id="editPatientModal" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" id="editPatientForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_patient_id" id="edit_patient_id">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="edit_full_name" id="edit_full_name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="edit_email" id="edit_email" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="edit_phone" id="edit_phone" required>
                        </div>
                        <div class="form-group">
                            <label>New Password (leave blank to keep unchanged)</label>
                            <input type="password" class="form-control" name="edit_password" id="edit_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_patient" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Doctor Modal -->
    <div class="modal fade" id="editDoctorModal" tabindex="-1" role="dialog" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" id="editDoctorForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDoctorModalLabel">Edit Doctor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_doctor_id" id="edit_doctor_id">
                        <input type="hidden" name="active_tab" value="doctors">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="edit_doctor_full_name" id="edit_doctor_full_name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="edit_doctor_email" id="edit_doctor_email" required>
                        </div>
                        <div class="form-group">
                            <label>Specialization</label>
                            <select class="form-control" name="edit_doctor_specialization" id="edit_doctor_specialization" required>
                                <option value="">Select Specialization</option>
                                <?php 
                                $specializations_result->data_seek(0);
                                while($spec = $specializations_result->fetch_assoc()): 
                                ?>
                                    <option value="<?php echo htmlspecialchars($spec['name']); ?>">
                                        <?php echo htmlspecialchars($spec['name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>License Number</label>
                            <input type="text" class="form-control" name="edit_doctor_license_no" id="edit_doctor_license_no" required>
                        </div>
                        <div class="form-group">
                            <label>Qualification</label>
                            <input type="text" class="form-control" name="edit_doctor_qualification" id="edit_doctor_qualification" required>
                        </div>
                        <div class="form-group">
                            <label>Experience (Years)</label>
                            <input type="number" class="form-control" name="edit_doctor_experience" id="edit_doctor_experience" required min="0">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" class="form-control" name="edit_doctor_phone" id="edit_doctor_phone">
                        </div>
                        <div class="form-group">
                            <label>New Password (leave blank to keep unchanged)</label>
                            <input type="password" class="form-control" name="edit_doctor_password" id="edit_doctor_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_doctor" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Doctor Profile Modal -->
    <div class="modal fade" id="doctorProfileModal" tabindex="-1" role="dialog" aria-labelledby="doctorProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" id="doctorProfileForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="doctorProfileModalLabel">Doctor Profile Settings</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="doctor_id" id="profile_doctor_id">
                        <div class="form-group">
                            <label>Bio</label>
                            <textarea class="form-control" name="bio" id="doctor_bio" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Consultation Fee</label>
                            <input type="number" class="form-control" name="consultation_fee" id="consultation_fee" min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>Available Days</label>
                            <div class="row">
                                <?php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                foreach ($days as $day):
                                ?>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="available_days[]" value="<?php echo $day; ?>" id="day_<?php echo $day; ?>">
                                        <label class="custom-control-label" for="day_<?php echo $day; ?>"><?php echo $day; ?></label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="time" class="form-control" name="start_time" id="start_time">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="time" class="form-control" name="end_time" id="end_time">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_doctor_profile" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add View Patient Modal -->
    <div class="modal fade" id="viewPatientModal" tabindex="-1" role="dialog" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPatientModalLabel">Patient Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Basic Information</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name:</th>
                                    <td id="view_patient_name"></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td id="view_patient_email"></td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td id="view_patient_phone"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Medical Information</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Medical History:</th>
                                    <td id="view_patient_medical_history"></td>
                                </tr>
                                <tr>
                                    <th>Allergies:</th>
                                    <td id="view_patient_allergies"></td>
                                </tr>
                                <tr>
                                    <th>Emergency Contact:</th>
                                    <td id="view_patient_emergency_contact"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add View Doctor Modal -->
    <div class="modal fade" id="viewDoctorModal" tabindex="-1" role="dialog" aria-labelledby="viewDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDoctorModalLabel">Doctor Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Basic Information</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name:</th>
                                    <td id="view_doctor_name"></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td id="view_doctor_email"></td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td id="view_doctor_phone"></td>
                                </tr>
                                <tr>
                                    <th>Specialization:</th>
                                    <td id="view_doctor_specialization"></td>
                                </tr>
                                <tr>
                                    <th>License Number:</th>
                                    <td id="view_doctor_license"></td>
                                </tr>
                                <tr>
                                    <th>Qualification:</th>
                                    <td id="view_doctor_qualification"></td>
                                </tr>
                                <tr>
                                    <th>Experience:</th>
                                    <td id="view_doctor_experience"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Professional Information</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Status:</th>
                                    <td id="view_doctor_status"></td>
                                </tr>
                                <tr>
                                    <th>Verification:</th>
                                    <td id="view_doctor_verification"></td>
                                </tr>
                                <tr>
                                    <th>Bio:</th>
                                    <td id="view_doctor_bio"></td>
                                </tr>
                                <tr>
                                    <th>Consultation Fee:</th>
                                    <td id="view_doctor_fee"></td>
                                </tr>
                                <tr>
                                    <th>Available Days:</th>
                                    <td id="view_doctor_days"></td>
                                </tr>
                                <tr>
                                    <th>Working Hours:</th>
                                    <td id="view_doctor_hours"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add View Appointment Modal -->
    <div class="modal fade" id="viewAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="viewAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAppointmentModalLabel">Appointment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Appointment Information</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Appointment ID:</th>
                                    <td id="view_appointment_id"></td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td id="view_appointment_date"></td>
                                </tr>
                                <tr>
                                    <th>Time:</th>
                                    <td id="view_appointment_time"></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td id="view_appointment_status"></td>
                                </tr>
                                <tr>
                                    <th>Reason:</th>
                                    <td id="view_appointment_reason"></td>
                                </tr>
                                <tr>
                                    <th>Notes:</th>
                                    <td id="view_appointment_notes"></td>
                                </tr>
                                <tr>
                                    <th>Preferred Communication:</th>
                                    <td id="view_appointment_communication"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Patient & Doctor Information</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Patient Name:</th>
                                    <td id="view_patient_name"></td>
                                </tr>
                                <tr>
                                    <th>Patient Phone:</th>
                                    <td id="view_patient_phone"></td>
                                </tr>
                                <tr>
                                    <th>Doctor Name:</th>
                                    <td id="view_doctor_name"></td>
                                </tr>
                                <tr>
                                    <th>Doctor Phone:</th>
                                    <td id="view_doctor_phone"></td>
                                </tr>
                                <tr>
                                    <th>Specialization:</th>
                                    <td id="view_doctor_specialization"></td>
                                </tr>
                                <tr>
                                    <th>License Number:</th>
                                    <td id="view_doctor_license"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to handle patient actions
        function viewPatient(id) {
            // Fetch patient details using AJAX
            $.ajax({
                url: 'get_patient_details.php',
                type: 'POST',
                data: { patient_id: id },
                success: function(response) {
                    const data = JSON.parse(response);
                    
                    // Update modal content
                    $('#view_patient_name').text(data.full_name);
                    $('#view_patient_email').text(data.email);
                    $('#view_patient_phone').text(data.phone);
                    $('#view_patient_medical_history').text(data.medical_history || 'Not specified');
                    $('#view_patient_allergies').text(data.allergies || 'None');
                    $('#view_patient_emergency_contact').text(data.emergency_contact || 'Not specified');
                    
                    // Show the modal
                    $('#viewPatientModal').modal('show');
                },
                error: function() {
                    alert('Error fetching patient details');
                }
            });
        }

        function editPatient(id) {
            // Implement edit patient
            alert('Edit patient ' + id);
        }

        function deletePatient(id) {
            if (confirm('Are you sure you want to delete this patient?')) {
                $.ajax({
                    url: 'admin_dashboard.php',
                    type: 'POST',
                    data: {
                        action: 'delete_patient',
                        patient_id: id,
                        active_tab: 'patients'
                    },
                    success: function(response) {
                        // Show success message
                        const successAlert = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            '<i class="fas fa-check-circle"></i> Patient deleted successfully!' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button></div>');
                        $('.container-fluid').prepend(successAlert);
                        
                        // Remove the row from the table
                        $(`tr:has(button[onclick="deletePatient(${id})"])`).fadeOut(300, function() {
                            $(this).remove();
                        });
                        
                        // Remove alert after 3 seconds
                        setTimeout(() => {
                            successAlert.alert('close');
                        }, 3000);
                    },
                    error: function() {
                        // Show error message
                        const errorAlert = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            '<i class="fas fa-exclamation-circle"></i> Error deleting patient!' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button></div>');
                        $('.container-fluid').prepend(errorAlert);
                        
                        // Remove alert after 3 seconds
                        setTimeout(() => {
                            errorAlert.alert('close');
                        }, 3000);
                    }
                });
            }
        }

        // Function to handle doctor actions
        function viewDoctor(id) {
            // Fetch doctor details using AJAX
            $.ajax({
                url: 'get_doctor_details.php',
                type: 'POST',
                data: { doctor_id: id },
                success: function(response) {
                    const data = JSON.parse(response);
                    
                    // Update modal content
                    $('#view_doctor_name').text(data.full_name);
                    $('#view_doctor_email').text(data.email);
                    $('#view_doctor_phone').text(data.phone || 'Not specified');
                    $('#view_doctor_specialization').text(data.specialization);
                    $('#view_doctor_license').text(data.license_no);
                    $('#view_doctor_qualification').text(data.qualification);
                    $('#view_doctor_experience').text(data.experience + ' years');
                    $('#view_doctor_status').html(data.is_active ? 
                        '<span class="badge badge-success">Active</span>' : 
                        '<span class="badge badge-danger">Inactive</span>');
                    $('#view_doctor_verification').html(data.is_verified ? 
                        '<span class="badge badge-success">Verified</span>' : 
                        '<span class="badge badge-warning">Pending</span>');
                    $('#view_doctor_bio').text(data.bio || 'Not specified');
                    $('#view_doctor_fee').text(data.consultation_fee ? '$' + data.consultation_fee : 'Not specified');
                    $('#view_doctor_days').text(data.available_days || 'Not specified');
                    $('#view_doctor_hours').text(
                        (data.start_time && data.end_time) ? 
                        data.start_time + ' - ' + data.end_time : 
                        'Not specified'
                    );
                    
                    // Show the modal
                    $('#viewDoctorModal').modal('show');
                },
                error: function() {
                    alert('Error fetching doctor details');
                }
            });
        }

        function editDoctor(id) {
            // Implement edit doctor
            alert('Edit doctor ' + id);
        }

        function deleteDoctor(id) {
            if (confirm('Are you sure you want to delete this doctor?')) {
                $.ajax({
                    url: 'admin_dashboard.php',
                    type: 'POST',
                    data: {
                        action: 'delete_doctor',
                        doctor_id: id,
                        active_tab: 'doctors'
                    },
                    success: function(response) {
                        // Show success message
                        const successAlert = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            '<i class="fas fa-check-circle"></i> Doctor deleted successfully!' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button></div>');
                        $('.container-fluid').prepend(successAlert);
                        
                        // Remove the row from the table
                        $(`tr:has(button[onclick="deleteDoctor(${id})"])`).fadeOut(300, function() {
                            $(this).remove();
                        });
                        
                        // Remove alert after 3 seconds
                        setTimeout(() => {
                            successAlert.alert('close');
                        }, 3000);
                    },
                    error: function() {
                        // Show error message
                        const errorAlert = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            '<i class="fas fa-exclamation-circle"></i> Error deleting doctor!' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button></div>');
                        $('.container-fluid').prepend(errorAlert);
                        
                        // Remove alert after 3 seconds
                        setTimeout(() => {
                            errorAlert.alert('close');
                        }, 3000);
                    }
                });
            }
        }

        // Function to handle appointment actions
        function viewAppointment(id) {
            // Fetch appointment details using AJAX
            $.ajax({
                url: 'get_appointment_details.php',
                type: 'POST',
                data: { appointment_id: id },
                success: function(response) {
                    const data = JSON.parse(response);
                    
                    // Update modal content
                    $('#view_appointment_id').text(data.appointment_id);
                    $('#view_appointment_date').text(data.appointment_date);
                    $('#view_appointment_time').text(data.appointment_time);
                    $('#view_appointment_status').html(
                        `<span class="badge badge-${getStatusClass(data.status)}">${data.status}</span>`
                    );
                    $('#view_appointment_reason').text(data.reason);
                    $('#view_appointment_notes').text(data.notes);
                    $('#view_appointment_communication').text(data.preferred_communication);
                    
                    $('#view_patient_name').text(data.patient_name);
                    $('#view_patient_phone').text(data.patient_phone || 'Not specified');
                    $('#view_doctor_name').text(data.doctor_name);
                    $('#view_doctor_phone').text(data.doctor_phone || 'Not specified');
                    $('#view_doctor_specialization').text(data.specialization);
                    $('#view_doctor_license').text(data.license_no || 'Not specified');
                    
                    // Show the modal
                    $('#viewAppointmentModal').modal('show');
                },
                error: function() {
                    alert('Error fetching appointment details');
                }
            });
        }

        function getStatusClass(status) {
            switch(status) {
                case 'Scheduled':
                    return 'info';
                case 'Completed':
                    return 'success';
                case 'Cancelled':
                    return 'danger';
                default:
                    return 'secondary';
            }
        }

        function editAppointment(id) {
            // Implement edit appointment functionality
            alert('Edit appointment functionality will be implemented here');
        }

        function deleteAppointment(id) {
            if(confirm('Are you sure you want to delete this appointment?')) {
                // Implement delete appointment
                alert('Delete appointment ' + id);
            }
        }

        function fillEditPatientModal(id, name, email, phone) {
            document.getElementById('edit_patient_id').value = id;
            document.getElementById('edit_full_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('edit_password').value = '';
        }

        function fillEditDoctorModal(id, name, email, specialization, license_no, qualification, experience, phone) {
            document.getElementById('edit_doctor_id').value = id;
            document.getElementById('edit_doctor_full_name').value = name;
            document.getElementById('edit_doctor_email').value = email;
            document.getElementById('edit_doctor_specialization').value = specialization;
            document.getElementById('edit_doctor_license_no').value = license_no;
            document.getElementById('edit_doctor_qualification').value = qualification;
            document.getElementById('edit_doctor_experience').value = experience;
            document.getElementById('edit_doctor_phone').value = phone;
            document.getElementById('edit_doctor_password').value = '';
        }

        function fillDoctorProfileModal(doctorId) {
            // Fetch doctor profile data using AJAX
            $.ajax({
                url: 'get_doctor_profile.php',
                type: 'POST',
                data: { doctor_id: doctorId },
                success: function(response) {
                    const data = JSON.parse(response);
                    $('#profile_doctor_id').val(doctorId);
                    $('#doctor_bio').val(data.bio);
                    $('#consultation_fee').val(data.consultation_fee);
                    
                    // Set available days
                    const availableDays = data.available_days.split(',');
                    $('input[name="available_days[]"]').prop('checked', false);
                    availableDays.forEach(day => {
                        $(`#day_${day}`).prop('checked', true);
                    });
                    
                    $('#start_time').val(data.start_time);
                    $('#end_time').val(data.end_time);
                }
            });
        }

        function toggleDoctorStatus(doctorId, isChecked) {
            const statusLabel = document.getElementById('status_label_' + doctorId);
            
            // Update the label immediately for better UX
            statusLabel.textContent = isChecked ? 'Active' : 'Inactive';
            
            // Send AJAX request
            $.ajax({
                url: 'admin_dashboard.php',
                type: 'POST',
                data: {
                    action: 'toggle_status',
                    doctor_id: doctorId,
                    active_tab: 'doctors'
                },
                success: function(response) {
                    // Show success message
                    const successAlert = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        '<i class="fas fa-check-circle"></i> Doctor status updated successfully!' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span></button></div>');
                    $('.container-fluid').prepend(successAlert);
                    
                    // Remove alert after 3 seconds
                    setTimeout(() => {
                        successAlert.alert('close');
                    }, 3000);
                },
                error: function() {
                    // Show error message
                    const errorAlert = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<i class="fas fa-exclamation-circle"></i> Error updating doctor status!' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span></button></div>');
                    $('.container-fluid').prepend(errorAlert);
                    
                    // Remove alert after 3 seconds
                    setTimeout(() => {
                        errorAlert.alert('close');
                    }, 3000);
                    
                    // Revert the toggle state
                    const checkbox = document.querySelector(`#toggleContainer_${doctorId} input[type="checkbox"]`);
                    checkbox.checked = !isChecked;
                    statusLabel.textContent = !isChecked ? 'Active' : 'Inactive';
                }
            });
        }

        // Add error handling for form submission
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitButton = form.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    }
                });
            });
        });
    </script>
</body>
</html>
