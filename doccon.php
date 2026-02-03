<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_db";
error_reporting(0);
$conn = mysqli_connect($servername,$username,$password,$dbname);

if($conn->connect_error){
    die("conection failed:" . 
    $conn->connect_error);
}
{
echo "connection ok";
}
$D_name = $_POST['D_name'];
$age = $_POST['age'];
$contactno = $_POST['contactno'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$specialization = $_POST['specialization'];
$password = $_POST['password'];
$sql = "INSERT INTO doctor (D_name, age, contactno, email, gender, specialization, password) VALUES ('$D_name', '$age', '$contactno', '$email', '$gender', '$specialization', '$password')";
if ($conn->query($sql) === TRUE) { 
     echo "new record inserted successfully!";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>