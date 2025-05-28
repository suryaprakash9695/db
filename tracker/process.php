<?php
session_start();
require_once '../config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to continue']);
    exit();
}

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
    $stmt = $con->prepare("INSERT INTO cycle_tracker (user_id, last_period, cycle_length, mood, flow, symptoms, notes, next_period, fertile_start, fertile_end) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssss", $user_id, $last_period, $cycle_length, $mood, $flow, $symptoms, $notes, $next_period, $fertile_start, $fertile_end);
    
    if ($stmt->execute()) {
        // Fetch updated cycle data
        $stmt = $con->prepare("SELECT * FROM cycle_tracker WHERE user_id = ? ORDER BY created_at DESC LIMIT 6");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cycle_data = [];
        while ($row = $result->fetch_assoc()) {
            $cycle_data[] = $row;
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Your cycle data has been saved successfully!',
            'cycleData' => $cycle_data[0]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error saving data: ' . $stmt->error
        ]);
    }
    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?> 