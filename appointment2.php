<?php
// Start session to access patient info
session_start();

// Check if the patient is logged in
if (!isset($_SESSION['p_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Database connection
$host = "localhost";  // Your database host
$username = "root";   // Your database username
$password = "";       // Your database password
$database = "hospital_db"; // Your database name

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get the form data
    $p_id = $_SESSION['p_id'];  // Patient ID from session
    $D_id = $_POST['D_id'];  // Doctor ID
    $Date = $_POST['Date'];  // Appointment Date
    $Time = $_POST['Time'];  // Appointment Time
    $Issue = $_POST['Issue'];  // Reason for appointment

    // Validation
    $errors = [];

    // 1. Check if date is in the past
    $current_date = date("Y-m-d"); // Get current date
    if ($Date < $current_date) {
        $errors[] = "Past dates are not allowed.";
    }

    // 2. Check if time is in the past (relative to current time)
    $current_time = date("H:i"); // Get current time in 24-hour format
    // Convert selected time to 24-hour format for comparison
    $time_parts = explode(":", $Time);
    $hour = (int) $time_parts[0];
    $minute = $time_parts[1];

    // Convert AM/PM time to 24-hour format for comparison
    if (strpos($Time, 'AM') !== false && $hour == 12) {
        $hour = 0; // 12 AM is midnight
    }
    if (strpos($Time, 'PM') !== false && $hour != 12) {
        $hour += 12; // Convert PM hour to 24-hour format
    }
    
    // Format the time for comparison
    $formatted_time = sprintf("%02d:%02d", $hour, $minute);

    // If the selected date is today, check the time as well
    if ($Date == $current_date && $formatted_time < $current_time) {
        $errors[] = "Past time slots are not allowed.";
    }

    // 3. Check if the time slot is already booked
    $query = "SELECT * FROM appointments WHERE D_id = ? AND Date = ? AND Time = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iss", $D_id, $Date, $formatted_time);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $errors[] = "This time slot is already booked.";
    }

    // If there are no validation errors, proceed to insert the data
    if (empty($errors)) {
        // Insert the appointment into the database
        $insert_query = "INSERT INTO appointments (p_id, D_id, Date, Time, Issue,status) VALUES (?, ?, ?, ?, ?,'Pending')";
        $stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt, "iissss", $p_id, $D_id, $Date, $formatted_time, $Issue, $status);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Successfully booked the appointment
            echo "Appointment booked successfully!";
        } else {
            // Error in booking the appointment
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>