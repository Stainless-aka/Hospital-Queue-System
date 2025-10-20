<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Current Queue</title>

  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #f9fbff, #eef3ff);
      font-family: 'Poppins', sans-serif;
    }
    .table-container {
      max-width: 1100px;
      margin: 5% auto;
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    .navbar-brand {
      font-weight: 600;
    }
    .status-badge {
      text-transform: capitalize;
      font-size: 0.9rem;
      padding: 8px 14px;
      border-radius: 20px;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="bi bi-hospital"></i> Hospital Queue</a>
      <a href="index.php" class="btn btn-light btn-sm">
        <i class="bi bi-arrow-left"></i> Back
      </a>
    </div>
  </nav>

  <!-- Table Section -->
  <div class="table-container">
    <h3 class="text-center mb-4 text-primary"><i class="bi bi-list-ul"></i> Current Queue</h3>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th scope="col">Queue No.</th>
            <th scope="col">Patient Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Department</th>
            <th scope="col">Gender</th>
            <th scope="col">Age</th>
            <th scope="col">Patient Type</th>
            <th scope="col">Complaint</th>
            <th scope="col">Status</th>
            <th scope="col">Date Registered</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM queue ORDER BY id ASC");
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $statusClass = '';
                  if ($row['status'] == 'waiting') $statusClass = 'bg-warning text-dark';
                  if ($row['status'] == 'processing') $statusClass = 'bg-info text-dark';
                  if ($row['status'] == 'approved') $statusClass = 'bg-success text-white';

                  echo "<tr>
                          <td>{$row['queue_number']}</td>
                          <td>{$row['patient_name']}</td>
                          <td>{$row['phone']}</td>
                          <td>{$row['department']}</td>
                          <td>{$row['gender']}</td>
                          <td>{$row['age']}</td>
                          <td>{$row['patient_type']}</td>
                          <td>{$row['complaint']}</td>
                          <td><span class='badge $statusClass status-badge'>{$row['status']}</span></td>
                          <td>{$row['created_at']}</td>
                        </tr>";
              }
          } else {
              echo '<tr><td colspan="10" class="text-muted">No patients in the queue yet.</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-4">
      <a href="index.php" class="btn btn-outline-primary btn-lg">
        <i class="bi bi-person-plus"></i> Add New Patient
      </a>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center mt-5 mb-3 text-muted">
    <small>&copy; <?php echo date('Y'); ?> Computerized Hospital Queue Management System</small>
  </footer>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
