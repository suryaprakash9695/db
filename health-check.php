<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Check | WeCare</title>
    <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
    <!-- Required CSS files for navbar -->
    <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
    <link rel="stylesheet" href="assets/tether/tether.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="assets/dropdown/css/style.css">
    <link rel="stylesheet" href="assets/socicon/css/styles.css">
    <link rel="stylesheet" href="assets/theme/css/style.css">
    <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css">
    <!-- Additional CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #c80d7d;
            --secondary-color: #f06292;
            --accent-color: #ff9800;
            --light-bg: #f5f5f5;
            --dark-text: #333;
            --light-text: #666;
            --border-color: #e0e0e0;
            --success-color: #4CAF50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--light-bg);
            color: var(--dark-text);
            line-height: 1.6;
            padding-top: 80px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .health-check-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .health-check-header h1 {
            color: var(--primary-color);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .health-check-header p {
            color: var(--light-text);
            font-size: 1.1rem;
        }

        .check-categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .check-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .check-card:hover {
            transform: translateY(-5px);
        }

        .check-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .check-card h3 {
            color: var(--dark-text);
            margin-bottom: 0.5rem;
        }

        .check-card p {
            color: var(--light-text);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .check-form {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 3rem;
            display: none;
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .form-title {
            font-size: 1.5rem;
            color: var(--dark-text);
        }

        .close-form {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--light-text);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-form:hover {
            color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark-text);
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .radio-group {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .submit-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background: var(--secondary-color);
        }

        .results {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: none;
        }

        .result-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .result-score {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .result-message {
            color: var(--light-text);
            margin-bottom: 2rem;
        }

        .recommendations {
            background: #fff5f8;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .recommendations h4 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .recommendations ul {
            list-style: none;
        }

        .recommendations li {
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
            position: relative;
        }

        .recommendations li:before {
            content: "•";
            color: var(--primary-color);
            position: absolute;
            left: 0;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .health-check-header h1 {
                font-size: 2rem;
            }

            .check-categories {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container">
        <div class="health-check-header">
            <h1>Health Check</h1>
            <p>Assess your physical and mental well-being with our comprehensive health check</p>
        </div>

        <div class="check-categories">
            <div class="check-card" data-check="physical">
                <i class="fas fa-heartbeat"></i>
                <h3>Physical Health</h3>
                <p>Evaluate your physical well-being, including sleep, diet, and exercise habits</p>
            </div>
            <div class="check-card" data-check="mental">
                <i class="fas fa-brain"></i>
                <h3>Mental Health</h3>
                <p>Assess your mental well-being, stress levels, and emotional health</p>
            </div>
            <div class="check-card" data-check="lifestyle">
                <i class="fas fa-walking"></i>
                <h3>Lifestyle</h3>
                <p>Review your daily habits and lifestyle choices affecting your health</p>
            </div>
        </div>

        <!-- Physical Health Form -->
        <div class="check-form" id="physicalForm">
            <div class="form-header">
                <h2 class="form-title">Physical Health Assessment</h2>
                <button class="close-form">&times;</button>
            </div>
            <form id="physicalHealthForm">
                <div class="form-group">
                    <label>How many hours of sleep do you get on average?</label>
                    <select class="form-control" name="sleep_hours" required>
                        <option value="">Select hours</option>
                        <option value="1">Less than 5 hours</option>
                        <option value="2">5-6 hours</option>
                        <option value="3">7-8 hours</option>
                        <option value="4">More than 8 hours</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>How often do you exercise?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="exercise" value="1" required> Never
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="exercise" value="2"> Sometimes
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="exercise" value="3"> Regularly
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>How would you rate your diet?</label>
                    <select class="form-control" name="diet" required>
                        <option value="">Select rating</option>
                        <option value="1">Poor</option>
                        <option value="2">Fair</option>
                        <option value="3">Good</option>
                        <option value="4">Excellent</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Submit Assessment</button>
            </form>
        </div>

        <!-- Mental Health Form -->
        <div class="check-form" id="mentalForm">
            <div class="form-header">
                <h2 class="form-title">Mental Health Assessment</h2>
                <button class="close-form">&times;</button>
            </div>
            <form id="mentalHealthForm">
                <div class="form-group">
                    <label>How often do you feel stressed?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="stress" value="1" required> Never
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="stress" value="2"> Sometimes
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="stress" value="3"> Often
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="stress" value="4"> Always
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>How would you rate your mood lately?</label>
                    <select class="form-control" name="mood" required>
                        <option value="">Select rating</option>
                        <option value="1">Poor</option>
                        <option value="2">Fair</option>
                        <option value="3">Good</option>
                        <option value="4">Excellent</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>How often do you practice mindfulness or meditation?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="mindfulness" value="1" required> Never
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="mindfulness" value="2"> Sometimes
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="mindfulness" value="3"> Regularly
                        </label>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Submit Assessment</button>
            </form>
        </div>

        <!-- Lifestyle Form -->
        <div class="check-form" id="lifestyleForm">
            <div class="form-header">
                <h2 class="form-title">Lifestyle Assessment</h2>
                <button class="close-form">&times;</button>
            </div>
            <form id="lifestyleForm">
                <div class="form-group">
                    <label>How often do you consume alcohol?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="alcohol" value="1" required> Never
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="alcohol" value="2"> Occasionally
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="alcohol" value="3"> Regularly
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Do you smoke?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="smoking" value="1" required> Never
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="smoking" value="2"> Occasionally
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="smoking" value="3"> Regularly
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>How would you rate your work-life balance?</label>
                    <select class="form-control" name="work_life_balance" required>
                        <option value="">Select rating</option>
                        <option value="1">Poor</option>
                        <option value="2">Fair</option>
                        <option value="3">Good</option>
                        <option value="4">Excellent</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Submit Assessment</button>
            </form>
        </div>

        <!-- Results Section -->
        <div class="results" id="results">
            <div class="result-header">
                <div class="result-score">85%</div>
                <p class="result-message">Your health assessment results</p>
            </div>
            <div class="recommendations">
                <h4>Recommendations</h4>
                <ul>
                    <li>Get 7-8 hours of sleep each night</li>
                    <li>Exercise for at least 30 minutes daily</li>
                    <li>Practice mindfulness meditation</li>
                    <li>Maintain a balanced diet</li>
                </ul>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkCards = document.querySelectorAll('.check-card');
            const forms = document.querySelectorAll('.check-form');
            const closeButtons = document.querySelectorAll('.close-form');
            const results = document.getElementById('results');

            // Show form when card is clicked
            checkCards.forEach(card => {
                card.addEventListener('click', () => {
                    const checkType = card.dataset.check;
                    forms.forEach(form => {
                        form.style.display = 'none';
                    });
                    document.getElementById(`${checkType}Form`).style.display = 'block';
                    results.style.display = 'none';
                });
            });

            // Close form when close button is clicked
            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    forms.forEach(form => {
                        form.style.display = 'none';
                    });
                });
            });

            // Handle form submissions
            const physicalForm = document.getElementById('physicalHealthForm');
            const mentalForm = document.getElementById('mentalHealthForm');
            const lifestyleForm = document.getElementById('lifestyleForm');

            function calculateScore(formData) {
                let score = 0;
                let totalQuestions = 0;

                for (let [key, value] of formData.entries()) {
                    score += parseInt(value);
                    totalQuestions++;
                }

                return Math.round((score / (totalQuestions * 4)) * 100);
            }

            function showResults(score) {
                forms.forEach(form => {
                    form.style.display = 'none';
                });
                results.style.display = 'block';
                document.querySelector('.result-score').textContent = `${score}%`;

                // Update recommendations based on score
                const recommendations = document.querySelector('.recommendations ul');
                recommendations.innerHTML = '';

                if (score < 60) {
                    recommendations.innerHTML = `
                        <li>Schedule a consultation with a healthcare provider</li>
                        <li>Start with small, achievable health goals</li>
                        <li>Consider joining a support group</li>
                        <li>Practice stress management techniques</li>
                    `;
                } else if (score < 80) {
                    recommendations.innerHTML = `
                        <li>Get 7-8 hours of sleep each night</li>
                        <li>Exercise for at least 30 minutes daily</li>
                        <li>Practice mindfulness meditation</li>
                        <li>Maintain a balanced diet</li>
                    `;
                } else {
                    recommendations.innerHTML = `
                        <li>Keep up the good work!</li>
                        <li>Continue your healthy habits</li>
                        <li>Share your knowledge with others</li>
                        <li>Set new health goals</li>
                    `;
                }
            }

            physicalForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(physicalForm);
                const score = calculateScore(formData);
                showResults(score);
            });

            mentalForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(mentalForm);
                const score = calculateScore(formData);
                showResults(score);
            });

            lifestyleForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(lifestyleForm);
                const score = calculateScore(formData);
                showResults(score);
            });
        });
    </script>
</body>
</html> 