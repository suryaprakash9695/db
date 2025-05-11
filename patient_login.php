<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
    <meta name="description" content="">


    <title>WeCare Patient Login</title>
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
        body {
            background: linear-gradient(135deg, #f0f8ff 0%, #ffffff 100%);
        }
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            padding: 1rem 1.2rem;
            font-size: 1.1rem;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
            background-color: #fff;
            transform: translateY(-2px);
        }
        .form-group label {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.7rem;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            font-size: 1.1rem;
            display: block;
            padding-left: 0.5rem;
        }
        .form-group:hover label {
            color: #3498db;
            transform: translateX(5px);
        }
        .card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(52, 152, 219, 0.15);
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #3498db, #2980b9);
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(52, 152, 219, 0.2);
        }
        .card-header {
            border-bottom: 2px solid rgba(52, 152, 219, 0.1);
            background: transparent;
            padding: 2rem 0 1.5rem;
        }
        .form-control {
            border: 2px solid rgba(52, 152, 219, 0.2);
            border-radius: 12px;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 1rem 1.2rem;
            font-size: 1.1rem;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
            background-color: #fff;
            transform: translateY(-2px);
        }
        .form-group label {
            color: #3498db;
            font-weight: 600;
            margin-bottom: 0.7rem;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            font-size: 1.1rem;
            display: block;
            padding-left: 0.5rem;
        }
        .form-group:hover label {
            color: #2980b9;
            transform: translateX(5px);
        }
        .form-control::placeholder {
            color: #aaa;
            font-size: 1rem;
            font-weight: 400;
            transition: all 0.3s ease;
        }
        .form-control:focus::placeholder {
            color: #3498db;
            opacity: 0.7;
            transform: translateX(5px);
        }
        .form-control:hover {
            border-color: #3498db;
            background-color: #fff;
        }

        /* Patient Login Page Specific Button */
        .patient-page-login-btn {
            border-radius: 12px;
            transition: all 0.3s ease;
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 1.2rem;
            padding: 1rem 0;
            position: relative;
            overflow: hidden;
            background: linear-gradient(45deg, #3498db, #2980b9);
            background-size: 200% 200%;
            animation: gradientBG 3s ease infinite;
            color: white;
            width: 100%;
        }

        .patient-page-login-btn:hover {
            background-color: #2980b9 !important;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(52, 152, 219, 0.3);
            color: white;
            text-decoration: none;
        }

        .patient-page-login-btn:active {
            transform: translateY(-1px);
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Enhanced Responsive Styles */
        @media (max-width: 991.98px) {
            .container {
                padding: 0 20px;
            }
            .card {
                min-width: 100% !important;
                margin: 0 15px;
            }
            .card-header h3 {
                font-size: 2rem !important;
            }
            .form-group label {
                font-size: 1.2rem !important;
            }
            .form-control {
                font-size: 1.1rem !important;
                padding: 1rem 1.2rem !important;
            }
            .btn {
                font-size: 1.3rem !important;
                padding: 1rem 0 !important;
            }
        }

        @media (max-width: 767.98px) {
            .container {
                margin-top: 40px !important;
            }
            .card {
                padding: 2rem 1.5rem !important;
            }
            .card-header {
                padding: 1.5rem 0 !important;
            }
            .card-header h3 {
                font-size: 1.8rem !important;
            }
            .form-group {
                margin-bottom: 1.5rem !important;
            }
            .form-group label {
                font-size: 1.1rem !important;
            }
            .form-control {
                font-size: 1rem !important;
                padding: 0.9rem 1.1rem !important;
            }
            .btn {
                font-size: 1.2rem !important;
                padding: 0.9rem 0 !important;
            }
        }

        @media (max-width: 575.98px) {
            .container {
                margin-top: 30px !important;
            }
            .card {
                padding: 1.5rem 1.2rem !important;
            }
            .card-header h3 {
                font-size: 1.6rem !important;
            }
            .form-group {
                margin-bottom: 1.2rem !important;
            }
            .form-group label {
                font-size: 1rem !important;
            }
            .form-control {
                font-size: 0.95rem !important;
                padding: 0.8rem 1rem !important;
            }
            .btn {
                font-size: 1.1rem !important;
                padding: 0.8rem 0 !important;
            }
        }

        /* Chatbot Button Styles */
        .chatbot-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(45deg, #3498db, #2980b9);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1000;
            border: none;
        }

        .chatbot-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .chatbot-button img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        /* Thinking Animation */
        .thinking {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background: #f0f8ff;
            border-radius: 10px;
            margin: 10px 0;
            width: fit-content;
        }

        .thinking span {
            width: 8px;
            height: 8px;
            background: #3498db;
            border-radius: 50%;
            margin: 0 2px;
            animation: thinking 1.4s infinite ease-in-out;
        }

        .thinking span:nth-child(1) { animation-delay: 0s; }
        .thinking span:nth-child(2) { animation-delay: 0.2s; }
        .thinking span:nth-child(3) { animation-delay: 0.4s; }

        @keyframes thinking {
            0%, 80%, 100% { transform: scale(0.6); }
            40% { transform: scale(1); }
        }

        .chatbot-container {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 350px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1000;
            overflow: hidden;
        }

        .chatbot-header {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .chatbot-body {
            padding: 20px;
            max-height: 400px;
            overflow-y: auto;
        }

        .chatbot-message {
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 10px;
            max-width: 80%;
        }

        .bot-message {
            background: #f0f8ff;
            margin-right: auto;
            border: 1px solid rgba(52, 152, 219, 0.1);
        }

        .user-message {
            background: #3498db;
            color: white;
            margin-left: auto;
        }

        .chatbot-input {
            display: flex;
            padding: 15px;
            border-top: 1px solid #eee;
        }

        .chatbot-input input {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 8px 15px;
            margin-right: 10px;
        }

        .chatbot-input button {
            background: #3498db;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            cursor: pointer;
        }

        .chatbot-input button:hover {
            background: #2980b9;
        }

        @media (max-width: 576px) {
            .chatbot-container {
                width: 300px;
                right: 20px;
                bottom: 90px;
            }
        }
    </style>
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<!-- Include Chatbot -->
<?php include 'chatbot/chatbot.php'; ?>

<div class="container" style="margin-top: 60px;">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-7 d-none d-lg-block text-center">
            <img src="assets/images/login.jpg" alt="Patient Login" class="img-fluid rounded shadow" style="max-width: 95%; min-height: 450px; object-fit: cover;">
        </div>
        <div class="col-lg-5 col-md-10">
            <div class="card shadow" style="padding: 2.5rem 2rem; min-width: 380px; background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);">
                <div class="card-header text-center" style="padding: 1.2rem 0;">
                    <h3 style="font-size: 2.4rem; margin-bottom: 0; font-family: 'Dancing Script', cursive; color: #3498db; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">Patient Login</h3>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group mb-4">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="patient-page-login-btn">Login to Dashboard</button>
                    </form>
                    <div class="mt-4 text-center">
                        <p class="mb-2" style="font-size: 1.1rem;">NOTE : For Login Details Contact to Admin</p>
                        <a href="admin_login.php" class="text-decoration-none" style="color: #3498db; font-weight: 600; font-size: 1.1rem;">Admin Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <a href="https://mobirise.site/e"></a>
    <script src="assets/web/assets/jquery/jquery.min.js"></script>
    <script src="assets/popper/popper.min.js"></script>
    <script src="assets/tether/tether.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/smoothscroll/smooth-scroll.js"></script>
    <script src="assets/parallax/jarallax.min.js"></script>
    <script src="assets/mbr-tabs/mbr-tabs.js"></script>
    <script src="assets/dropdown/js/nav-dropdown.js"></script>
    <script src="assets/dropdown/js/navbar-dropdown.js"></script>
    <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>
    <script src="assets/theme/js/script.js"></script>

<script>
    // Add conversation history array
    let conversationHistory = [];

    function generateResponse(message) {
        // Show thinking animation while waiting for AI response
        showThinking();
        
        // Add user message to history
        conversationHistory.push({
            role: 'user',
            content: message
        });
        
        // Use local proxy endpoint
        const proxyUrl = 'proxy.php';
        
        // Make API call through local proxy
        fetch(proxyUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                message: message,
                apiKey: 'YOUR_API_KEY_HERE',
                history: conversationHistory
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.error || `HTTP error! status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            // Remove thinking animation
            const thinking = document.querySelector('.thinking');
            if (thinking) {
                thinking.remove();
            }
            
            // Get AI response
            const aiResponse = data.response;
            
            // Add AI response to history
            conversationHistory.push({
                role: 'assistant',
                content: aiResponse
            });
            
            // Keep only last 10 messages to prevent token limit issues
            if (conversationHistory.length > 10) {
                conversationHistory = conversationHistory.slice(-10);
            }
            
            // Add response to chat
            const chatbotBody = document.getElementById('chatbotBody');
            chatbotBody.innerHTML += `
                <div class="chatbot-message bot-message">
                    ${aiResponse}
                </div>
            `;
            chatbotBody.scrollTop = chatbotBody.scrollHeight;
        })
        .catch(error => {
            console.error('Error:', error);
            // Remove thinking animation
            const thinking = document.querySelector('.thinking');
            if (thinking) {
                thinking.remove();
            }
            
            // More detailed error message with troubleshooting steps
            const chatbotBody = document.getElementById('chatbotBody');
            let errorMessage = '';
            
            if (error.message.includes('Rate limit exceeded')) {
                errorMessage = `
                    I apologize, but the system is currently busy. Please:
                    <br>1. Wait a few moments before trying again
                    <br>2. Try sending a shorter message
                    <br>3. If the issue persists, try again in a few minutes
                `;
            } else {
                errorMessage = `
                    I apologize, but I'm having trouble connecting to the AI service. Please try these steps:
                    <br>1. Make sure you're connected to the internet
                    <br>2. Check if the server is running
                    <br>3. Try refreshing the page
                    <br>4. Contact the admin if the issue persists
                    <br><br>
                    Error details: ${error.message}
                `;
            }
            
            chatbotBody.innerHTML += `
                <div class="chatbot-message bot-message">
                    ${errorMessage}
                </div>
            `;
            chatbotBody.scrollTop = chatbotBody.scrollHeight;
        });
    }

    // Add function to clear conversation history
    function clearConversationHistory() {
        conversationHistory = [];
        const chatbotBody = document.getElementById('chatbotBody');
        chatbotBody.innerHTML = `
            <div class="chatbot-message bot-message">
                Hello! I'm your WeCare assistant. How can I help you today?
            </div>
        `;
    }

    // Modify toggleChatbot to include clear history option
    function toggleChatbot() {
        const container = document.getElementById('chatbotContainer');
        container.style.display = container.style.display === 'none' ? 'block' : 'none';
        
        if (container.style.display === 'block') {
            testApiConnection();
        }
    }

    // Add clear history button to chatbot header
    document.querySelector('.chatbot-header').innerHTML += `
        <button onclick="clearConversationHistory()" style="
            float: right;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        " onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'"
           onmouseout="this.style.backgroundColor='transparent'">
            Clear Chat
        </button>
    `;

    function handleKeyPress(event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    }

    function showThinking() {
        const chatbotBody = document.getElementById('chatbotBody');
        chatbotBody.innerHTML += `
            <div class="thinking">
                <span></span>
                <span></span>
                <span></span>
            </div>
        `;
        chatbotBody.scrollTop = chatbotBody.scrollHeight;
    }

    function checkApiKey() {
        const apiKey = 'YOUR_API_KEY_HERE';
        if (!apiKey) {
            console.warn('API key is missing');
            return false;
        }
        return true;
    }

    // Add a function to test the API connection
    function testApiConnection() {
        const proxyUrl = 'proxy.php';
        
        fetch(proxyUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                message: 'Test connection',
                apiKey: 'YOUR_API_KEY_HERE'
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            console.log('API connection successful');
            return response.json();
        })
        .catch(error => {
            console.error('API connection failed:', error);
            // Show error in chatbot
            const chatbotBody = document.getElementById('chatbotBody');
            chatbotBody.innerHTML += `
                <div class="chatbot-message bot-message">
                    Connection test failed. Please check if the proxy server is running.
                    <br>Error: ${error.message}
                </div>
            `;
        });
    }

    // Modify sendMessage to include API key check
    function sendMessage() {
        const input = document.getElementById('userInput');
        const message = input.value.trim();
        
        if (message) {
            const chatbotBody = document.getElementById('chatbotBody');
            
            // Add user message
            chatbotBody.innerHTML += `
                <div class="chatbot-message user-message">
                    ${message}
                </div>
            `;
            
            // Clear input
            input.value = '';
            
            // Check API key before proceeding
            if (!checkApiKey()) {
                chatbotBody.innerHTML += `
                    <div class="chatbot-message bot-message">
                        I apologize, but the chatbot is not properly configured. Please contact the admin for assistance.
                    </div>
                `;
                return;
            }
            
            // Generate AI response
            generateResponse(message);
        }
    }
</script>

<?php include 'includes/footer.php'; ?>

</body>

</html>