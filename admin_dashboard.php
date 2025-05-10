<?php
session_start();
require_once('config.php');

// Error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define encryption key for password hashing (use bcrypt)
define('ENCRYPTION_KEY', 'your-encryption-key'); // Optional for bcrypt, can be left out

// Function to hash password using bcrypt
function encryptPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

// Function to verify password using bcrypt
function verifyPassword($inputPassword, $encryptedPassword)
{
    return password_verify($inputPassword, $encryptedPassword);
}

// Check if admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Handle adding a doctor or patient
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_doctor'])) {
        $name = $_POST['doctor_name'];
        $email = $_POST['doctor_email'];
        $password = encryptPassword($_POST['doctor_password']);
        $role = 'doctor';

        $stmt = $con->prepare("INSERT INTO wecare_signup (username, email, password, role) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            echo "Error preparing statement: " . $con->error;
        } else {
            $stmt->bind_param("ssss", $name, $email, $password, $role);
            if ($stmt->execute()) {
                echo "<script>alert('Doctor added successfully!'); window.location.href='admin_dashboard.php';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }
    } elseif (isset($_POST['add_patient'])) {
        $name = $_POST['patient_name'];
        $email = $_POST['patient_email'];
        $password = encryptPassword($_POST['patient_password']);
        $role = 'patient';

        $stmt = $con->prepare("INSERT INTO wecare_signup (username, email, password, role) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            echo "Error preparing statement: " . $con->error;
        } else {
            $stmt->bind_param("ssss", $name, $email, $password, $role);
            if ($stmt->execute()) {
                echo "<script>alert('Patient added successfully!'); window.location.href='admin_dashboard.php';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }
    } elseif (isset($_POST['edit_user'])) {
        // Edit user details
        $id = $_POST['userid'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = !empty($_POST['password']) ? encryptPassword($_POST['password']) : null; // Optional: Update password if changed

        if ($password) {
            $stmt = $con->prepare("UPDATE wecare_signup SET username = ?, email = ?, password = ? WHERE userid = ?");
            $stmt->bind_param("sssi", $name, $email, $password, $id);
        } else {
            $stmt = $con->prepare("UPDATE wecare_signup SET username = ?, email = ? WHERE userid = ?");
            $stmt->bind_param("ssi", $name, $email, $id);
        }

        if ($stmt->execute()) {
            echo "<script>alert('User updated successfully!'); window.location.href='admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}

// Handle deleting a user
if (isset($_GET['delete_id']) && isset($_GET['role'])) {
    $id = $_GET['delete_id'];
    $role = $_GET['role'];

    $stmt = $con->prepare("DELETE FROM wecare_signup WHERE userid = ? AND role = ?");
    $stmt->bind_param("is", $id, $role);
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
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

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Admin Dashboard</h1>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <div class="row">
            <!-- Doctors Section -->
            <div class="col-md-6">
                <div class="card border-primary mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Doctors</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($doctor = $doctors->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $doctor['userid'] ?></td>
                                        <td><?= $doctor['username'] ?></td>
                                        <td><?= $doctor['email'] ?></td>
                                        <td>******</td> <!-- Do not show plain passwords -->
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editDoctorModal<?= $doctor['userid'] ?>">Edit</button>
                                            <a href="?delete_id=<?= $doctor['userid'] ?>&role=doctor" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>

                                    <!-- Edit Doctor Modal -->
                                    <div class="modal fade" id="editDoctorModal<?= $doctor['userid'] ?>" tabindex="-1" role="dialog" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editDoctorModalLabel">Edit Doctor</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="userid" value="<?= $doctor['userid'] ?>">
                                                        <input type="text" name="name" class="form-control mb-2" value="<?= $doctor['username'] ?>" required>
                                                        <input type="email" name="email" class="form-control mb-2" value="<?= $doctor['email'] ?>" required>
                                                        <input type="password" name="password" class="form-control mb-2" placeholder="New Password (optional)">
                                                        <button type="submit" name="edit_user" class="btn btn-primary">Update Doctor</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </tbody>
                        </table>
                        <form method="POST" class="mt-3">
                            <h4>Add Doctor</h4>
                            <input type="text" name="doctor_name" placeholder="Name" class="form-control mb-2" required>
                            <input type="email" name="doctor_email" placeholder="Email" class="form-control mb-2" required>
                            <input type="password" name="doctor_password" placeholder="Password" class="form-control mb-2" required>
                            <button type="submit" name="add_doctor" class="btn btn-primary">Add Doctor</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Patients Section -->
            <div class="col-md-6">
                <div class="card border-success mb-4">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title">Patients</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($patient = $patients->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $patient['userid'] ?></td>
                                        <td><?= $patient['username'] ?></td>
                                        <td><?= $patient['email'] ?></td>
                                        <td>******</td> <!-- Do not show plain passwords -->
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPatientModal<?= $patient['userid'] ?>">Edit</button>
                                            <a href="?delete_id=<?= $patient['userid'] ?>&role=patient" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                    <!-- Edit Patient Modal -->
                                    <div class="modal fade" id="editPatientModal<?= $patient['userid'] ?>" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="userid" value="<?= $patient['userid'] ?>">
                                                        <input type="text" name="name" class="form-control mb-2" value="<?= $patient['username'] ?>" required>
                                                        <input type="email" name="email" class="form-control mb-2" value="<?= $patient['email'] ?>" required>
                                                        <input type="password" name="password" class="form-control mb-2" placeholder="New Password (optional)">
                                                        <button type="submit" name="edit_user" class="btn btn-primary">Update Patient</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </tbody>
                        </table>
                        <form method="POST" class="mt-3">
                            <h4>Add Patient</h4>
                            <input type="text" name="patient_name" placeholder="Name" class="form-control mb-2" required>
                            <input type="email" name="patient_email" placeholder="Email" class="form-control mb-2" required>
                            <input type="password" name="patient_password" placeholder="Password" class="form-control mb-2" required>
                            <button type="submit" name="add_patient" class="btn btn-primary">Add Patient</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/jquery/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>