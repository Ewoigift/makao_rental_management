<?php
require_once 'config.php';

// Add your authentication logic here
$authenticated = false;


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Add your authentication logic using the database connection
    $sql = "SELECT * FROM landlords WHERE email='$email'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
    $db_pass = $row[0]['Password'];

    if($password===$db_pass){
        $authenticated = true;
        if ($authenticated) {
            session_start();
            $_SESSION['user_email'] = $email;
            $_SESSION['landlord_id'] = $row[0]['LandlordID'];
            header("Location: dashboard.php");
        } else {
            $error = "Invalid email or password";
            echo("Wrong email or password");
        }
    }

    
}

// Include your HTML for login if not a POST request
?>