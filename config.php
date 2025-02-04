<?php
// Database credentials
$servername = "localhost";
$username = "u561536392_pancard_admin";
$password = "Rajpk583@#";
$dbname = "u561536392_pancard_admin";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// else{
//     echo "Database Are Connected";
//     $dataquery = "SELECT * FROM pancard_admin";
//     $data = mysqli_query($conn, $dataquery);
//     if ($data->num_rows>0) {
//         echo "Have Row";
//     }else{
//         $sql = "INSERT INTO `pancard_admin`(`id`, `user_name`, `user_email`, `user_pass`) VALUES ('','Raj','admin@123.com','Admin@123')";
//         $addquery = mysqli_query($conn, $sql);
//         echo "User Are Not Found";

//     }
    


// SQL query to create the table
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
