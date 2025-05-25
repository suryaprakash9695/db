<?php
session_start();
require_once 'includes/db_connect.php';

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

try {
    // Fetch doctor's current information
    $stmt = $con->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
    if ($stmt === false) {
        throw new Exception("Database error: Unable to prepare statement for fetching doctor information. Check SQL syntax or connection.");
    }
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $doctor = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize input
        $full_name = trim($_POST['full_name']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST['phone']);
        $specialization = trim($_POST['specialization']);
        $qualification = trim($_POST['qualification']);
        $experience = (int)$_POST['experience'];
        $bio = trim($_POST['bio']);
        $address = trim($_POST['address']);

        // Validate required fields
        if (empty($full_name) || empty($email) || empty($phone) || empty($specialization)) {
            throw new Exception("Please fill in all required fields.");
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Please enter a valid email address.");
        }

        // Check if email is already taken by another doctor
        $stmt = $con->prepare("SELECT doctor_id FROM doctors WHERE email = ? AND doctor_id != ?");
        if ($stmt === false) {
            throw new Exception("Database error: Unable to prepare statement for checking duplicate email. Check SQL syntax or connection.");
        }
        $stmt->bind_param("si", $email, $doctor_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("This email is already registered to another doctor.");
        }
        $stmt->close();

        // Handle profile image upload
        $profile_image = $doctor['profile_image']; // Keep existing image by default
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 5MB

            if (!in_array($_FILES['profile_image']['type'], $allowed_types)) {
                throw new Exception("Please upload a valid image file (JPEG, PNG, or GIF).");
            }

            if ($_FILES['profile_image']['size'] > $max_size) {
                throw new Exception("Image size should not exceed 5MB.");
            }

            $upload_dir = 'uploads/doctors/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $new_filename = 'doctor_' . $doctor_id . '_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_path)) {
                // Delete old profile image if exists
                if ($doctor['profile_image'] && file_exists($upload_dir . $doctor['profile_image'])) {
                    unlink($upload_dir . $doctor['profile_image']);
                }
                $profile_image = $new_filename;
            }
        }

        // Update doctor information
        $stmt = $con->prepare("UPDATE doctors SET
            full_name = ?,
            email = ?,
            phone = ?,
            specialization = ?,
            qualification = ?,
            experience = ?,
            bio = ?,
            address = ?,
            profile_image = ?
        WHERE doctor_id = ?");

        if ($stmt === false) {
            // Log the specific database error during prepare
            error_log("Database error during prepare: (" . $con->errno . ") " . $con->error);
            throw new Exception("Database error: Unable to prepare statement for updating doctor profile. Check SQL syntax or connection.");
        }

        // Bind parameters
        $stmt->bind_param("sssssisssi",
            $full_name,
            $email,
            $phone,
            $specialization,
            $qualification,
            $experience,
            $bio,
            $address,
            $profile_image,
            $doctor_id
        );

        // Log query and parameters before execution (for debugging)
        error_log("Executing profile update query: " . $stmt->sql);
        error_log("Bound parameters: " . print_r($stmt->param_types, true));

        // Log result of execute
        if ($stmt->execute()) {
            error_log("Profile update successful for doctor ID: " . $doctor_id);
            $success_message = "Profile updated successfully!";
            // Refresh doctor data
            $stmt = $con->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
            if ($stmt === false) {
                throw new Exception("Failed to prepare statement.");
            }
            $stmt->bind_param("i", $doctor_id);
            $stmt->execute();
            $doctor = $stmt->get_result()->fetch_assoc();
        } else {
            // Log detailed error information on failure
            error_log("Profile update failed for doctor ID: " . $doctor_id . ". Error: (" . $stmt->errno . ") " . $stmt->error);
            throw new Exception("Failed to update profile. Please try again.");
        }
        $stmt->close();

    }
} catch (Exception $e) {
    $error_message = $e->getMessage();
    error_log("Error in doctor_profile.php: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile - WeCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2196f3;
            --secondary-color: #4CAF50;
            --accent-color: #ff9800;
            --danger-color: #f44336;
            --light-bg: #f5f5f5;
            --dark-text: #333;
            --light-text: #666;
            --border-color: #e0e0e0;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            margin: 0;
            padding: 0;
            color: var(--dark-text);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .profile-container {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
        }

        .profile-sidebar {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
        }

        .profile-image-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto 1.5rem;
        }

        .profile-image {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-color);
        }

        .image-upload {
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
        }

        .image-upload:hover {
            background: #1976d2;
        }

        .profile-info {
            margin-top: 1.5rem;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0 0 0.5rem;
        }

        .profile-specialization {
            color: var(--primary-color);
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--light-text);
        }

        .profile-form {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #1976d2;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        #profile-image-input {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1 style="margin: 0;">
                    <i class="fas fa-user-md" style="color: var(--primary-color);"></i>
                    Doctor Profile
                </h1>
                <p style="margin: 0.5rem 0 0; color: var(--light-text);">
                    Manage your professional profile
                </p>
            </div>
            <a href="doctor_dashboard.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="profile-container">
            <!-- Profile Sidebar -->
            <div class="profile-sidebar">
                <div class="profile-image-container">
                    <img src="<?php echo $doctor['profile_image'] ? 'uploads/doctors/' . $doctor['profile_image'] : 'assets/images/default-doctor.png'; ?>" 
                         alt="Profile Image" 
                         class="profile-image">
                    <label for="profile-image-input" class="image-upload">
                        <i class="fas fa-camera"></i>
                    </label>
                </div>
                <div class="profile-info">
                    <h2 class="profile-name"><?php echo htmlspecialchars($doctor['full_name']); ?></h2>
                    <div class="profile-specialization">
                        <?php echo htmlspecialchars($doctor['specialization']); ?>
                    </div>
                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-value"><?php echo $doctor['experience']; ?></div>
                            <div class="stat-label">Years Experience</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?php echo $doctor['qualification']; ?></div>
                            <div class="stat-label">Qualification</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Form -->
            <form class="profile-form" method="POST" enctype="multipart/form-data">
                <input type="file" id="profile-image-input" name="profile_image" accept="image/*">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" 
                               name="full_name" 
                               class="form-input" 
                               value="<?php echo htmlspecialchars($doctor['full_name']); ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" 
                               name="email" 
                               class="form-input" 
                               value="<?php echo htmlspecialchars($doctor['email']); ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="tel" 
                               name="phone" 
                               class="form-input" 
                               value="<?php echo htmlspecialchars($doctor['phone']); ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Specialization</label>
                        <input type="text" 
                               name="specialization" 
                               class="form-input" 
                               value="<?php echo htmlspecialchars($doctor['specialization']); ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Qualification</label>
                        <input type="text" 
                               name="qualification" 
                               class="form-input" 
                               value="<?php echo htmlspecialchars($doctor['qualification']); ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Years of Experience</label>
                        <input type="number" 
                               name="experience" 
                               class="form-input" 
                               value="<?php echo $doctor['experience']; ?>" 
                               min="0" 
                               required>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Address</label>
                        <input type="text" 
                               name="address" 
                               class="form-input" 
                               value="<?php echo htmlspecialchars($doctor['address'] ?? ''); ?>">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" 
                                  class="form-input form-textarea"><?php echo htmlspecialchars($doctor['bio'] ?? ''); ?></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </form>
        </div>
    </div>

    <script>
        // Handle profile image upload preview
        document.getElementById('profile-image-input').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.profile-image').src = e.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
</body>
</html> 