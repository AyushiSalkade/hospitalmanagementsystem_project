<?php
$conn = new mysqli("localhost", "root", "", "hospital_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['p_name'])) {
    $rid = isset($_GET['rid']) ? intval($_GET['rid']) : 0;

if ($rid <= 0) {
    die("<p style='color:red;'>Invalid or missing Room ID.</p>");
}
    $p_id = isset($_POST['p_id']) ? intval($_POST['p_id']) : 0; // Check if patient_id is given
    $p_name = $conn->real_escape_string($_POST['p_name']);
    $admit_date = $_POST['admit_date'];

    // Validate admission date to prevent past dates
    $today = date('Y-m-d'); // Current date in 'YYYY-MM-DD' format
    if ($admit_date < $today) {
        echo "<p style='color:red;'>Admission date cannot be in the past. Please select a valid date.</p>";
        exit;
    }

    // If patient ID is provided, update the patient info, else insert new patient details
    if ($p_id > 0) {
        // Update patient details
        $conn->query("UPDATE patient SET p_name = '$p_name', admit_date = '$admit_date' WHERE p_id = $p_id");
    } else {
        // Insert new patient details
        $conn->query("INSERT INTO patient (p_name, admit_date) VALUES ('$p_name', '$admit_date')");
        $p_id = $conn->insert_id; // Get the newly inserted patient ID
    }

    // Update room status
    $conn->query("UPDATE room SET rstatus = 'Occupied', p_id = $p_id WHERE rid = $rid");

    echo "<h3>Room ID $rid successfully booked for $p_name.</h3>";
    exit;
}

// If user just clicked "Book Now"
$rid = isset($_GET['rid']) ? intval($_GET['rid']) : 0;
$p_id = isset($_GET['p_id']) ? intval($_GET['p_id']) : 0;

// Fetch patient's name based on patient ID, if provided
if ($p_id > 0) {
    $query = "SELECT p_name FROM patient WHERE p_id = $p_id";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $p_name = $row['p_name'];
    } else {
        $p_name = ''; // If no matching patient found
    }
} else {
    $p_name = ''; // If no patient ID, we let user enter patient name manually
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book Room ID: <?php echo $rid; ?></h2>

        <form method="POST" onsubmit="return validateForm()">
            <input type="hidden" name="rid" value="<?php echo $rid; ?>">
            <input type="hidden" name="p_id" value="<?php echo $p_id; ?>">

            <label>Patient Name:</label>
            <input type="text" name="p_name" value="<?php echo isset($p_name) ? $p_name : ''; ?>" required><br><br>

            <label>Admission Date:</label>
            <input type="date" name="admit_date" id="admit_date" required><br><br>

            <input type="submit" value="Confirm Booking">
        </form>
    </div>

    <script>
        // Validate admission date to prevent past dates
        function validateForm() {
            var admitDate = document.getElementById('admit_date').value;
            var today = new Date().toISOString().split('T')[0]; // Current date in 'YYYY-MM-DD' format

            if (admitDate < today) {
                alert("Admission date cannot be in the past.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>