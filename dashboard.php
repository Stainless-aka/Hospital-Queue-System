<?php
include 'config.php';
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - Hospital Queue</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background: linear-gradient(135deg, #007bff, #6610f2);
    }
    .navbar-brand {
      font-weight: bold;
      color: #fff !important;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .status-badge {
      padding: 0.4rem 0.8rem;
      border-radius: 1rem;
      font-size: 0.85rem;
      font-weight: 600;
    }
    .status-waiting {
      background-color: #ffc107;
      color: #212529;
    }
    .status-processing {
      background-color: #0dcaf0;
      color: #fff;
    }
    .status-approved {
      background-color: #198754;
      color: #fff;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Hospital Queue Dashboard</a>
    <div class="d-flex">
      <a href="call_next.php" class="btn btn-outline-light me-2">Call Next Patient</a>
      <a href="logout.php" class="btn btn-light text-primary">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold">Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></h2>
    <p class="text-muted">Manage and monitor patient queue in real-time</p>
  </div>

  <div class="card p-4">
    <h4 class="mb-3 text-primary">All Patients</h4>
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-primary">
          <tr>
            <th>Queue No.</th>
            <th>Patient Name</th>
            <th>Department</th>
            <th>Status</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM queue ORDER BY id ASC");
          while ($row = $result->fetch_assoc()) {
            $status = strtolower($row['status']);
            $badgeClass = match($status) {
              'waiting' => 'status-waiting',
              'processing' => 'status-processing',
              'approved' => 'status-approved',
              default => 'status-waiting'
            };
            echo "
              <tr data-id='{$row['id']}'>
                <td>{$row['queue_number']}</td>
                <td>{$row['patient_name']}</td>
                <td>{$row['department']}</td>
                <td><span class='status-badge $badgeClass'>".ucfirst($row['status'])."</span></td>
                <td class='text-center'>
                  <form class='update-form d-inline'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <select name='status' class='form-select form-select-sm d-inline w-auto'>
                      <option value='waiting' ".($status=='waiting'?'selected':'').">Waiting</option>
                      <option value='processing' ".($status=='processing'?'selected':'').">Processing</option>
                      <option value='approved' ".($status=='approved'?'selected':'').">Approved</option>
                    </select>
                    <button type='submit' class='btn btn-sm btn-success ms-2'>Update</button>
                  </form>
                </td>
              </tr>
            ";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $(".update-form").on("submit", function(e) {
    e.preventDefault();
    let form = $(this);
    let id = form.find("input[name='id']").val();
    let status = form.find("select[name='status']").val();

    $.ajax({
      url: "update_status.php",
      method: "POST",
      data: { id: id, status: status },
      success: function(response) {
        if (response.trim() === "success") {
          location.reload();
        } else {
          alert("Failed to update status!");
        }
      },
      error: function() {
        alert("Error connecting to server!");
      }
    });
  });
});
</script>
</body>
</html>
