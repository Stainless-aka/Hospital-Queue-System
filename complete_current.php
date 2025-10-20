<?php
include 'config.php';
$conn->query("UPDATE queue SET status='completed' WHERE status='processing'");
header("Location: dashboard.php");
?>
