
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

// Fetch doctors and their specialization from the database
$query = "SELECT D_id, D_name, specialization FROM doctor";
$doctor_result = mysqli_query($conn, $query);
if (!$doctor_result) {
    die('SQL Error: ' . mysqli_error($conn));
}

// Fetch available time slots for each doctor (assuming a fixed list or time_slots table)
// Generate 30-minute interval time slots from 09:00 to 17:00
$time_slots = [];
$start = strtotime('09:00');
$end = strtotime('17:00');

while ($start < $end) {
    $time_slots[] = date('H:i', $start);
    $start = strtotime('+30 minutes', $start);
}

// Convert 24-hour time format to 12-hour AM/PM format
$formatted_time_slots = [];
foreach ($time_slots as $slot) {
    $time_parts = explode(":", $slot);
    $hour = (int) $time_parts[0];
    $minute = $time_parts[1];

    if ($hour < 12) {
        $formatted_time_slots[] = sprintf("%02d:%s AM", $hour == 0 ? 12 : $hour, $minute);
    } else {
        $formatted_time_slots[] = sprintf("%02d:%s PM", $hour > 12 ? $hour - 12 : $hour, $minute);
    }
}
// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking</title>
    <link rel="stylesheet" href="gogglesheet.css"> <!-- Your existing CSS file -->
</head>
<body>

<div class="container">
    <h4>Book an Appointment</h4>
    <form action="appointment2.php" method="post">
        <div class="form-group">

        <!-- Select Doctor Dropdown -->
        <label for="doctor">Select Doctor:</label>
        <select name="D_id" id="doctor" required>
            <option value="">Select Doctor</option>
            <?php
            // Check if there are any doctors in the table
            if (mysqli_num_rows($doctor_result) > 0) {
                // Loop through the results and display each doctor with their specialization in the dropdown
                while ($row = mysqli_fetch_assoc($doctor_result)) {
                    // Prefix "Dr." to the doctor's name
                    echo "<option value='" . $row['D_id'] . "'>Dr. " . $row['D_name'] . " (" . $row['specialization'] . ")</option>";
                }
            } else {
                echo "<option value=''>No doctors available</option>";
            }
            ?>
        </select>
        </div>

        <!-- Date Input -->
        <label for="date">Select Date:</label>
        <input type="date" id="Date" name="Date" min="<?php echo date('Y-m-d'); ?>" required>

        <!-- Time Slot Dropdown -->
        <label for="time">Select Time:</label>
        <select name="Time" id="Time" required>
            <option value="">Select Time</option>
            <?php
            // Loop through formatted time slots and display them in AM/PM format
            foreach ($formatted_time_slots as $slot) {
                echo "<option value='$slot'>$slot</option>";
            }
            ?>
        </select>

        <!-- Reason Input -->
        <label for="reason">Reason for Appointment:</label>
        <textarea name="Issue" id="Issue" placeholder="Enter reason for appointment" required></textarea>

        <!-- Submit Button -->
        <button type="submit" id="submit">Book Appointment</button>
    </form>
</div>

<!-- JavaScript code for disabling past time slots -->
<script>
    document.getElementById('submit').onclick = function(event) {
        // Check if the Issue field contains only alphanumeric characters and spaces
        if (!/^[a-zA-Z0-9\s]*$/.test(document.getElementById('Issue').value)) {
            event.preventDefault(); // Prevent form submission
            alert('Please enter a valid reason. Only letters, numbers, and spaces are allowed.');
        }
    };
    // Disable time slots for today and past time
    document.addEventListener("DOMContentLoaded", function() {
    const dateInput = document.getElementById("Date");
    const timeSelect = document.getElementById("Time");

    // Get today's date
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute("min", today);

    dateInput.addEventListener("change", function() {
        const selectedDate = dateInput.value;
        const now = new Date();
        const currentHour = now.getHours();
        const currentMinute = now.getMinutes();

        const timeSlots = timeSelect.getElementsByTagName("option");

        for (let i = 0; i < timeSlots.length; i++) {
            const slot = timeSlots[i].value;

            if (slot === "" || slot === "Select Time") continue; // Skip default option

            // Convert slot time from 12-hour format to 24-hour format
            let [time, period] = slot.split(' ');
            let [hour, minute] = time.split(':');
            hour = parseInt(hour);
            minute = parseInt(minute);

            if (period === "PM" && hour !== 12) hour += 12;
            if (period === "AM" && hour === 12) hour = 0;

            if (selectedDate === today) {
                // Compare slot time with current time
                if (hour < currentHour || (hour === currentHour && minute <= currentMinute)) {
                    timeSlots[i].disabled = true;
                } else {
                    timeSlots[i].disabled = false;
                }
            } else {
                timeSlots[i].disabled = false;
            }
        }
    });
});
</script>

</body>
</html>