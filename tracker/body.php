<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $last_period = $_POST['last_period'];
    $cycle_length = (int)$_POST['cycle_length'];
    $mood = $_POST['mood'];
    $flow = $_POST['flow'];
    $symptoms = isset($_POST['symptoms']) ? json_encode($_POST['symptoms']) : '[]';
    $notes = $_POST['notes'];

    // Calculate next period and fertile window
    $next_period = date('Y-m-d', strtotime($last_period . ' + ' . $cycle_length . ' days'));
    $fertile_start = date('Y-m-d', strtotime($next_period . ' - 14 days'));
    $fertile_end = date('Y-m-d', strtotime($next_period . ' - 10 days'));

    // Save to database
    $stmt = $conn->prepare("INSERT INTO cycle_tracker (user_id, last_period, cycle_length, mood, flow, symptoms, notes, next_period, fertile_start, fertile_end) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssss", $user_id, $last_period, $cycle_length, $mood, $flow, $symptoms, $notes, $next_period, $fertile_start, $fertile_end);
    
    if ($stmt->execute()) {
        $success_message = "Your cycle data has been saved successfully!";
    } else {
        $error_message = "Error saving data: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch user's cycle data
$user_id = $_SESSION['user_id'];
$cycle_data = [];
$stmt = $conn->prepare("SELECT * FROM cycle_tracker WHERE user_id = ? ORDER BY created_at DESC LIMIT 6");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $cycle_data[] = $row;
}
$stmt->close();
?>

<div class="tracker-container">
    <div class="tracker-header">
        <h1>Menstrual Cycle Tracker</h1>
        <p>Track your cycle, understand your body better</p>
    </div>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <div class="tracker-content">
        <div class="tracker-form">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="last_period">Last Period Date</label>
                    <input type="date" class="form-control" id="last_period" name="last_period" required>
                </div>

                <div class="form-group">
                    <label for="cycle_length">Cycle Length (days)</label>
                    <input type="number" class="form-control" id="cycle_length" name="cycle_length" min="21" max="35" value="28" required>
                </div>

                <div class="form-group">
                    <label>Mood</label>
                    <div class="mood-selector">
                        <input type="radio" name="mood" value="happy" id="mood-happy" required>
                        <label for="mood-happy">😊 Happy</label>
                        
                        <input type="radio" name="mood" value="calm" id="mood-calm">
                        <label for="mood-calm">😌 Calm</label>
                        
                        <input type="radio" name="mood" value="irritable" id="mood-irritable">
                        <label for="mood-irritable">😠 Irritable</label>
                        
                        <input type="radio" name="mood" value="anxious" id="mood-anxious">
                        <label for="mood-anxious">😰 Anxious</label>
                        
                        <input type="radio" name="mood" value="tired" id="mood-tired">
                        <label for="mood-tired">😴 Tired</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Flow Intensity</label>
                    <div class="flow-selector">
                        <input type="radio" name="flow" value="light" id="flow-light" required>
                        <label for="flow-light">Light</label>
                        
                        <input type="radio" name="flow" value="medium" id="flow-medium">
                        <label for="flow-medium">Medium</label>
                        
                        <input type="radio" name="flow" value="heavy" id="flow-heavy">
                        <label for="flow-heavy">Heavy</label>
                    </div>
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
                        
                        <input type="checkbox" name="symptoms[]" value="acne" id="symptom-acne">
                        <label for="symptom-acne">Acne</label>
                        
                        <input type="checkbox" name="symptoms[]" value="fatigue" id="symptom-fatigue">
                        <label for="symptom-fatigue">Fatigue</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="How are you feeling today?"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Entry</button>
            </form>
        </div>

        <div class="tracker-stats">
            <h2>Your Cycle Statistics</h2>
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Next Period</h3>
                    <p id="next-period">-</p>
                </div>
                <div class="stat-card">
                    <h3>Fertile Window</h3>
                    <p id="fertile-window">-</p>
                </div>
                <div class="stat-card">
                    <h3>Average Cycle Length</h3>
                    <p id="avg-cycle">-</p>
                </div>
            </div>
            <div class="charts-container">
                <canvas id="cycleChart"></canvas>
                <canvas id="symptomChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
// Pass PHP data to JavaScript
const cycleData = <?php echo json_encode($cycle_data); ?>;
</script> 