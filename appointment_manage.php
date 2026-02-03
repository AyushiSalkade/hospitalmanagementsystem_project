<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the admin wants to update the appointment status
if (isset($_GET['status']) && isset($_GET['id'])) {
    // Prepare and execute update statement to change the status
    $stmt = $conn->prepare("UPDATE appointments SET status=? WHERE a_id=?");
    $stmt->bind_param("si", $_GET['status'], $_GET['id']);
    $stmt->execute();

    // Redirect after update to avoid re-submit on refresh
    header("Location: appointment_manage.php");
    exit;
}

// Fetch all appointments with patient and doctor details
$res = $conn->query("SELECT a.*, p.p_name, d.D_name FROM appointments a 
                    JOIN patient p ON a.p_id = p.p_id 
                    JOIN doctor d ON a.D_id = d.D_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Manage Appointments</h2>
        
        <?php if(isset($_GET['status'])): ?>
            <div class="alert alert-success">
                Appointment status updated successfully to <?= htmlspecialchars($_GET['status']); ?>.
            </div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Patient</th><th>Doctor</th><th>Date</th><th>Status</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['p_name']) ?></td>
                    <td><?= htmlspecialchars($row['D_name']) ?></td>
                    <td><?= htmlspecialchars($row['Date']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending'): ?>
                            <!-- Confirm and Cancel buttons for Pending appointments -->
                            <a href="?status=Confirmed&id=<?= $row['a_id'] ?>" class="btn btn-sm btn-success">Confirm</a>
                            <a href="?status=Cancelled&id=<?= $row['a_id'] ?>" class="btn btn-sm btn-danger">Cancel</a>
                        <?php else: ?>
                            <!-- No action if already Confirmed or Cancelled -->
                            <em>No action</em>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>