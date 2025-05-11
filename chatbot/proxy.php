<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['message']) || !isset($data['apiKey'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}

// Verify API key
$validApiKey = 'YOUR_API_KEY'; // Replace with your actual API key
if ($data['apiKey'] !== $validApiKey) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid API key']);
    exit;
}

// Simple response system based on keywords
function getResponse($message) {
    $message = strtolower($message);
    
    // Common healthcare-related keywords and responses
    $responses = [
        'hello' => 'Hello! How can I help you today?',
        'hi' => 'Hi there! How can I assist you?',
        'help' => 'I can help you with general healthcare information, appointment scheduling, and basic medical queries. What would you like to know?',
        'appointment' => 'To schedule an appointment, please visit our appointment booking page or contact our reception.',
        'doctor' => 'We have qualified doctors available. Would you like to know about our specialties or schedule a consultation?',
        'emergency' => 'If this is a medical emergency, please call emergency services immediately.',
        'hours' => 'Our clinic is open Monday to Friday, 9 AM to 6 PM, and Saturday, 9 AM to 1 PM.',
        'location' => 'We are located at [Your Clinic Address]. Would you like directions?',
        'insurance' => 'We accept most major insurance providers. Please contact our billing department for specific coverage details.',
        'prescription' => 'For prescription refills, please contact your doctor or visit our prescription request page.',
        'test' => 'We offer various diagnostic tests. Please specify which test you're interested in.',
        'payment' => 'We accept cash, credit cards, and insurance. For payment plans, please contact our billing department.',
        'login' => 'For login issues, please contact our admin support.',
        'register' => 'To register as a new patient, please visit our registration page or contact our reception.',
        'thank' => 'You\'re welcome! Is there anything else I can help you with?',
        'bye' => 'Thank you for chatting with me. Take care!'
    ];
    
    // Check for keywords in the message
    foreach ($responses as $keyword => $response) {
        if (strpos($message, $keyword) !== false) {
            return $response;
        }
    }
    
    // Default response if no keywords match
    return "I'm sorry, I don't have specific information about that. For detailed assistance, please contact our staff or visit our website.";
}

// Get response based on the message
$response = getResponse($data['message']);

// Return the response
echo json_encode(['response' => $response]);
?> 