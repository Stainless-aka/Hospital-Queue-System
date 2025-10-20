<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hospital Queue Management</title>

  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #f0f4ff, #eaf0ff);
      font-family: 'Poppins', sans-serif;
    }
    .main-card {
      max-width: 700px;
      margin: 5% auto;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      border-radius: 15px;
      overflow: hidden;
    }
    .form-control:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    footer {
      text-align: center;
      margin-top: 30px;
      color: #6c757d;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card main-card">
      <div class="card-header bg-primary text-white text-center py-3">
        <h3 class="mb-0"><i class="bi bi-hospital"></i> Hospital Queue Management</h3>
      </div>

      <div class="card-body">
        <form method="POST" action="" class="row g-3">
          <!-- Patient Name -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Patient Name</label>
            <input type="text" name="patient_name" class="form-control" placeholder="Enter Patient Name" required>
          </div>

          <!-- Department -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Department</label>
            <input type="text" name="department" class="form-control" placeholder="Enter Department" required>
          </div>

          <!-- Gender -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Gender</label>
            <select name="gender" class="form-select" required>
              <option value="">Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>

          <!-- Age -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Age</label>
            <input type="number" name="age" class="form-control" placeholder="Enter Age" min="1" required>
          </div>

          <!-- Phone -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Phone Number</label>
            <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number" required>
          </div>

          <!-- Patient Type -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Patient Type</label>
            <select name="patient_type" class="form-select" required>
              <option value="">Select Type</option>
              <option value="New">New</option>
              <option value="Returning">Returning</option>          
            </select>
          </div>

          <!-- Complaint -->
          <div class="col-md-12">
            <label class="form-label fw-semibold">Reason for Visit / Complaint</label>
            <textarea name="complaint" class="form-control" rows="2" placeholder="Enter reason for visit"></textarea>
          </div>

          <div class="col-md-12 d-grid mt-3">
            <button type="submit" name="add_patient" class="btn btn-success btn-lg">
              <i class="bi bi-person-plus"></i> Join Queue
            </button>
          </div>
        </form>

        <hr class="my-4">

        <?php
        if (isset($_POST['add_patient'])) {
            $name = $_POST['patient_name'];
            $dept = $_POST['department'];
            $gender = $_POST['gender'];
            $age = $_POST['age'];
            $phone = $_POST['phone'];
            $type = $_POST['patient_type'];
            $complaint = $_POST['complaint'];

            $query = "INSERT INTO queue (patient_name, department, gender, age, phone, patient_type, complaint, status) 
                      VALUES ('$name', '$dept', '$gender', '$age', '$phone', '$type', '$complaint', 'waiting')";

            if ($conn->query($query)) {
                echo '<div class="alert alert-success text-center mt-3">
                        <i class="bi bi-check-circle"></i> Patient added to queue successfully!
                      </div>';
            } else {
                echo '<div class="alert alert-danger text-center mt-3">
                        <i class="bi bi-x-circle"></i> Error adding patient: ' . $conn->error . '
                      </div>';
            }
        }
        ?>

        <div class="text-center mt-4 d-flex justify-content-center gap-3 flex-wrap">
          <a href="queue_display.php" class="btn btn-outline-primary btn-lg">
            <i class="bi bi-list-ul"></i> View Queue
          </a>
          <a href="login.php" class="btn btn-outline-dark btn-lg">
            <i class="bi bi-person-lock"></i> Admin Login
          </a>
        </div>
      </div>
    </div>

    <footer>
      <small>&copy; <?php echo date('Y'); ?> Computerized Hospital Queue Management System</small>
    </footer>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
