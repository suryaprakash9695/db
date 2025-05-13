<?php
session_start();
require_once('../config.php');

// Check if user is logged in and is a patient
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: ../patient_login.php");
    exit;
}

$patientId = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

// Handle profile image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $target_dir = "../uploads/patients/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION));
    $new_filename = "patient_" . $patientId . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
    if($check !== false) {
        // Check file size (5MB max)
        if ($_FILES["profile_image"]["size"] <= 5000000) {
            // Allow certain file formats
            if($file_extension == "jpg" || $file_extension == "png" || $file_extension == "jpeg") {
                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                    // Update database with new image path
                    $image_path = "uploads/patients/" . $new_filename;
                    $stmt = $con->prepare("UPDATE patients SET profile_image = ? WHERE patient_id = ?");
                    $stmt->bind_param("si", $image_path, $patientId);
                    if ($stmt->execute()) {
                        $success_message = "Profile image updated successfully!";
                    } else {
                        $error_message = "Error updating database.";
                    }
                } else {
                    $error_message = "Error uploading file.";
                }
            } else {
                $error_message = "Only JPG, JPEG & PNG files are allowed.";
            }
        } else {
            $error_message = "File is too large. Maximum size is 5MB.";
        }
    } else {
        $error_message = "File is not an image.";
    }
}

// Get patient's information
$stmt = $con->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->bind_param("i", $patientId);
$stmt->execute();
$patient = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - WeCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .profile-image-container {
            width: 150px;
            height: 150px;
            margin: 0 auto 1rem;
            position: relative;
        }
        .profile-image {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #3498db;
        }
        .profile-initials {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: bold;
        }
        .upload-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #3498db;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .upload-btn:hover {
            background: #2980b9;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 500;
            color: #2c3e50;
        }
        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .btn-save {
            background: #3498db;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-save:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <?php include 'includes/sidebar.php'; ?>

        <div class="main-content">
            <div class="profile-container">
                <div class="profile-header">
                    <h2>Profile Settings</h2>
                    <p class="text-muted">Update your profile information and photo</p>
                </div>

                <?php if ($success_message): ?>
                    <div class="alert alert-success"><?php echo $success_message; ?></div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="profile-image-container">
                        <?php if (isset($patient['profile_image']) && file_exists("../" . $patient['profile_image'])): ?>
                            <img src="../<?php echo $patient['profile_image']; ?>" alt="Profile" class="profile-image">
                        <?php else: ?>
                            <div class="profile-initials">
                                <?php 
                                    $name = explode(' ', $patient['full_name']);
                                    $initials = '';
                                    foreach($name as $n) {
                                        $initials .= strtoupper(substr($n, 0, 1));
                                    }
                                    echo $initials;
                                ?>
                            </div>
                        <?php endif; ?>
                        <label for="profile_image" class="upload-btn">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*" style="display: none;" onchange="this.form.submit()">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($patient['full_name']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?php echo htmlspecialchars($patient['email']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="tel" class="form-control" value="<?php echo htmlspecialchars($patient['phone'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" value="<?php echo htmlspecialchars($patient['date_of_birth'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select class="form-control" name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male" <?php echo ($patient['gender'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($patient['gender'] ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo ($patient['gender'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" rows="3"><?php echo htmlspecialchars($patient['address'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-save">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 