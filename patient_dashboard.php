<?php
session_start();
if (!isset($_SESSION['p_id'])) {
    header("Location: login.php"); // Agar login nahi kiya to wapas login pe bhejo
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
    background: url('images/loginimage3.jpeg') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
  }
  
        body {
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #003b5b;
            padding: 20px;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            margin: 10px 0;
            text-decoration: none;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .content {
            flex-grow: 1;
            padding: 30px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Welcome, <?php echo $_SESSION['p_name'] ?? 'Patient'; ?></h4>
        <hr>
        <a href="?page=profile">My Profile</a>
        <a href="appointmentbook.php">Appointments</a>
        <a href="viewappointment.php">My Appointments</a>
        <a href="room.php">Check Rooms</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Content Area -->
    <div class="content">
    <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];

            if ($page == 'profile') {
                include 'patient_profile.php';
            } elseif ($page == 'Book Appointment') {
                include 'appointmentbook.php';
            } elseif ($page == 'My Appointments') {
                include 'viewappointment.php';
            } elseif ($page == 'room') {
                include 'room.php';
            } else {
                echo "<h5>Page not found.</h5>";
            }
        } else {
            echo "<h3>Welcome to your dashboard!</h3><p>Select an option from sidebar.</p>";
        }
    ?>
</div>
</body>
</html>