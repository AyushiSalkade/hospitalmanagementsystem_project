<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Session se p_id lena
if (isset($_SESSION['p_id'])) {
    $p_id = $_SESSION['p_id'];
} else {
    echo "Session not set. Please login again.";
    exit();
}

// Fetch current profile data
$sql = "SELECT * FROM patient WHERE p_id = '$p_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Update the profile after form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Getting form values
    $p_name = $_POST['p_name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $address = $_POST['address'];
    $patient_history = $_POST['patient_history'];

    // SQL query to update the profile
    $update_sql = "UPDATE patient SET p_name='$p_name', gender='$gender', age='$age', email='$email', phoneno='$phoneno', address='$address', patient_history='$patient_history' WHERE p_id='$p_id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "<p style='color: green;'>Profile updated successfully!</p>";
        // Refresh the page to show updated values
        header("Refresh: 2; url=" . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<p style='color: red;'>Error updating profile: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile</title>
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

<div class="container">

<?php
// If the form is not submitted, show the profile
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<h3>My Profile</h3>";
    echo "<div class='profile-container'>";
    echo "<p><strong>Name:</strong> " . $row['p_name'] . "</p>";
    echo "<p><strong>Gender:</strong> " . $row['gender'] . "</p>";
    echo "<p><strong>Age:</strong> " . $row['age'] . "</p>";
    echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
    echo "<p><strong>Phone:</strong> " . $row['phoneno'] . "</p>";
    echo "<p><strong>Address:</strong> " . $row['address'] . "</p>";
    echo "<p><strong>Patient History:</strong> " . $row['patient_history'] . "</p>";
    echo "<a href='#' class='edit-btn' onclick='showEditForm()'>Edit Profile</a>";
    echo "</div>";
} else {
    // If the form was submitted, show the edit form with current values
    echo "<h3>Edit Profile</h3>";
    echo "<form method='POST'>";
    echo "<label for='p_name'>Name:</label><br>";
    echo "<input type='text' id='p_name' name='p_name' value='" . $row['p_name'] . "'><br><br>";
    echo "<label for='gender'>Gender:</label><br>";
    echo "<input type='text' id='gender' name='gender' value='" . $row['gender'] . "'><br><br>";
    echo "<label for='age'>Age:</label><br>";
    echo "<input type='text' id='age' name='age' value='" . $row['age'] . "'><br><br>";
    echo "<label for='email'>Email:</label><br>";
    echo "<input type='text' id='email' name='email' value='" . $row['email'] . "'><br><br>";
    echo "<label for='phoneno'>Phone:</label><br>";
    echo "<input type='text' id='phoneno' name='phoneno' value='" . $row['phoneno'] . "'><br><br>";
    echo "<label for='address'>Address:</label><br>";
    echo "<input type='text' id='address' name='address' value='" . $row['address'] . "'><br><br>";
    echo "<label for='patient_history'>Patient History:</label><br>";
    echo "<textarea id='patient_history' name='patient_history'>" . $row['patient_history'] . "</textarea><br><br>";
    echo "<button type='submit' class='submit-btn'>Update Profile</button>";
    echo "</form>";
}
?>

</div>

<script>
function showEditForm() {
    location.reload();  // Reload the page to show the edit form
}
</script>

</body>
</html>

<?php
mysqli_close($conn);
?>