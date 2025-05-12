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

// Handle Delete Operations
if (isset($_POST['delete_patient'])) {
    $patient_id = $_POST['patient_id'];
    $delete_query = "DELETE FROM patients WHERE patient_id = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("i", $patient_id);
    if ($stmt->execute()) {
        $success_message = "Patient deleted successfully!";
    } else {
        $error_message = "Error deleting patient!";
    }
}

if (isset($_POST['delete_doctor'])) {
    $doctor_id = $_POST['doctor_id'];
    $delete_query = "DELETE FROM doctors WHERE doctor_id = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("i", $doctor_id);
    if ($stmt->execute()) {
        $success_message = "Doctor deleted successfully!";
    } else {
        $error_message = "Error deleting doctor!";
    }
}

// Handle Add Operations
if (isset($_POST['add_patient'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $add_query = "INSERT INTO patients (full_name, email, phone, password) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($add_query);
    $stmt->bind_param("ssss", $full_name, $email, $phone, $password);
    if ($stmt->execute()) {
        $success_message = "Patient added successfully!";
    } else {
        $error_message = "Error adding patient!";
    }
}

if (isset($_POST['add_doctor'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $specialization = $_POST['specialization'];
    $license_no = $_POST['license_no'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $add_query = "INSERT INTO doctors (full_name, email, specialization, license_no, password, is_verified) VALUES (?, ?, ?, ?, ?, 1)";
    $stmt = $con->prepare($add_query);
    $stmt->bind_param("sssss", $full_name, $email, $specialization, $license_no, $password);
    if ($stmt->execute()) {
        $success_message = "Doctor added successfully!";
    } else {
        $error_message = "Error adding doctor! " . $stmt->error;
    }
}

// Fetch all patients
$patients_query = "SELECT * FROM patients ORDER BY patient_id DESC";
$patients_result = $con->query($patients_query);

// Fetch all doctors
$doctors_query = "SELECT * FROM doctors ORDER BY doctor_id DESC";
$doctors_result = $con->query($doctors_query);

// Fetch all appointments
$appointments_query = "SELECT a.*, p.full_name as patient_name, d.full_name as doctor_name 
                      FROM appointments a 
                      JOIN patients p ON a.patient_id = p.patient_id 
                      JOIN doctors d ON a.doctor_id = d.doctor_id 
                      ORDER BY a.appointment_date DESC";
$appointments_result = $con->query($appointments_query);

if (isset($_POST['update_doctor'])) {
    $id = $_POST['edit_doctor_id'];
    $name = $_POST['edit_doctor_full_name'];
    $email = $_POST['edit_doctor_email'];
    $specialization = $_POST['edit_doctor_specialization'];
    $password = $_POST['edit_doctor_password'];

    if (!empty($password)) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE doctors SET full_name=?, email=?, specialization=?, password=? WHERE doctor_id=?";
        $stmt = $con->prepare($update_query);
        $stmt->bind_param("ssssi", $name, $email, $specialization, $password_hashed, $id);
    } else {
        $update_query = "UPDATE doctors SET full_name=?, email=?, specialization=? WHERE doctor_id=?";
        $stmt = $con->prepare($update_query);
        $stmt->bind_param("sssi", $name, $email, $specialization, $id);
    }

    if ($stmt->execute()) {
        $success_message = "Doctor updated successfully!";
    } else {
        $error_message = "Error updating doctor!";
    }
}
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
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
        }
        .dashboard-card h2 {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
        }

        /* Navigation Tabs */
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 20px;
        }
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s;
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

        /* Tables */
        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
            padding: 12px;
        }
        .table tbody td {
            padding: 12px;
            vertical-align: middle;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        /* Forms */
        .add-form {
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px 15px;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Buttons */
        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.875rem;
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

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            padding: 15px 20px;
        }
        .card-body {
            padding: 20px;
        }

        /* Badges */
        .badge {
            padding: 6px 10px;
            border-radius: 4px;
            font-weight: 500;
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
            border-radius: 8px;
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
            margin-right: 5px;
        }

        /* Container */
        .container-fluid {
            padding: 20px;
        }

        /* Header */
        h1 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-card {
                margin-bottom: 15px;
            }
            .table-responsive {
                max-height: 400px;
            }
            .btn-sm {
                padding: 4px 8px;
            }
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
                <?php echo $success_message; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error_message; ?>
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
                        <a class="nav-link active" id="patients-tab" data-toggle="tab" href="#patients" role="tab">
                            <i class="fas fa-users"></i> Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="doctors-tab" data-toggle="tab" href="#doctors" role="tab">
                            <i class="fas fa-user-md"></i> Doctors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="appointments-tab" data-toggle="tab" href="#appointments" role="tab">
                            <i class="fas fa-calendar-check"></i> Appointments
                        </a>
                    </li>
                </ul>

                <div class="tab-content mt-3" id="dashboardTabsContent">
                    <!-- Patients Tab -->
                    <div class="tab-pane fade show active" id="patients" role="tabpanel">
                        <!-- Add Patient Form -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-user-plus"></i> Add New Patient</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
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
                                                    <button class="btn btn-info btn-sm" onclick="viewPatient(<?php echo $patient['patient_id']; ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button 
                                                        class="btn btn-warning btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#editPatientModal"
                                                        onclick="fillEditPatientModal(
                                                            '<?php echo $patient['patient_id']; ?>',
                                                            '<?php echo htmlspecialchars($patient['full_name'], ENT_QUOTES); ?>',
                                                            '<?php echo htmlspecialchars($patient['email'], ENT_QUOTES); ?>',
                                                            '<?php echo htmlspecialchars($patient['phone'], ENT_QUOTES); ?>'
                                                        )"
                                                    >
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form method="POST" action="" style="display: inline;">
                                                        <input type="hidden" name="patient_id" value="<?php echo $patient['patient_id']; ?>">
                                                        <button type="submit" name="delete_patient" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this patient?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
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
                    <div class="tab-pane fade" id="doctors" role="tabpanel">
                        <!-- Add Doctor Form -->
                        <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-user-md"></i> Add New Doctor</h5>
                    </div>
                    <div class="card-body">
                                <form method="POST" action="">
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
                                                <input type="text" class="form-control" name="specialization" placeholder="Specialization" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="license_no" placeholder="License Number" required>
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
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($doctor = $doctors_result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $doctor['doctor_id']; ?></td>
                                                <td><?php echo $doctor['full_name']; ?></td>
                                                <td><?php echo $doctor['email']; ?></td>
                                                <td><?php echo $doctor['specialization']; ?></td>
                                                <td>
                                                    <span class="badge <?php echo $doctor['is_verified'] ? 'badge-success' : 'badge-warning'; ?>">
                                                        <?php echo $doctor['is_verified'] ? 'Verified' : 'Pending'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-info btn-sm" onclick="viewDoctor(<?php echo $doctor['doctor_id']; ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button 
                                                        class="btn btn-warning btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#editDoctorModal"
                                                        onclick="fillEditDoctorModal(
                                                            '<?php echo $doctor['doctor_id']; ?>',
                                                            '<?php echo htmlspecialchars($doctor['full_name'], ENT_QUOTES); ?>',
                                                            '<?php echo htmlspecialchars($doctor['email'], ENT_QUOTES); ?>',
                                                            '<?php echo htmlspecialchars($doctor['specialization'], ENT_QUOTES); ?>'
                                                        )"
                                                    >
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form method="POST" action="" style="display: inline;">
                                                        <input type="hidden" name="doctor_id" value="<?php echo $doctor['doctor_id']; ?>">
                                                        <button type="submit" name="delete_doctor" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this doctor?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
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
                    <div class="tab-pane fade" id="appointments" role="tabpanel">
                        <div class="card">
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
                                            <?php while($appointment = $appointments_result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $appointment['appointment_id']; ?></td>
                                                <td><?php echo $appointment['patient_name']; ?></td>
                                                <td><?php echo $appointment['doctor_name']; ?></td>
                                                <td><?php echo $appointment['appointment_date']; ?></td>
                                                <td><?php echo $appointment['appointment_time']; ?></td>
                                                <td>
                                                    <span class="badge badge-<?php 
                                                        echo $appointment['status'] === 'Completed' ? 'success' : 
                                                            ($appointment['status'] === 'Cancelled' ? 'danger' : 'info'); 
                                                    ?>">
                                                        <?php echo $appointment['status']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-info btn-sm" onclick="viewAppointment(<?php echo $appointment['appointment_id']; ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-warning btn-sm" onclick="editAppointment(<?php echo $appointment['appointment_id']; ?>)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" onclick="deleteAppointment(<?php echo $appointment['appointment_id']; ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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
                            <input type="text" class="form-control" name="edit_doctor_specialization" id="edit_doctor_specialization" required>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to handle patient actions
        function viewPatient(id) {
            // Implement view patient details
            alert('View patient ' + id);
        }

        function editPatient(id) {
            // Implement edit patient
            alert('Edit patient ' + id);
        }

        function deletePatient(id) {
            if(confirm('Are you sure you want to delete this patient?')) {
                // Implement delete patient
                alert('Delete patient ' + id);
            }
        }

        // Function to handle doctor actions
        function viewDoctor(id) {
            // Implement view doctor details
            alert('View doctor ' + id);
        }

        function editDoctor(id) {
            // Implement edit doctor
            alert('Edit doctor ' + id);
        }

        function deleteDoctor(id) {
            if(confirm('Are you sure you want to delete this doctor?')) {
                // Implement delete doctor
                alert('Delete doctor ' + id);
            }
        }

        // Function to handle appointment actions
        function viewAppointment(id) {
            // Implement view appointment details
            alert('View appointment ' + id);
        }

        function editAppointment(id) {
            // Implement edit appointment
            alert('Edit appointment ' + id);
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

        function fillEditDoctorModal(id, name, email, specialization) {
            document.getElementById('edit_doctor_id').value = id;
            document.getElementById('edit_doctor_full_name').value = name;
            document.getElementById('edit_doctor_email').value = email;
            document.getElementById('edit_doctor_specialization').value = specialization;
            document.getElementById('edit_doctor_password').value = '';
        }
    </script>
</body>
</html>
