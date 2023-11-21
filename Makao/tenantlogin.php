<?php
// require_once 'config.php';

// // Add your authentication logic here
// $authenticated = false;

// if (isset($_POST['login'])) {
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     // Add your authentication logic using the database connection
//     $sql = "SELECT * FROM tenants WHERE email='$email'";
//     $result = mysqli_query($conn, $sql);
//     $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
//     $db_pass = $row[0]['Password'];
//     // print_r($row);


//     if ($password === $db_pass) {
//         $authenticated = true;
//         if ($authenticated) {
//             session_start();
//             $_SESSION['user_email'] = $email;
//             header("Location: tenantdash.php");
//         } else {
//             $error = "Invalid email or password";
//             echo ("Wrong email or password");
//         }
//     }
// }


    session_start();
    require_once 'config.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Add your authentication logic using the database connection
        $sql = "SELECT TenantID FROM tenants WHERE Email = '$email' AND Password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['tenant_id'] = $row['TenantID'];
            header("Location: tenantdash.php");
            exit();
        } else {
            $error = "Invalid email or password";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Login</title>
    <link rel="stylesheet" href="assets\form.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <?php include 'tenant_nav.php'; ?>

    <main>
        <h2>Login To Tenant Dashboard</h2>
        <form id="login" action="tenantlogin.php" method="post">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <br>
            <input type="submit" name="login">
        </form>
    </main>
</body>

</html>