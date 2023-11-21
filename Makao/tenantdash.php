<?php
session_start();
require_once 'config.php';

// Check if the tenant is logged in
if (!isset($_SESSION['tenant_id'])) {
    header('Location: tenantlogin.php');
    exit();
}



if (isset($_SESSION['tenant_id'])) {
    // echo("Here:". $_SESSION['user_email']);
    $sql = "SELECT * FROM tenants WHERE TenantID='{$_SESSION['tenant_id']}'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // print_r($row);
    $username = $row[0]['FirstName'];
    $user_email = $row[0]['Email'];
}


                    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets\add_tenant.css">
</head>

<body>
    <?php include 'tenant_nav.php'; ?>

    <div class="container-fluid mt-3">
        <h2>Welcome to the Tenant Dashboard</h2>
        <p>Hello, <?php echo ($username); ?>!</p>
        <p>Email: <?php echo ($user_email); ?></p>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pay Rent</h4>
                        <p class="card-text">Pay your rent online.</p>
                        <a href="#" class="btn btn-primary">Go to Pay Rent</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Feedback</h4>
                        <p class="card-text">Provide feedback on your rental experience.</p>
                        <a href="give_feedback.php" class="btn btn-primary">Go to Feedback</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>