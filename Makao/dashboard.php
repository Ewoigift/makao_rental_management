<?php
// session_start();

// if (!isset($_SESSION['user_email'])) {
//     header('Location: index.php');
//     exit();
// }

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

// Fetch user data from the database based on the user's email
// $userEmail = $_SESSION['user_email'];
// $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
// $stmt->bindParam(':email', $userEmail);
// $stmt->execute();
// $user = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="assets\dashboard.css">
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Tenants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Properties</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Feedback</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
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
                        <a href="#" class="btn btn-primary">Go to Tenants</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Properties</h4>
                        <p class="card-text">Add, edit, or delete properties.</p>
                        <a href="#" class="btn btn-primary">Go to Properties</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Feedback</h4>
                        <p class="card-text">View feedback from tenants.</p>
                        <a href="#" class="btn btn-primary">Go to Feedback</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>