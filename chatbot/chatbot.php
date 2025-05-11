<!-- Chatbot Button -->
<button class="chatbot-button" onclick="toggleChatbot()">
    <img src="assets/images/chatbot-icon.png" alt="Chatbot" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjxwYXRoIGQ9Ik0yMSAxNWE5IDkgMCAwIDEtOSA5IDkgOSAwIDAgMS05LTkgOSA5IDAgMCAxIDktOXoiPjwvcGF0aD48cGF0aCBkPSJNOCAxMmg4TTggMTZoOCI+PC9wYXRoPjwvc3ZnPg=='">
</button>

<!-- Chatbot Interface -->
<div class="chatbot-container" id="chatbotContainer">
    <div class="chatbot-header">
        <h3>WeCare Assistant</h3>
        <button class="close-button" onclick="toggleChatbot()">×</button>
    </div>
    <div class="chatbot-messages" id="chatbotMessages">
        <div class="message bot">
            Hello! I'm your WeCare assistant. How can I help you today?
        </div>
    </div>
    <div class="chatbot-input">
        <input type="text" id="userInput" placeholder="Type your message..." onkeypress="handleKeyPress(event)">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<style>
.chatbot-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #ea0faa;
    border: none;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

.chatbot-button:hover {
    transform: scale(1.1);
}

.chatbot-button img {
    width: 30px;
    height: 30px;
}

.chatbot-container {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    display: none;
    flex-direction: column;
    z-index: 1000;
}

.chatbot-header {
    background: #ea0faa;
    color: white;
    padding: 15px;
    border-radius: 10px 10px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chatbot-header h3 {
    margin: 0;
    font-size: 1.2em;
}

.close-button {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
}

.chatbot-messages {
    flex-grow: 1;
    padding: 15px;
    overflow-y: auto;
}

.message {
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 10px;
    max-width: 80%;
}

.message.user {
    background: #e3f2fd;
    margin-left: auto;
}

.message.bot {
    background: #f5f5f5;
    margin-right: auto;
}

.chatbot-input {
    padding: 15px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
}

.chatbot-input input {
    flex-grow: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    outline: none;
}

.chatbot-input button {
    padding: 10px 20px;
    background: #ea0faa;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.chatbot-input button:hover {
    background: #c80d8d;
}
</style>

<script>
let conversationHistory = [];

function toggleChatbot() {
    const container = document.getElementById('chatbotContainer');
    container.style.display = container.style.display === 'none' ? 'flex' : 'none';
}

function handleKeyPress(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

function addMessage(content, isUser = false) {
    const messagesDiv = document.getElementById('chatbotMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${isUser ? 'user' : 'bot'}`;
    messageDiv.textContent = content;
    messagesDiv.appendChild(messageDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

async function sendMessage() {
    const input = document.getElementById('userInput');
    const message = input.value.trim();
    
    if (!message) return;
    
    // Add user message to chat
    addMessage(message, true);
    input.value = '';
    
    // Add message to conversation history
    conversationHistory.push({
        role: 'user',
        content: message
    });
    
    try {
        const response = await fetch('chatbot/proxy.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                message: message,
                history: conversationHistory,
                apiKey: 'YOUR_OPENAI_API_KEY' // Replace with your actual API key
            })
        });
        
        const data = await response.json();
        
        if (data.error) {
            addMessage('Sorry, I encountered an error. Please try again later.');
        } else {
            addMessage(data.response);
            conversationHistory.push({
                role: 'assistant',
                content: data.response
            });
        }
    } catch (error) {
        addMessage('Sorry, I encountered an error. Please try again later.');
    }
}
</script> 