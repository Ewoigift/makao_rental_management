<?php
session_start();
require_once 'config.php';

// Check if the tenant is logged in
if (!isset($_SESSION['tenant_id'])) {
    header('Location: tenantlogin.php');
    exit();
}

// Fetch tenant information
if (isset($_SESSION['user_email'])) {
    $sql = "SELECT * FROM tenants WHERE email='{$_SESSION['user_email']}'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $tenantId = $row['TenantID'];
    $username = $row['FirstName'];
    $user_email = $row['Email'];
}

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_payment'])) {
    $roomID = $_POST['room_id'];
    $amount = $_POST['amount'];
    $paymentDate = date('Y-m-d');

    $sqlInsertPayment = "INSERT INTO payments (TenantID, RoomID, Amount, PaymentDate) 
                        VALUES ($tenantId, $roomID, $amount, '$paymentDate')";

    if (mysqli_query($conn, $sqlInsertPayment)) {
        $paymentSuccess = "Payment submitted successfully!";
    } else {
        $paymentError = "Error submitting payment: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Rent</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets\add_tenant.css">
</head>

<body>
    <?php include 'tenant_nav.php'; ?>

    <div class="container mt-3">
        <h2>Pay Rent</h2>

        <!-- Display payment submission status -->
        <?php if (isset($paymentSuccess)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $paymentSuccess; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($paymentError)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $paymentError; ?>
            </div>
        <?php endif; ?>

        <!-- Payment Form -->
        <form method="post" action="pay_rent.php">
            <div class="form-group">
                <label for="room_id">Select Room:</label>
                <!-- Add a dropdown with room options -->
                <select class="form-control" id="room_id" name="room_id" required>
                    <!-- Populate options dynamically based on tenant's rented rooms -->
                    <?php
                    $sqlRooms = "SELECT RoomID, RoomNumber FROM rooms WHERE TenantID = $tenantId";
                    $resultRooms = mysqli_query($conn, $sqlRooms);

                    while ($room = mysqli_fetch_assoc($resultRooms)) {
                        echo "<option value='{$room['RoomID']}'>Room {$room['RoomNumber']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Enter Amount:</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <button type="submit" name="submit_payment" class="btn btn-primary">Submit Payment</button>
        </form>
    </div>
</body>

</html>