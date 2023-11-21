<?php


session_start();
require_once 'config.php';

if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
if (isset($_SESSION['user_email'])) {
    // echo("Logged in");
    $sql = "SELECT * FROM landlords WHERE email='{$_SESSION['user_email']}'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $username = $row[0]['FirstName'];
    $user_email = $row[0]['Email'];
    // $role = $row[0]['FirstName'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets\add_tenant.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container-fluid mt-3">
        <h2>Welcome to the Admin Dashboard</h2>
        <p>Hello, <?php echo ($username); ?>!</p>
        <p>Email: <?php echo ($user_email); ?></p>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tenants</h4>
                        <p class="card-text">Add, edit, or delete tenants.</p>
                        <a href="tenant_management.php" class="btn btn-primary">Go to Tenants</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Properties</h4>
                        <p class="card-text">Add, edit, or delete properties.</p>
                        <a href="manage_properties.php" class="btn btn-primary">Go to Properties</a>

                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Feedback</h4>
                        <p class="card-text">View feedback from tenants.</p>
                        <a href="view_feedback.php" class="btn btn-primary">Go to Feedback</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>