<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "hospital_db";

    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $dob = $_POST['dob'];
    $age = (int)$_POST['age'];
    $gender = $_POST['gender'];
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $patient_history = mysqli_real_escape_string($conn, $_POST['patient_history']);

    $sql = "INSERT INTO patients (patient_name, email, password, dob, age, gender, contact, address, patient_history)
            VALUES ('$patient_name', '$email', '$password', '$dob', $age, '$gender', '$contact', '$address', '$patient_history')";

    if ($conn->query($sql) === TRUE) {
        echo "<div style='padding:20px;text-align:center;'><h3>Patient registered successfully!</h3><a href=''>Back to form</a></div>";
        exit;
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="patient_register.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Patient Registration Form</h2>
    <form id="patientForm" method="post" onsubmit="return validateForm()">
        <div class="mb-3">
            <label for="patient_name" class="form-label">Patient Name</label>
            <input type="text" class="form-control" id="patient_name" name="patient_name" required oninput="formatName(this)">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                    <span id="eyeIcon">Show</span>
                </button>
            </div>
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="dob" name="dob" required onchange="calculateAge()">
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="text" class="form-control" id="age" name="age" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select class="form-select" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="contact" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contact" name="contact" required maxlength="10" oninput="validateContact(this)">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="2" required oninput="capitalizeFirst(this)"></textarea>
        </div>

        <div class="mb-3">
            <label for="patient_history" class="form-label">Patient History</label>
            <textarea class="form-control" id="patient_history" name="patient_history" rows="3" required oninput="capitalizeFirst(this)"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<script>
function togglePassword() {
    const pwd = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");
    if (pwd.type === "password") {
        pwd.type = "text";
        icon.textContent = "Hide";
    } else {
        pwd.type = "password";
        icon.textContent = "Show";
    }
}

function calculateAge() {
    const dob = document.getElementById("dob").value;
    if (dob) {
        const birthDate = new Date(dob);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        document.getElementById("age").value = age;
    }
}

function validateContact(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
    if (input.value.length > 10) input.value = input.value.slice(0, 10);
}

function capitalizeFirst(input) {
    const sentences = input.value.toLowerCase().split('. ');
    input.value = sentences.map(s => s.charAt(0).toUpperCase() + s.slice(1)).join('. ');
}

function formatName(input) {
    input.value = input.value.replace(/[^a-zA-Z ]/g, '');
    input.value = input.value.replace(/\s+/g, ' ');
    input.value = input.value.split(' ').map(word =>
        word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
    ).join(' ');
}

function validateForm() {
    const name = document.getElementById("name").value.trim();
    const namePattern = /^[A-Za-z]+(?: [A-Za-z]+)*$/;
    if (!namePattern.test(name)) {
        alert("Name must contain only alphabets and a single space between parts.");
        return false;
    }
    const contact = document.getElementById("contact").value;
    if (!/^\d{10}$/.test(contact)) {
        alert("Contact number must be exactly 10 digits.");
        return false;
    }
    return true;
}
</script>
</body>
</html>