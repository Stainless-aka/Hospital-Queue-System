<?php
include 'config.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = intval($_POST['id']);
    $status = $_POST['status'];

    $valid_status = ['waiting', 'processing', 'approved'];
    if (!in_array($status, $valid_status)) {
        echo "invalid";
        exit;
    }

    $stmt = $conn->prepare("UPDATE queue SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
}
?>
