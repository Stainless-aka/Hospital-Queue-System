<?php
include 'config.php';

// STEP 1: Check if there's a patient currently processing
$current = $conn->query("SELECT * FROM queue WHERE status='processing' ORDER BY id ASC LIMIT 1");

if ($current->num_rows > 0) {
    // ✅ If there’s one processing, mark them as approved
    $row = $current->fetch_assoc();
    $conn->query("UPDATE queue SET status='approved' WHERE id={$row['id']}");
    $message = "Patient #{$row['queue_number']} ({$row['patient_name']}) has been approved.";
} else {
    // ✅ No one is processing — move next waiting patient to processing
    $next = $conn->query("SELECT * FROM queue WHERE status='waiting' ORDER BY id ASC LIMIT 1");

    if ($next->num_rows > 0) {
        $row = $next->fetch_assoc();
        $conn->query("UPDATE queue SET status='processing' WHERE id={$row['id']}");
        $message = "Patient #{$row['queue_number']} ({$row['patient_name']}) is now processing.";
    } else {
        // ✅ No one waiting — nothing to process
        $message = "No waiting patients in the queue.";
    }
}

// Redirect back to dashboard with a message
header("Location: dashboard.php?msg=" . urlencode($message));
exit();
?>
