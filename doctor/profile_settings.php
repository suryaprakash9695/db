<?php
session_start();
require_once('../config.php');

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: ../doctor_login.php");
    exit;
}

$doctorId = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

// Handle profile image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    // Define allowed file types and their MIME types
    $allowed_types = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png'
    ];
    
    // Maximum file size (5MB)
    $max_file_size = 5 * 1024 * 1024;
    
    // Get file information
    $file = $_FILES['profile_image'];
    $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    
    // Validate file type
    if (!array_key_exists($file_extension, $allowed_types)) {
        $error_message = "Only JPG, JPEG & PNG files are allowed.";
    }
    // Validate file size
    elseif ($file['size'] > $max_file_size) {
        $error_message = "File is too large. Maximum size is 5MB.";
    }
    // Validate MIME type
    elseif (!in_array($file['type'], $allowed_types)) {
        $error_message = "Invalid file type.";
    }
    else {
        // Create secure upload directory outside public web root
        $upload_dir = dirname(__DIR__) . '/private/uploads/doctors/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Generate secure filename
        $new_filename = 'doctor_' . $doctorId . '_' . bin2hex(random_bytes(8)) . '.' . $file_extension;
        $target_file = $upload_dir . $new_filename;
        
        // Verify it's an actual image
        if (getimagesize($file['tmp_name']) !== false) {
            // Move the file
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                // Delete old profile image if exists
                $stmt = $con->prepare("SELECT profile_image FROM doctors WHERE doctor_id = ?");
                if ($stmt === false) {
                    $error_message = "Error preparing statement: " . $con->error;
                } else {
                    $stmt->bind_param("i", $doctorId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($old_image = $result->fetch_assoc()) {
                        if (!empty($old_image['profile_image'])) {
                            $old_file = dirname(__DIR__) . '/private/' . $old_image['profile_image'];
                            if (file_exists($old_file)) {
                                unlink($old_file);
                            }
                        }
                    }
                }
                
                // Update database with new image path
                $image_path = "private/uploads/doctors/" . $new_filename;
                $stmt = $con->prepare("UPDATE doctors SET profile_image = ? WHERE doctor_id = ?");
                if ($stmt === false) {
                    $error_message = "Error preparing statement: " . $con->error;
                } else {
                    $stmt->bind_param("si", $image_path, $doctorId);
                    if ($stmt->execute()) {
                        $success_message = "Profile image updated successfully!";
                    } else {
                        $error_message = "Error updating database.";
                        // Delete the uploaded file if database update fails
                        unlink($target_file);
                    }
                }
            } else {
                $error_message = "Error uploading file.";
            }
        } else {
            $error_message = "File is not a valid image.";
        }
    }
}

// Get doctor's information
$stmt = $con->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
if ($stmt === false) {
    die("Error preparing statement: " . $con->error);
}
$stmt->bind_param("i", $doctorId);
$stmt->execute();
$doctor = $stmt->get_result()->fetch_assoc();

// Function to get image URL
function getImageUrl($image_path) {
    if (empty($image_path)) return null;
    return 'get_image.php?path=' . urlencode($image_path);
}
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
        :root {
            --primary-color: #2196f3;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --light-text: #6c757d;
            --dark-text: #343a40;
            --border-color: #dee2e6;
            --sidebar-width: 250px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            position: relative;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .profile-header h2 {
            color: var(--dark-text);
            margin-bottom: 0.5rem;
        }

        .profile-image-container {
            width: 150px;
            height: 150px;
            margin: 0 auto 1.5rem;
            position: relative;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            transition: transform 0.3s ease;
        }

        .profile-image:hover {
            transform: scale(1.05);
        }

        .profile-initials {
            width: 100%;
            height: 100%;
            background-color: var(--primary-color);
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
            background: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .upload-btn:hover {
            background: #1976d2;
            transform: scale(1.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-text);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            transition: all 0.3s ease;
            width: 100%;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
            outline: none;
        }

        .form-control:read-only {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        .btn-save {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-save:hover {
            background: #1976d2;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 1.5rem;
            padding: 1rem;
            border: none;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid var(--danger-color);
        }

        @media (max-width: 991px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .profile-container {
                padding: 1.5rem;
            }

            .profile-image-container {
                width: 120px;
                height: 120px;
            }

            .profile-initials {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 576px) {
            .profile-container {
                padding: 1rem;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .btn-save {
                padding: 0.6rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="main-content">
        <div class="profile-container">
            <div class="profile-header">
                <h2>Profile Settings</h2>
                <p class="text-muted">Update your profile information and photo</p>
            </div>

            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="profile-image-container">
                    <?php if (isset($doctor['profile_image']) && !empty($doctor['profile_image'])): ?>
                        <img src="<?php echo getImageUrl($doctor['profile_image']); ?>" alt="Profile" class="profile-image">
                    <?php else: ?>
                        <div class="profile-initials">
                            <?php 
                                $name = explode(' ', $doctor['full_name']);
                                $initials = '';
                                foreach($name as $n) {
                                    $initials .= strtoupper(substr($n, 0, 1));
                                }
                                echo $initials;
                            ?>
                        </div>
                    <?php endif; ?>
                    <label for="profile_image" class="upload-btn" title="Change Profile Picture">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/jpeg,image/png" style="display: none;" onchange="this.form.submit()">
                </div>

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($doctor['full_name']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($doctor['email']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="tel" class="form-control" value="<?php echo htmlspecialchars($doctor['phone']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">Specialization</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($doctor['specialization']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">Qualification</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($doctor['qualification']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">Experience (years)</label>
                    <input type="number" class="form-control" value="<?php echo htmlspecialchars($doctor['experience']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">License Number</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($doctor['license_no']); ?>" readonly>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 