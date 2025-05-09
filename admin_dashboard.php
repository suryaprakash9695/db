<?php
session_start();
require_once('config.php');

// Encryption Key
define('SECRET_KEY', 'your-secret-key'); // Replace with a secure key

function encryptPassword($password) {
    return openssl_encrypt($password, 'AES-128-ECB', SECRET_KEY);
}

function decryptPassword($encryptedPassword) {
    return openssl_decrypt($encryptedPassword, 'AES-128-ECB', SECRET_KEY);
}

// Check if admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Handle adding a doctor or patient
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_doctor'])) {
        $doctor_name = $_POST['doctor_name'];
        $doctor_email = $_POST['doctor_email'];
        $doctor_password = encryptPassword($_POST['doctor_password']);
        $role = 'doctor';

        $stmt = $con->prepare("INSERT INTO wecare_signup (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $doctor_name, $doctor_email, $doctor_password, $role);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Doctor added successfully!');</script>";
    } elseif (isset($_POST['add_patient'])) {
        $patient_name = $_POST['patient_name'];
        $patient_email = $_POST['patient_email'];
        $patient_password = encryptPassword($_POST['patient_password']);
        $role = 'patient';

        $stmt = $con->prepare("INSERT INTO wecare_signup (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $patient_name, $patient_email, $patient_password, $role);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Patient added successfully!');</script>";
    }
}

// Handle editing a user
if (isset($_POST['edit_user'])) {
    $userid = $_POST['userid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = encryptPassword($_POST['password']);
    $role = $_POST['role'];

    $stmt = $con->prepare("UPDATE wecare_signup SET username = ?, email = ?, password = ? WHERE userid = ? AND role = ?");
    $stmt->bind_param("sssis", $username, $email, $password, $userid, $role);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('User details updated successfully!');</script>";
}

// Handle deleting a user
if (isset($_GET['delete_id']) && isset($_GET['role'])) {
    $userid = $_GET['delete_id'];
    $role = $_GET['role'];

    $stmt = $con->prepare("DELETE FROM wecare_signup WHERE userid = ? AND role = ?");
    $stmt->bind_param("is", $userid, $role);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('User deleted successfully!'); window.location.href='admin_dashboard.php';</script>";
}

// Fetch doctors and patients
$doctors = $con->query("SELECT * FROM wecare_signup WHERE role = 'doctor'");
$patients = $con->query("SELECT * FROM wecare_signup WHERE role = 'patient'");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>

<body style="padding-top: 20px; padding-bottom: 20px; font-family: Arial, sans-serif; background-color: #f8f9fa;">

    <div class="container" style="padding: 30px; background-color: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 8px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 style="font-size: 24px; color: #343a40;">Admin Dashboard</h1>
            <a href="logout.php" class="btn btn-danger" style="font-size: 14px; padding: 8px 16px;">Logout</a>
        </div>

        <div class="row">
            <!-- Doctors Section -->
            <div class="col-lg-6 col-md-12">
                <div class="card border-primary" style="border-radius: 8px; margin-bottom: 20px;">
                    <div class="card-header bg-primary text-white" style="font-size: 18px; padding: 15px;">
                        <h3 class="card-title">Doctors</h3>
                    </div>
                    <div class="card-body" style="padding: 15px;">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered" style="width: 100%; text-align: center;">
                                <thead>
                                    <tr>
                                        <th style="padding: 12px;">ID</th>
                                        <th style="padding: 12px;">Name</th>
                                        <th style="padding: 12px;">Email</th>
                                        <th style="padding: 12px;">Password</th>
                                        <th style="padding: 12px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($doctor = $doctors->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= $doctor['userid'] ?></td>
                                            <td><?= $doctor['username'] ?></td>
                                            <td><?= $doctor['email'] ?></td>
                                            <td><?= decryptPassword($doctor['password']) ?></td>
                                            <td>
                                                <a href="?delete_id=<?= $doctor['userid'] ?>&role=doctor" class="btn btn-danger btn-sm" style="font-size: 12px;">Delete</a>
                                                <a href="admin_dashboard.php?edit_id=<?= $doctor['userid'] ?>&role=doctor" class="btn btn-warning btn-sm" style="font-size: 12px;">Edit</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <form method="POST" style="padding: 15px; background-color: #f1f1f1; border-radius: 8px;">
                            <h4>Add Doctor</h4>
                            <input type="text" name="doctor_name" placeholder="Name" class="form-control" required style="margin-bottom: 10px;">
                            <input type="email" name="doctor_email" placeholder="Email" class="form-control" required style="margin-bottom: 10px;">
                            <input type="password" name="doctor_password" placeholder="Password" class="form-control" required style="margin-bottom: 10px;">
                            <button type="submit" name="add_doctor" class="btn btn-primary" style="width: 100%; padding: 10px;">Add Doctor</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Patients Section -->
            <div class="col-lg-6 col-md-12">
                <div class="card border-success" style="border-radius: 8px; margin-bottom: 20px;">
                    <div class="card-header bg-success text-white" style="font-size: 18px; padding: 15px;">
                        <h3 class="card-title">Patients</h3>
                    </div>
                    <div class="card-body" style="padding: 15px;">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered" style="width: 100%; text-align: center;">
                                <thead>
                                    <tr>
                                        <th style="padding: 12px;">ID</th>
                                        <th style="padding: 12px;">Name</th>
                                        <th style="padding: 12px;">Email</th>
                                        <th style="padding: 12px;">Password</th>
                                        <th style="padding: 12px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($patient = $patients->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= $patient['userid'] ?></td>
                                            <td><?= $patient['username'] ?></td>
                                            <td><?= $patient['email'] ?></td>
                                            <td><?= decryptPassword($patient['password']) ?></td>
                                            <td>
                                                <a href="?delete_id=<?= $patient['userid'] ?>&role=patient" class="btn btn-danger btn-sm" style="font-size: 12px;">Delete</a>
                                                <a href="admin_dashboard.php?edit_id=<?= $patient['userid'] ?>&role=patient" class="btn btn-warning btn-sm" style="font-size: 12px;">Edit</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <form method="POST" style="padding: 15px; background-color: #f1f1f1; border-radius: 8px;">
                            <h4>Add Patient</h4>
                            <input type="text" name="patient_name" placeholder="Name" class="form-control" required style="margin-bottom: 10px;">
                            <input type="email" name="patient_email" placeholder="Email" class="form-control" required style="margin-bottom: 10px;">
                            <input type="password" name="patient_password" placeholder="Password" class="form-control" required style="margin-bottom: 10px;">
                            <button type="submit" name="add_patient" class="btn btn-primary" style="width: 100%; padding: 10px;">Add Patient</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
