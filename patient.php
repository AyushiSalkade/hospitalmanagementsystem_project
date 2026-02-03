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
//echo "connection ok";
}
$p_name = $_POST['p_name'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$phoneno = $_POST['phoneno'];
$email = $_POST['email'];
$address = $_POST['address'];
$patient_history = $_POST['patient_history'];
$password = $_POST['password'];
//set role as patient
$role='patient';
//check email already exist
$check_email_sql = "SELECT * FROM patient WHERE email = '$email'";
$result = $conn->query($check_email_sql);
if ($result->num_rows > 0){
    echo "This email already registered.";
}else {
    $sql = "INSERT INTO patient ( p_name, gender, age, phoneno,email, address, patient_history,password, role) VALUES ('$p_name', '$gender', '$age', '$phoneno','$email', '$address', '$patient_history','$password', '$role')";
if ($conn->query($sql) === TRUE) {
    echo "new record inserted successfully!";
} else {
    echo "Error: " . $conn->error;
}

}
/*set role as patient
$role='patient';
$sql = "INSERT INTO patient ( p_name, gender, age, phoneno,email, address, patient_history,password, role) VALUES ('$p_name', '$gender', '$age', '$phoneno','$email', '$address', '$patient_history','$password', '$role')";
if ($conn->query($sql) === TRUE) {
    echo "new record inserted successfully!";
} else {
    echo "Error: " . $conn->error;
}*/
$conn->close();
?>