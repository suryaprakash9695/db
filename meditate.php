<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meditation | WeCare</title>
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
            padding-top: 80px; /* Add padding for fixed navbar */
        }

        /* Navbar specific styles */
        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand img {
            height: 50px;
        }

        .nav-link {
            color: var(--dark-text) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .nav-link.active {
            color: var(--primary-color) !important;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            border-radius: 12px;
        }

        .dropdown-item {
            padding: 0.8rem 1.5rem;
            color: var(--dark-text);
        }

        .dropdown-item:hover {
            background-color: #fff5f8;
            color: var(--primary-color);
        }

        /* Rest of your existing styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .meditation-header {
            text-align: center;
            margin-bottom: 3rem;
            padding-top: 2rem;
        }

        .meditation-header h1 {
            color: var(--primary-color);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .meditation-header p {
            color: var(--light-text);
            font-size: 1.1rem;
        }

        .meditation-categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .category-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-5px);
        }

        .category-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .category-card h3 {
            color: var(--dark-text);
            margin-bottom: 0.5rem;
        }

        .category-card p {
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .meditation-player {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 3rem;
            display: none;
        }

        .player-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .player-title {
            font-size: 1.5rem;
            color: var(--dark-text);
        }

        .timer-display {
            font-size: 3rem;
            text-align: center;
            margin: 2rem 0;
            color: var(--primary-color);
        }

        .controls {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .control-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-color);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .control-btn:hover {
            transform: scale(1.1);
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: var(--border-color);
            border-radius: 3px;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .progress {
            width: 0%;
            height: 100%;
            background: var(--primary-color);
            transition: width 0.1s linear;
        }

        .ambient-sounds {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .sound-btn {
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sound-btn:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .sound-btn.active {
            border-color: var(--primary-color);
            background: var(--primary-color);
            color: white;
        }

        .session-history {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .history-title {
            font-size: 1.5rem;
            color: var(--dark-text);
        }

        .history-list {
            list-style: none;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .history-item:last-child {
            border-bottom: none;
        }

        .history-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .history-info i {
            color: var(--primary-color);
        }

        .history-duration {
            color: var(--light-text);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .meditation-header h1 {
                font-size: 2rem;
            }

            .controls {
                gap: 1rem;
            }

            .timer-display {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container">
        <div class="meditation-header">
            <h1>Meditation & Mindfulness</h1>
            <p>Find your inner peace with guided meditation sessions</p>
        </div>

        <div class="meditation-categories">
            <div class="category-card" data-category="mindfulness">
                <i class="fas fa-brain"></i>
                <h3>Mindfulness</h3>
                <p>Focus on the present moment</p>
            </div>
            <div class="category-card" data-category="breathing">
                <i class="fas fa-wind"></i>
                <h3>Breathing</h3>
                <p>Calm your mind with breathing exercises</p>
            </div>
            <div class="category-card" data-category="sleep">
                <i class="fas fa-moon"></i>
                <h3>Sleep</h3>
                <p>Relax and prepare for better sleep</p>
            </div>
            <div class="category-card" data-category="stress">
                <i class="fas fa-spa"></i>
                <h3>Stress Relief</h3>
                <p>Release tension and find calm</p>
            </div>
        </div>

        <div class="meditation-player" id="meditationPlayer">
            <div class="player-header">
                <h2 class="player-title">Mindfulness Meditation</h2>
                <button class="control-btn" id="closePlayer">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="timer-display">10:00</div>
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
            <div class="controls">
                <button class="control-btn" id="prevBtn">
                    <i class="fas fa-step-backward"></i>
                </button>
                <button class="control-btn" id="playBtn">
                    <i class="fas fa-play"></i>
                </button>
                <button class="control-btn" id="nextBtn">
                    <i class="fas fa-step-forward"></i>
                </button>
            </div>
            <div class="ambient-sounds">
                <button class="sound-btn" data-sound="rain">
                    <i class="fas fa-cloud-rain"></i>
                    <p>Rain</p>
                </button>
                <button class="sound-btn" data-sound="forest">
                    <i class="fas fa-tree"></i>
                    <p>Forest</p>
                </button>
                <button class="sound-btn" data-sound="ocean">
                    <i class="fas fa-water"></i>
                    <p>Ocean</p>
                </button>
                <button class="sound-btn" data-sound="fire">
                    <i class="fas fa-fire"></i>
                    <p>Fire</p>
                </button>
            </div>
        </div>

        <div class="session-history">
            <div class="history-header">
                <h2 class="history-title">Recent Sessions</h2>
            </div>
            <ul class="history-list">
                <li class="history-item">
                    <div class="history-info">
                        <i class="fas fa-brain"></i>
                        <div>
                            <h4>Mindfulness Meditation</h4>
                            <p>Today, 10:30 AM</p>
                        </div>
                    </div>
                    <span class="history-duration">10 min</span>
                </li>
                <li class="history-item">
                    <div class="history-info">
                        <i class="fas fa-wind"></i>
                        <div>
                            <h4>Breathing Exercise</h4>
                            <p>Yesterday, 8:15 PM</p>
                        </div>
                    </div>
                    <span class="history-duration">5 min</span>
                </li>
            </ul>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryCards = document.querySelectorAll('.category-card');
            const meditationPlayer = document.getElementById('meditationPlayer');
            const closePlayer = document.getElementById('closePlayer');
            const playBtn = document.getElementById('playBtn');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const timerDisplay = document.querySelector('.timer-display');
            const progressBar = document.querySelector('.progress');
            const soundBtns = document.querySelectorAll('.sound-btn');

            let isPlaying = false;
            let currentTime = 600; // 10 minutes in seconds
            let timer;

            // Show meditation player when category is selected
            categoryCards.forEach(card => {
                card.addEventListener('click', () => {
                    meditationPlayer.style.display = 'block';
                    document.querySelector('.player-title').textContent = card.querySelector('h3').textContent;
                });
            });

            // Close meditation player
            closePlayer.addEventListener('click', () => {
                meditationPlayer.style.display = 'none';
                stopTimer();
            });

            // Play/Pause functionality
            playBtn.addEventListener('click', () => {
                if (isPlaying) {
                    stopTimer();
                    playBtn.innerHTML = '<i class="fas fa-play"></i>';
                } else {
                    startTimer();
                    playBtn.innerHTML = '<i class="fas fa-pause"></i>';
                }
                isPlaying = !isPlaying;
            });

            // Timer functionality
            function startTimer() {
                timer = setInterval(() => {
                    currentTime--;
                    updateDisplay();
                    updateProgress();
                    
                    if (currentTime <= 0) {
                        stopTimer();
                        playBtn.innerHTML = '<i class="fas fa-play"></i>';
                        isPlaying = false;
                    }
                }, 1000);
            }

            function stopTimer() {
                clearInterval(timer);
            }

            function updateDisplay() {
                const minutes = Math.floor(currentTime / 60);
                const seconds = currentTime % 60;
                timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }

            function updateProgress() {
                const progress = ((600 - currentTime) / 600) * 100;
                progressBar.style.width = `${progress}%`;
            }

            // Sound selection
            soundBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    soundBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                });
            });

            // Reset timer
            function resetTimer() {
                currentTime = 600;
                updateDisplay();
                updateProgress();
            }

            // Previous/Next buttons
            prevBtn.addEventListener('click', () => {
                resetTimer();
                stopTimer();
                playBtn.innerHTML = '<i class="fas fa-play"></i>';
                isPlaying = false;
            });

            nextBtn.addEventListener('click', () => {
                resetTimer();
                stopTimer();
                playBtn.innerHTML = '<i class="fas fa-play"></i>';
                isPlaying = false;
            });
        });
    </script>
</body>

</html>