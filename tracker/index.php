<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WeCare - Simple Period Tracker</title>
    <link rel="shortcut icon" href="../assets/images/thrive_small_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/homepage.css">
    <link rel="stylesheet" href="../assets/web/assets/mobirise-icons2/mobirise2.css">
    <link rel="stylesheet" href="../assets/tether/tether.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="../assets/dropdown/css/style.css">
    <link rel="stylesheet" href="../assets/socicon/css/styles.css">
    <link rel="stylesheet" href="../assets/theme/css/style.css">
    <link rel="preload" as="style" href="../assets/mobirise/css/mbr-additional.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Gloock&family=Source+Serif+Pro:ital@0;1&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/mobirise/css/mbr-additional.css" type="text/css">
    <link rel="stylesheet" href="assets/css/tracker.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="container">
        <div class="tracker-container">
            <div class="tracker-header">
                <h1>Simple Period Tracker</h1>
                <p>Track your cycle dates and symptoms</p>
            </div>

            <div class="tracker-content">
                <div class="tracker-form">
                    <form id="trackerForm">
                        <div class="form-group">
                            <label for="last_period">Last Period Date</label>
                            <input type="date" class="form-control" id="last_period" name="last_period" required>
                        </div>

                        <div class="form-group">
                            <label for="cycle_length">Cycle Length (days)</label>
                            <input type="number" class="form-control" id="cycle_length" name="cycle_length" min="21" max="35" value="28" required>
                        </div>

                        <div class="form-group">
                            <label>Symptoms</label>
                            <div class="symptoms-tags">
                                <input type="checkbox" name="symptoms[]" value="cramps" id="symptom-cramps">
                                <label for="symptom-cramps">Cramps</label>
                                
                                <input type="checkbox" name="symptoms[]" value="headache" id="symptom-headache">
                                <label for="symptom-headache">Headache</label>
                                
                                <input type="checkbox" name="symptoms[]" value="bloating" id="symptom-bloating">
                                <label for="symptom-bloating">Bloating</label>
                                
                                <input type="checkbox" name="symptoms[]" value="tender_breasts" id="symptom-tender-breasts">
                                <label for="symptom-tender-breasts">Tender Breasts</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Calculate Next Period</button>
                    </form>
                </div>

                <div class="tracker-stats">
                    <h2>Your Cycle Information</h2>
                    <div class="stats-container">
                        <div class="stat-card">
                            <h3>Next Period</h3>
                            <p id="next-period">-</p>
                        </div>
                        <div class="stat-card">
                            <h3>Fertile Window</h3>
                            <p id="fertile-window">-</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
    
    <script>
    document.getElementById('trackerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const lastPeriod = new Date(document.getElementById('last_period').value);
        const cycleLength = parseInt(document.getElementById('cycle_length').value);
        
        // Calculate next period
        const nextPeriod = new Date(lastPeriod);
        nextPeriod.setDate(nextPeriod.getDate() + cycleLength);
        
        // Calculate fertile window
        const fertileStart = new Date(nextPeriod);
        fertileStart.setDate(fertileStart.getDate() - 14);
        const fertileEnd = new Date(nextPeriod);
        fertileEnd.setDate(fertileEnd.getDate() - 10);
        
        // Update display
        document.getElementById('next-period').textContent = nextPeriod.toLocaleDateString();
        document.getElementById('fertile-window').textContent = 
            fertileStart.toLocaleDateString() + ' - ' + fertileEnd.toLocaleDateString();
    });
    </script>
</body>
</html> 