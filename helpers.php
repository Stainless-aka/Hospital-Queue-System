<?php
function getNextPatient($conn) {
    $result = $conn->query("SELECT * FROM queue WHERE status='waiting' ORDER BY id ASC LIMIT 1");
    return $result->fetch_assoc();
}
?>
