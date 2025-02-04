<?php
@include('config.php');
session_start();  // Start a session to store login information

// Predefined username and password for testing purposes




$query ="SELECT * FROM `pancard-admin`";
$result =mysqli_query($conn,$query);
if($result->num_rows>0){
    while ($row=mysqli_fetch_assoc($result)) {
        # code...
        $valid_username = $row['user_email'];
        $valid_password = $row['user_pass'];
    }
    echo $valid_password;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password match
    if ($username == $valid_username && $password == $valid_password) {
        // Store the username in the session and redirect to a protected page
        $_SESSION['username'] = $username;
        header("Location: pan.php");
        exit();
    } else {
        // Redirect to the login page with an error message
        header("Location: index.php?error=true");
        exit();
    }
}
?>
