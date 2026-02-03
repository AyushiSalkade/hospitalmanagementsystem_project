<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<h2>Welcome Admin, <?= $_SESSION['admin_name']; ?>!</h2>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            height: 100vh;
}
        

        header {
            background-color: #007bff;
            color: white;
            padding: 30px 0;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 60px 20px;
            flex-wrap: wrap;
            height: calc(100vh - 100px);
        }

        .panel {
            background-color: white;
            width: 300px;
            height: 250px;
            border-radius: 20px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #333;
            transition: transform 0.3s, background-color 0.3s;
        }

        .panel:hover {
            transform: scale(1.05);
            background-color: #e9f2ff;
        }

        .panel img {
            width: 60px;
            margin-bottom: 15px;
        }

        .panel h2 {
            font-size: 22px;
            margin-top: 10px;
        }

        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                gap: 30px;
                padding: 30px 0;
            }
        }
    </style>
    <!DOCTYPE html>
<html>
<head>
  <style>
    body {
      background-image: url('https://th.bing.com/th/id/OIP.IOUHOY5KDlIdjGjQThs1qQHaEJ?w=293&h=180&c=7&r=0&o=5&dpr=1.7&pid=1.7'); /* Relative path */
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
  </style>
</head>
<body>
  
</body>
</html>
</head>
<body>

    <header>
        Welcome, Admin
    </header>

    <div class="container">
        <a href="patient_manage.php" class="panel">
            <img src="https://th.bing.com/th?q=Health+Care+Icons+Patients&w=120&h=120&c=1&rs=1&qlt=90&cb=1&dpr=1.7&pid=InlineBlock&mkt=en-US&cc=US&setlang=en&adlt=moderate&t=1&mw=247" alt="Patients">
            <h2>Manage Patients</h2>
        </a>
        <a href="doctor_manage.php" class="panel">
            <img src="https://img.icons8.com/ios-filled/60/doctor-male.png" alt="doctor">
            <h2>Manage Doctors</h2>
        </a>
        <a href="appointment_manage.php" class="panel">
            <img src=https://th.bing.com/th/id/OIP.TScofKUQV2PvitC0GAcUtQHaHa?pid=ImgDet&w=192&h=192&c=7&dpr=1.7 alt="appointment">
            <h2>Manage Appointment</h2>
        </a>
    </div>

</body>
<a href="admin_logout.php">Logout</a>

</html>