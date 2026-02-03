<?php


// Doctor login check
if (!isset($_SESSION['D_id'])) {
    die("You must be logged in to view your appointments.");
}

// DB connection
$conn = new mysqli("localhost", "root", "", "hospital_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$D_id = $_SESSION['D_id'];

// SQL query to get only that doctor's appointments
$query = "SELECT a.*, p.p_name, p.gender, p.age, p.phoneno, p.email, p.address, p.patient_history
          FROM appointments a
          JOIN patient p ON a.p_id = p.p_id
          WHERE a.D_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $D_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor - My Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f0f4f7;">

<div class="container mt-5">
    <h3 class="text-center text-primary mb-4">My Appointments</h3>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th>Patient ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>History</th>
                <th>Date</th>
                <th>Time</th>
                <th>Issue</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['p_id']) ?></td>
                        <td><?= htmlspecialchars($row['p_name']) ?></td>
                        <td><?= htmlspecialchars($row['gender']) ?></td>
                        <td><?= htmlspecialchars($row['age']) ?></td>
                        <td><?= htmlspecialchars($row['phoneno']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['address']) ?></td>
                        <td><?= htmlspecialchars($row['patient_history']) ?></td>
                        <td><?= htmlspecialchars($row['Date']) ?></td>
                        <td><?= htmlspecialchars($row['Time']) ?></td>
                        <td><?= htmlspecialchars($row['Issue']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12" class="text-center text-muted">No appointments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="text-center">
        <a href="doctor_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</div>

</body>
</html>