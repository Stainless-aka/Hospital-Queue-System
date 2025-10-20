<?php
include 'config.php';

// Fetch all waiting patients ordered by ID
$result = $conn->query("SELECT * FROM queue WHERE status='waiting' ORDER BY id ASC");

$data = [];
$queue_number = 1; // Start queue numbering from 1

while ($row = $result->fetch_assoc()) {
    $row['queue_number'] = $queue_number; // Assign queue number
    $data[] = $row;
    $queue_number++;
}

// Return JSON response
echo json_encode($data);
?>
