<?php
session_start();
require_once 'includes/db_connect.php';

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['user_id'];
$doctor_name = $_SESSION['user_name'];
$error = '';
$success = '';

// Get patient_id from URL if provided
$patient_id = isset($_GET['patient_id']) ? (int)$_GET['patient_id'] : null;

// Fetch patients list
try {
    $stmt = $con->prepare("SELECT DISTINCT p.* FROM patients p 
                          JOIN appointments a ON p.patient_id = a.patient_id 
                          WHERE a.doctor_id = ? 
                          ORDER BY p.full_name ASC");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $patients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    error_log("Error fetching patients: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $diagnosis = $_POST['diagnosis'];
    // Process prescription data
    $medications = $_POST['medication'] ?? [];
    $dosages = $_POST['dosage'] ?? [];
    $frequencies = $_POST['frequency'] ?? [];
    $durations = $_POST['duration'] ?? [];

    $prescription_data = [];
    // Assuming all prescription arrays have the same count
    $count = count($medications);
    for ($i = 0; $i < $count; $i++) {
        // Only add if medication name is not empty
        if (!empty($medications[$i])) {
            $prescription_data[] = [
                'medication' => trim($medications[$i]),
                'dosage' => trim($dosages[$i] ?? ''),
                'frequency' => trim($frequencies[$i] ?? ''),
                'duration' => trim($durations[$i] ?? '')
            ];
        }
    }
    
    $prescription_json = json_encode($prescription_data);
    if ($prescription_json === false) {
        // Handle JSON encoding error if necessary
        $error = "Error encoding prescription data.";
        error_log("JSON encoding error: " . json_last_error_msg());
        // Decide whether to continue or exit based on how critical this is
    }

    $notes = $_POST['notes'] ?? '';
    $follow_up_date = $_POST['follow_up_date'] ?? null;
    // Ensure follow_up_date is null if empty string
    if ($follow_up_date === '') {
        $follow_up_date = null;
    }
    
    $record_date = date('Y-m-d');

    try {
        // Insert medical record
        $stmt = $con->prepare("INSERT INTO medical_records 
                              (patient_id, doctor_id, diagnosis, prescription, notes, 
                               record_date, follow_up_date, created_at) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $con->error);
        }

        // Bind parameters
        // Use references for bind_param
        $bind_types = "iisssss";
        $bind_values = [
            &$patient_id,
            &$doctor_id,
            &$diagnosis,
            &$prescription_json,
            &$notes,
            &$record_date,
            &$follow_up_date // This variable can be null
        ];

        // Call bind_param dynamically
        if (!($stmt->bind_param($bind_types, ...$bind_values))) {
             throw new Exception("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        
        if ($stmt->execute()) {
            $success = "Medical record added successfully!";
            // Clear form data
            $patient_id = null;
            $diagnosis = '';
            $prescription_data = [];
            $notes = '';
            $follow_up_date = '';
        } else {
            $error = "Failed to add medical record. Please try again.";
        }
        $stmt->close();
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
        error_log("Error in add_medical_record.php: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medical Record - WeCare</title>
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
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-text);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        textarea.form-control {
            min-height: 100px;
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
            font-size: 1rem;
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
            background: #e8f5e9;
            color: #2e7d32;
        }

        .alert-danger {
            background: #ffebee;
            color: #c62828;
        }

        .prescription-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .prescription-section h3 {
            margin: 0 0 1rem;
            color: var(--primary-color);
        }

        .prescription-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .prescription-item {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .prescription-item label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .prescription-item input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1 style="margin: 0;">
                    <i class="fas fa-file-medical" style="color: var(--primary-color);"></i>
                    Add Medical Record
                </h1>
                <p style="margin: 0.5rem 0 0; color: var(--light-text);">
                    Create a new medical record for a patient
                </p>
            </div>
            <a href="doctor_dashboard.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="card">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="patient_id">Select Patient</label>
                    <select name="patient_id" id="patient_id" class="form-control" required>
                        <option value="">Choose a patient...</option>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?php echo $patient['patient_id']; ?>" 
                                    <?php echo $patient_id == $patient['patient_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($patient['full_name']); ?> 
                                (<?php echo htmlspecialchars($patient['phone']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="diagnosis">Diagnosis</label>
                    <textarea name="diagnosis" id="diagnosis" class="form-control" 
                              required placeholder="Enter patient diagnosis"></textarea>
                </div>

                <div class="prescription-section">
                    <h3><i class="fas fa-prescription"></i> Prescription</h3>
                    <div class="prescription-grid">
                        <div class="prescription-item">
                            <label for="medication">Medication</label>
                            <input type="text" name="medication[]" class="form-control" 
                                   placeholder="Medication name">
                        </div>
                        <div class="prescription-item">
                            <label for="dosage">Dosage</label>
                            <input type="text" name="dosage[]" class="form-control" 
                                   placeholder="e.g., 500mg">
                        </div>
                        <div class="prescription-item">
                            <label for="frequency">Frequency</label>
                            <input type="text" name="frequency[]" class="form-control" 
                                   placeholder="e.g., Twice daily">
                        </div>
                        <div class="prescription-item">
                            <label for="duration">Duration</label>
                            <input type="text" name="duration[]" class="form-control" 
                                   placeholder="e.g., 7 days">
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" style="margin-top: 1rem;" 
                            onclick="addPrescriptionItem()">
                        <i class="fas fa-plus"></i> Add Another Medication
                    </button>
                </div>

                <div class="form-group">
                    <label for="notes">Additional Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="4" 
                              placeholder="Enter any additional notes or instructions"></textarea>
                </div>

                <div class="form-group">
                    <label for="follow_up_date">Follow-up Date (Optional)</label>
                    <input type="date" name="follow_up_date" id="follow_up_date" 
                           class="form-control" min="<?php echo date('Y-m-d'); ?>">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Medical Record
                </button>
            </form>
        </div>
    </div>

    <script>
        function addPrescriptionItem() {
            const grid = document.querySelector('.prescription-grid');
            const newItem = document.createElement('div');
            newItem.className = 'prescription-grid';
            newItem.innerHTML = `
                <div class="prescription-item">
                    <label for="medication">Medication</label>
                    <input type="text" name="medication[]" class="form-control" 
                           placeholder="Medication name">
                </div>
                <div class="prescription-item">
                    <label for="dosage">Dosage</label>
                    <input type="text" name="dosage[]" class="form-control" 
                           placeholder="e.g., 500mg">
                </div>
                <div class="prescription-item">
                    <label for="frequency">Frequency</label>
                    <input type="text" name="frequency[]" class="form-control" 
                           placeholder="e.g., Twice daily">
                </div>
                <div class="prescription-item">
                    <label for="duration">Duration</label>
                    <input type="text" name="duration[]" class="form-control" 
                           placeholder="e.g., 7 days">
                </div>
                <div class="prescription-item">
                    <button type="button" class="btn btn-danger" 
                            onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            `;
            grid.parentElement.insertBefore(newItem, grid.nextSibling);
        }
    </script>
</body>
</html> 