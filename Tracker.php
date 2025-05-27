<?php
session_start();
require_once 'config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $last_period = $_POST['last_period'] ?? '';
    $cycle_length = $_POST['cycle_length'] ?? '';
    $mood = $_POST['mood'] ?? '';
    $flow = $_POST['flow'] ?? '';
    $symptoms = $_POST['symptoms'] ?? [];
    $notes = $_POST['notes'] ?? '';

    // Calculate next period date
    $next_period = date('Y-m-d', strtotime($last_period . ' + ' . $cycle_length . ' days'));
    
    // Calculate fertile window (5 days before and including ovulation)
    $ovulation = date('Y-m-d', strtotime($last_period . ' + 14 days'));
    $fertile_start = date('Y-m-d', strtotime($ovulation . ' - 5 days'));
    $fertile_end = date('Y-m-d', strtotime($ovulation . ' + 1 day'));

    // Save to database
    try {
        $stmt = $conn->prepare("INSERT INTO cycle_tracker (user_id, last_period, cycle_length, mood, flow, symptoms, notes, next_period, fertile_start, fertile_end) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $user_id = $_SESSION['user_id'] ?? 1; // Default to 1 if not logged in
        $symptoms_json = json_encode($symptoms);
        
        $stmt->bind_param("iissssssss", 
            $user_id, 
            $last_period, 
            $cycle_length, 
            $mood, 
            $flow, 
            $symptoms_json, 
            $notes, 
            $next_period, 
            $fertile_start, 
            $fertile_end
        );
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Cycle data updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating cycle data.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }
}

// Get user's cycle data
$cycle_data = [];
$symptom_data = [];
try {
    $user_id = $_SESSION['user_id'] ?? 1;
    $stmt = $conn->prepare("SELECT * FROM cycle_tracker WHERE user_id = ? ORDER BY last_period DESC LIMIT 6");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $cycle_data[] = [
            'date' => $row['last_period'],
            'length' => $row['cycle_length']
        ];
        $symptom_data[] = json_decode($row['symptoms'], true);
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Error fetching cycle data: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WeCare - Menstrual Cycle Tracker</title>
    <link rel="shortcut icon" href="assets/images/thrive_small_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/homepage.css">
    <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
    <link rel="stylesheet" href="assets/tether/tether.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="assets/dropdown/css/style.css">
    <link rel="stylesheet" href="assets/socicon/css/styles.css">
    <link rel="stylesheet" href="assets/theme/css/style.css">
    <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Gloock&family=Source+Serif+Pro:ital@0;1&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #ff69b4;
            --secondary-color: #f8f9fa;
            --accent-color: #ff1493;
            --text-color: #2c3e50;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --gradient: linear-gradient(135deg, #ff69b4, #ff1493);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff5f8;
            color: var(--text-color);
            line-height: 1.6;
        }

        .tracker-container {
            max-width: 1000px;
            margin: 3rem auto;
            padding: 2.5rem;
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        
        .tracker-header {
            text-align: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #eee;
            background: var(--gradient);
            margin: -2.5rem -2.5rem 3rem -2.5rem;
            padding: 3rem 2.5rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            color: white;
        }
        
        .tracker-header img {
            max-width: 120px;
            margin-bottom: 1.5rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
            transition: transform 0.3s ease;
            background: white;
            padding: 1rem;
            border-radius: 50%;
        }

        .tracker-header img:hover {
            transform: scale(1.05);
        }
        
        .tracker-header h1 {
            color: white;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .tracker-header .lead {
            color: rgba(255,255,255,0.9);
            font-size: 1.2rem;
        }

        .nav-pills {
            margin-bottom: 2rem;
            background: white;
            padding: 1rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .nav-pills .nav-link {
            color: var(--text-color);
            border-radius: 25px;
            padding: 0.8rem 1.5rem;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-pills .nav-link.active {
            background: var(--gradient);
            color: white;
        }

        .tracker-form {
            background: var(--secondary-color);
            padding: 2rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
        }
        
        .tracker-form h2 {
            color: var(--text-color);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 105, 180, 0.15);
        }
        
        .mood-flow-section {
            background: #fff;
            padding: 1.8rem;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .mood-flow-title {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            gap: 12px;
        }
        
        .mood-flow-title img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }
        
        .mood-flow-title h3 {
            margin: 0;
            color: var(--text-color);
            font-size: 1.2rem;
            font-weight: 500;
        }
        
        .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1.2rem;
            justify-content: center;
        }
        
        .radio-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 0.5rem 1rem;
            background: #f8f9fa;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .radio-label:hover {
            background: #e9ecef;
        }
        
        .radio-label input {
            margin-right: 8px;
        }
        
        .predict-button {
            background: var(--gradient);
            color: #fff;
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-weight: 500;
            width: 100%;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .predict-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .prediction-result {
            text-align: center;
            font-size: 1.1rem;
            color: var(--primary-color);
            margin: 1.5rem 0;
            padding: 1.5rem;
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .prediction-result .alert {
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .suggestions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .suggestion-card {
            background: #fff;
            padding: 1.8rem;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .suggestion-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .suggestion-card h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.3rem;
            font-weight: 500;
        }
        
        .suggestion-card p {
            color: #666;
            line-height: 1.7;
            font-size: 0.95rem;
            margin-bottom: 0.8rem;
        }

        .chart-container {
            background: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
        }

        .symptom-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .symptom-tag {
            background: var(--gradient);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .symptom-tag:hover {
            transform: scale(1.05);
        }

        .notes-section {
            margin-top: 2rem;
        }

        .notes-section textarea {
            width: 100%;
            min-height: 100px;
            padding: 1rem;
            border: 1px solid #e0e0e0;
            border-radius: var(--border-radius);
            resize: vertical;
        }

        .reminder-section {
            background: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            margin-top: 2rem;
            box-shadow: var(--box-shadow);
        }

        .reminder-section h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .reminder-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .reminder-item:last-child {
            border-bottom: none;
        }

        .reminder-item i {
            color: var(--primary-color);
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .tracker-container {
                margin: 1rem;
                padding: 1.5rem;
            }

            .nav-pills .nav-link {
                margin: 0.25rem;
                padding: 0.5rem 1rem;
            }

            .suggestions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container">
        <div class="tracker-container">
            <div class="tracker-header">
                <img src="assets/images/thrive_small_logo.png" alt="WeCare Logo">
                <h1>WeCare - Your Personal Cycle Companion</h1>
                <p class="lead">Track, understand, and take control of your menstrual health</p>
            </div>

            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-track-tab" data-bs-toggle="pill" data-bs-target="#pills-track" type="button" role="tab">Track Cycle</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-stats-tab" data-bs-toggle="pill" data-bs-target="#pills-stats" type="button" role="tab">Statistics</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-notes-tab" data-bs-toggle="pill" data-bs-target="#pills-notes" type="button" role="tab">Notes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-reminders-tab" data-bs-toggle="pill" data-bs-target="#pills-reminders" type="button" role="tab">Reminders</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-track" role="tabpanel">
                    <form class="tracker-form" method="post" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Last Period Start Date</label>
                                    <input type="date" class="form-control" name="last_period" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Cycle Length (days)</label>
                                    <input type="number" class="form-control" name="cycle_length" min="21" max="35" required>
                                </div>
                            </div>
                        </div>

                        <div class="mood-flow-section">
                            <div class="mood-flow-title">
                                <i class="fas fa-heart"></i>
                                <h3>How are you feeling today?</h3>
                            </div>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="mood" value="happy"> Happy
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="mood" value="calm"> Calm
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="mood" value="irritable"> Irritable
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="mood" value="anxious"> Anxious
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="mood" value="tired"> Tired
                                </label>
                            </div>
                        </div>

                        <div class="mood-flow-section">
                            <div class="mood-flow-title">
                                <i class="fas fa-tint"></i>
                                <h3>Flow Intensity</h3>
                            </div>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="flow" value="light"> Light
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="flow" value="medium"> Medium
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="flow" value="heavy"> Heavy
                                </label>
                            </div>
                        </div>

                        <div class="mood-flow-section">
                            <div class="mood-flow-title">
                                <i class="fas fa-exclamation-circle"></i>
                                <h3>Symptoms</h3>
                            </div>
                            <div class="symptom-tags">
                                <span class="symptom-tag">Cramps</span>
                                <span class="symptom-tag">Headache</span>
                                <span class="symptom-tag">Bloating</span>
                                <span class="symptom-tag">Breast Tenderness</span>
                                <span class="symptom-tag">Acne</span>
                                <span class="symptom-tag">Fatigue</span>
                                <span class="symptom-tag">Back Pain</span>
                                <span class="symptom-tag">Mood Swings</span>
                            </div>
                        </div>

                        <button type="submit" class="predict-button">
                            <i class="fas fa-calendar-alt"></i> Update Tracker
                        </button>
                    </form>
                </div>

                <div class="tab-pane fade" id="pills-stats" role="tabpanel">
                    <div class="chart-container">
                        <h3>Cycle Statistics</h3>
                        <canvas id="cycleChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <h3>Symptom Analysis</h3>
                        <canvas id="symptomChart"></canvas>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-notes" role="tabpanel">
                    <div class="notes-section">
                        <h3>Personal Notes</h3>
                        <textarea class="form-control" placeholder="How are you feeling today? Any special notes?"></textarea>
                        <button class="predict-button mt-3">Save Notes</button>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-reminders" role="tabpanel">
                    <div class="reminder-section">
                        <h3>Important Reminders</h3>
                        <div class="reminder-item">
                            <i class="fas fa-pills"></i>
                            <div>
                                <h5>Take your vitamins</h5>
                                <p>Daily at 9:00 AM</p>
                            </div>
                        </div>
                        <div class="reminder-item">
                            <i class="fas fa-calendar-check"></i>
                            <div>
                                <h5>Next period expected</h5>
                                <p>In 14 days</p>
                            </div>
                        </div>
                        <div class="reminder-item">
                            <i class="fas fa-heartbeat"></i>
                            <div>
                                <h5>Fertility window</h5>
                                <p>Starts in 5 days</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/web/assets/jquery/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
        // Initialize charts with real data
        const cycleCtx = document.getElementById('cycleChart').getContext('2d');
        const symptomCtx = document.getElementById('symptomChart').getContext('2d');

        // Prepare chart data from PHP
        const cycleData = <?php echo json_encode($cycle_data); ?>;
        const symptomData = <?php echo json_encode($symptom_data); ?>;

        // Cycle Chart
        new Chart(cycleCtx, {
            type: 'line',
            data: {
                labels: cycleData.map(item => new Date(item.date).toLocaleDateString('en-US', { month: 'short' })),
                datasets: [{
                    label: 'Cycle Length',
                    data: cycleData.map(item => item.length),
                    borderColor: '#ff69b4',
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Symptom Chart
        new Chart(symptomCtx, {
            type: 'radar',
            data: {
                labels: ['Cramps', 'Headache', 'Bloating', 'Breast Tenderness', 'Acne', 'Fatigue'],
                datasets: [{
                    label: 'Symptom Intensity',
                    data: calculateSymptomAverages(symptomData),
                    backgroundColor: 'rgba(255, 105, 180, 0.2)',
                    borderColor: '#ff69b4',
                    pointBackgroundColor: '#ff69b4'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 5
                    }
                }
            }
        });

        // Calculate average symptom intensities
        function calculateSymptomAverages(symptomData) {
            const symptoms = ['Cramps', 'Headache', 'Bloating', 'Breast Tenderness', 'Acne', 'Fatigue'];
            return symptoms.map(symptom => {
                const sum = symptomData.reduce((acc, curr) => {
                    return acc + (curr[symptom] || 0);
                }, 0);
                return sum / symptomData.length || 0;
            });
        }

        // Form submission handling
        document.querySelector('.tracker-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get selected symptoms
            const selectedSymptoms = {};
            document.querySelectorAll('.symptom-tag.active').forEach(tag => {
                selectedSymptoms[tag.textContent] = 1;
            });

            // Add symptoms to form data
            const formData = new FormData(this);
            formData.append('symptoms', JSON.stringify(selectedSymptoms));

            // Submit form
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                // Show success message
                const successAlert = document.createElement('div');
                successAlert.className = 'alert alert-success';
                successAlert.innerHTML = 'Cycle data updated successfully!';
                this.insertBefore(successAlert, this.firstChild);
                
                // Reset form after 2 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger';
                errorAlert.innerHTML = 'Error updating cycle data. Please try again.';
                this.insertBefore(errorAlert, this.firstChild);
            });
        });

        // Symptom tag selection
        document.querySelectorAll('.symptom-tag').forEach(tag => {
            tag.addEventListener('click', function() {
                this.classList.toggle('active');
                if (this.classList.contains('active')) {
                    this.style.background = '#ff1493';
                } else {
                    this.style.background = 'var(--gradient)';
                }
            });
        });

        // Notes saving
        document.querySelector('#pills-notes .predict-button').addEventListener('click', function() {
            const notes = document.querySelector('#pills-notes textarea').value;
            const formData = new FormData();
            formData.append('notes', notes);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                const successAlert = document.createElement('div');
                successAlert.className = 'alert alert-success';
                successAlert.innerHTML = 'Notes saved successfully!';
                document.querySelector('#pills-notes').insertBefore(successAlert, document.querySelector('#pills-notes .notes-section'));
                
                setTimeout(() => {
                    successAlert.remove();
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger';
                errorAlert.innerHTML = 'Error saving notes. Please try again.';
                document.querySelector('#pills-notes').insertBefore(errorAlert, document.querySelector('#pills-notes .notes-section'));
            });
        });
    </script>
</body>
</html>
