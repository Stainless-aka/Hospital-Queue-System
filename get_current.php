<?php
include 'config.php';
$result = $conn->query("SELECT * FROM queue WHERE status='processing' LIMIT 1");
echo json_encode($result->fetch_assoc());
?>
