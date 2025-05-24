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
    
   <style>
        :root {
            --primary-color: #c80d7d;
            --secondary-color: #f8f9fa;
            --text-color: #2c3e50;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--text-color);
            line-height: 1.6;
        }

        .tracker-container {
            max-width: 900px;
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
        }
        
        .tracker-header img {
            max-width: 120px;
            margin-bottom: 1.5rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
            transition: transform 0.3s ease;
        }

        .tracker-header img:hover {
            transform: scale(1.05);
        }
        
        .tracker-header h1 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 2.2rem;
        }
        
        .tracker-header .lead {
            color: #666;
            font-size: 1.1rem;
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
            box-shadow: 0 0 0 0.2rem rgba(200, 13, 125, 0.15);
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
            background: var(--primary-color);
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
            background: #a00a65;
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
        }

        .suggestion-card:hover {
            transform: translateY(-5px);
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .tracker-container {
                margin: 1rem;
                padding: 1.5rem;
            }

            .tracker-header h1 {
                font-size: 1.8rem;
            }

            .radio-group {
                flex-direction: column;
                align-items: center;
            }

            .radio-label {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container">
        <div class="tracker-container">
            <div class="tracker-header">
                <img src="assets/images/tracker.png" alt="Period Tracker" class="img-fluid">
                <h1>Menstrual Cycle Tracker</h1>
                <p class="lead">Track your cycle and get personalized health recommendations</p>
            </div>
            
            <form id="trackerForm" class="tracker-form">
                <h2>Enter your last period details</h2>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Month</label>
                            <select class="form-control" name="month" required>
                                <option value="">Select Month</option>
                                <option value="Jan">January</option>
                                <option value="Feb">February</option>
                                <option value="Mar">March</option>
                                <option value="Apr">April</option>
                                <option value="May">May</option>
                                <option value="Jun">June</option>
                                <option value="Jul">July</option>
                                <option value="Aug">August</option>
                                <option value="Sep">September</option>
                                <option value="Oct">October</option>
                                <option value="Nov">November</option>
                                <option value="Dec">December</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end" required>
                        </div>
                    </div>
                </div>
                
                <div class="mood-flow-section">
                    <div class="mood-flow-title">
                        <img src="assets/images/flow.png" alt="Flow">
                        <h3>Flow Intensity</h3>
                    </div>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="flow" value="low" required> Low
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="flow" value="medium"> Medium
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="flow" value="high"> High
                        </label>
                    </div>
                </div>
                
                <div class="mood-flow-section">
                    <div class="mood-flow-title">
                        <img src="assets/images/mood.png" alt="Mood">
                        <h3>Mood</h3>
                    </div>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="mood" value="happy" required> Happy
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="mood" value="normal"> Normal
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="mood" value="stressed"> Stressed
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="mood" value="sad"> Sad
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="mood" value="anxious"> Anxious
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="predict-button">
                    <i class="fas fa-calendar-alt me-2"></i> Predict Your Next Period
                </button>
            </form>
            
            <div id="predictionResult" class="prediction-result" style="display: none;">
                <div class="alert alert-info">
                    <i class="fas fa-calendar-check me-2"></i>
                    Your next period is predicted to be on <span id="predictedDate"></span>
                </div>
                <div class="alert alert-warning">
                    <i class="fas fa-clock me-2"></i>
                    Fertile window: <span id="fertileWindow"></span>
                </div>
            </div>
            
            <div id="suggestions" class="suggestions" style="display: none;">
                <div class="suggestion-card">
                    <h3><i class="fas fa-utensils me-2"></i> Dietary Suggestions</h3>
                    <div id="dietSuggestions"></div>
                </div>
                
                <div class="suggestion-card">
                    <h3><i class="fas fa-dumbbell me-2"></i> Workout Suggestions</h3>
                    <div id="workoutSuggestions"></div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/web/assets/jquery/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
    document.getElementById('trackerForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate dates
        const start = new Date(this.start.value);
        const end = new Date(this.end.value);
        const today = new Date();

        if (start > end) {
            alert('Start date cannot be after end date');
            return;
        }

        if (start > today || end > today) {
            alert('Dates cannot be in the future');
            return;
        }

        // Calculate cycle length (average of last 3 cycles if available)
        const cycleLength = 28; // Default cycle length
        const nextPeriod = new Date(start.getTime() + cycleLength * 24 * 60 * 60 * 1000);
        const predictedDate = nextPeriod.toISOString().split('T')[0];

        // Calculate fertile window (5 days before and including ovulation)
        const ovulation = new Date(start.getTime() + 14 * 24 * 60 * 60 * 1000);
        const fertileStart = new Date(ovulation.getTime() - 5 * 24 * 60 * 60 * 1000);
        const fertileEnd = new Date(ovulation.getTime() + 1 * 24 * 60 * 60 * 1000);
        
        const fertileWindow = `${fertileStart.toISOString().split('T')[0]} to ${fertileEnd.toISOString().split('T')[0]}`;

        // Show prediction
        document.getElementById('predictedDate').textContent = predictedDate;
        document.getElementById('fertileWindow').textContent = fertileWindow;
        document.getElementById('predictionResult').style.display = 'block';
        document.getElementById('suggestions').style.display = 'grid';

        // Get mood and flow values
        const mood = document.querySelector('input[name="mood"]:checked')?.value;
        const flow = document.querySelector('input[name="flow"]:checked')?.value;

        // Generate personalized suggestions
        let diet = '';
        let workout = '';

        // Diet suggestions based on cycle phase and mood
        if (today > ovulation) {
            diet = `
                <p>Consider taking more carbohydrates to maintain good energy levels while working out.</p>
                <p>Increase protein intake because generally breakdown of muscles is increased during this phase.</p>
                <p>Keep yourself hydrated, drink enough water.</p>
                <p>Take diet focusing more on fibre and consume food which induces melatonin, it helps in getting good sleep.</p>
                <p>Target nutrient rich food and reduce junk and processed food.</p>
            `;
        } else {
            diet = `
                <p>Increase anti-inflammatory foods like fish oils, calcium, Vitamin-D.</p>
                <p>Consume more protein and restore iron levels.</p>
                <p>Take in more anti-oxidants; helps in maintenance of menstrual cycle.</p>
                <p>Increase food with carbohydrates like raisin, sweet potato etc.</p>
                <p>Include sources of collagen such as jelly alongside Vitamin C.</p>
            `;
        }

        // Add mood-specific diet suggestions
        if (mood === 'stressed' || mood === 'anxious') {
            diet += `
                <p>Include magnesium-rich foods like dark chocolate, nuts, and leafy greens.</p>
                <p>Consider chamomile tea or other calming herbal teas.</p>
            `;
        }

        // Workout suggestions based on flow and cycle phase
        if (flow === 'high') {
            workout = `
                <p>Light walking or gentle stretching</p>
                <p>Yoga or meditation</p>
                <p>Avoid intense workouts</p>
            `;
        } else if (today > ovulation) {
            workout = `
                <p>Endurance training</p>
                <p>Low-intensity weight training</p>
                <p>Light strength training</p>
            `;
        } else {
            workout = `
                <p>High intensity strength training</p>
                <p>Intensive cardio workout</p>
                <p>Weight training</p>
                <p>Strength training</p>
            `;
        }

        // Add mood-specific workout suggestions
        if (mood === 'sad' || mood === 'stressed') {
            workout += `
                <p>Consider gentle yoga or meditation</p>
                <p>Outdoor walking or light jogging</p>
            `;
        }

        document.getElementById('dietSuggestions').innerHTML = diet;
        document.getElementById('workoutSuggestions').innerHTML = workout;

        // Save data to server
        const formData = new FormData(this);
        formData.append('predictedDate', predictedDate);
        formData.append('fertileWindow', fertileWindow);

        fetch('save_tracker.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Error saving data:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
    </script>
</body>
</html>
