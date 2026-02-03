<?php
  // Start the session

// Check if patient ID is set in session
if (!isset($_SESSION['D_id'])) {
    die("You must be logged in to view your appointments.");
}

// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get logged-in patient ID from session
$D_id = $_SESSION['D_id'];

// Prepared statement to protect against SQL injection
$query = "SELECT DISTINCT patient.* FROM appointments
JOIN patient ON appointments.p_id = patient.p_id
where appointments.D_id = ?";
// Prepare and bind
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $D_id);  // "i" is for integer type (assuming p_id is an integer)
$stmt->execute();
$result = $stmt->get_result();

// Check if query executed correctly
if ($result === false) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Appointment Status</title>
    <style>
        /* General Body Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h3 {
            text-align: center;
            margin-top: 20px;
            color: #333;
            font-size: 24px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        /* Table Styling */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            color: #555;
        }

        .no-appointments {
            text-align: center;
            color: #999;
            font-style: italic;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                width: 100%;
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h3>Your Appointment Status</h3>
    <table>
        <tr>
            <th>p_id</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Phone no</th>
            <th>Email</th>
            <th>Address</th>
            <th>Patient History</th>
            <th>Status</th>
        </tr>
        <?php
        // Check if any appointments exist
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['p_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['p_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                echo "<td>" . htmlspecialchars($row['phoneno']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                echo "<td>" . htmlspecialchars($row['patient_history']) . "</td>";
                echo "<td>" . (isset($row['status']) ? htmlspecialchars($row['status']) : 'Pending') . "</td>";
                echo "</tr>";
            }
        } else {
            // No appointments found
            echo "<tr><td colspan='4' class='no-appointments'>No appointments found</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>