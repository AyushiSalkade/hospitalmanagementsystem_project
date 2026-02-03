<?php
// room.php

session_start();
$p_id = $_SESSION['p_id'];

// Optional: Restrict access if needed
// if (!isset($_SESSION['admin'])) {
//     die("Unauthorized access.");
// }

// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all room data
$sql = "SELECT * FROM room ORDER BY rid ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Room Availability</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 85%;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px #ccc;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .available {
            color: green;
            font-weight: bold;
        }

        .occupied {
            color: red;
            font-weight: bold;
        }

        .book-now {
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .book-now:hover {
            background-color: #218838;
        }

        .no-booking {
            color: gray;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Room Availability</h2>
    <table>
        <tr>
            <th>Room No</th>
            <th>Room Type</th>
            <th>Status</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $statusClass = strtolower($row['rstatus']) === 'available' ? 'available' : 'occupied';
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['rid']) . "</td>";
                echo "<td>" . htmlspecialchars($row['rtype']) . "</td>";
                echo "<td class='$statusClass'>" . htmlspecialchars($row['rstatus']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No room data available.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>