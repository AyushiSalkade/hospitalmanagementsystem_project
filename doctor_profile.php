<?php
error_reporting(0);
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get doctor ID from URL parameter
//$D_id = $_GET['D_id'];
if (isset($_SESSION['D_id'])) {
    $D_id = $_SESSION['D_id'];
} else {
    echo "Session not set. Please login again.";
    exit();
}
// Fetch doctor details from database
$sql = "SELECT * FROM doctor WHERE D_id = $D_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output doctor details
    while($row = $result->fetch_assoc()) {
       $D_name = $row['D_name'];
        $age = $row['age'];
        $contactno = $row['contactno'];
         $email = $row['email'];
          $gender = $row['gender'];
          $specialization = $row['specialization'];
        $password = $row['password'];
    }
} else {
    echo "No doctor found!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <style>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h3 {
            text-align: center;
            color: #333;
        }

        .profile-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }

        .profile-container p {
            font-size: 16px;
            line-height: 1.5;
        }

        .edit-btn, .submit-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .edit-btn:hover, .submit-btn:hover {
            background-color: #45a049;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input, form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        form textarea {
            height: 150px;
            resize: vertical;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
        }
        </style>
</head>
<body>

    <div class="profile-container">
        <h1>Doctor Profile</h1>
        <div class="profile-details">
            <h2><?php echo $name; ?></h2>
            <p><strong>name:</strong> <?php echo $D_name; ?></p>
            <p><strong>age:</strong> <?php echo $age; ?></p>
            <p><strong>contactno:</strong> <?php echo $contactno; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>gender:</strong> <?php echo $gender; ?></p>
            <p><strong>specialization:</strong> <?php echo $specialization; ?></p>
            
            
        </div>
        
    </div>

</body>
</html>