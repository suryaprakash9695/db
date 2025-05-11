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

// OpenAI API endpoint
$apiUrl = 'https://api.openai.com/v1/chat/completions';

// Function to make API request with retry logic
function makeApiRequest($url, $headers, $data, $maxRetries = 3) {
    $retryCount = 0;
    $retryDelay = 1; // Initial delay in seconds
    
    while ($retryCount < $maxRetries) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if ($httpCode === 429) {
            // Rate limit hit, wait and retry
            $retryCount++;
            if ($retryCount < $maxRetries) {
                sleep($retryDelay);
                $retryDelay *= 2; // Exponential backoff
                continue;
            }
        }
        
        curl_close($ch);
        return ['code' => $httpCode, 'response' => $response];
    }
    
    return ['code' => 429, 'response' => 'Rate limit exceeded after ' . $maxRetries . ' retries'];
}

// Prepare the request
$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $data['apiKey']
];

// Prepare the messages array with conversation history
$messages = [
    [
        'role' => 'system',
        'content' => 'You are a helpful healthcare assistant for WeCare. Provide concise, professional responses. For login, registration, or account issues, direct users to contact the admin.'
    ]
];

// Add conversation history if available
if (isset($data['history']) && is_array($data['history'])) {
    foreach ($data['history'] as $message) {
        if (isset($message['role']) && isset($message['content'])) {
            $messages[] = [
                'role' => $message['role'],
                'content' => $message['content']
            ];
        }
    }
}

// Add the current message
$messages[] = [
    'role' => 'user',
    'content' => $data['message']
];

// Prepare the request data
$requestData = [
    'model' => 'gpt-3.5-turbo',
    'messages' => $messages,
    'max_tokens' => 150,
    'temperature' => 0.7
];

// Make the API request with retry logic
$result = makeApiRequest($apiUrl, $headers, $requestData);

if ($result['code'] === 429) {
    http_response_code(429);
    echo json_encode([
        'error' => 'Rate limit exceeded',
        'message' => 'Please wait a moment before trying again. The system is currently processing many requests.'
    ]);
    exit;
}

if ($result['code'] !== 200) {
    http_response_code($result['code']);
    echo json_encode(['error' => 'API error: ' . $result['response']]);
    exit;
}

// Process the response
$responseData = json_decode($result['response'], true);
if (isset($responseData['choices'][0]['message']['content'])) {
    echo json_encode(['response' => $responseData['choices'][0]['message']['content']]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Invalid API response format']);
}
?> 