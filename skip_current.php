<?php
include 'config.php';
$current = $conn->query("SELECT * FROM queue WHERE status='processing'")->fetch_assoc();
if ($current) {
  $id = $current['id'];
  $conn->query("UPDATE queue SET status='waiting' WHERE id=$id");
  $conn->query("UPDATE queue SET status='processing' WHERE status='waiting' AND id > $id ORDER BY id ASC LIMIT 1");
}
header("Location: dashboard.php");
?>
