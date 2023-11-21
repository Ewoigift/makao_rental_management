<?php
session_start();
require_once 'config.php';

// Check if the landlord is logged in
if (!isset($_SESSION['landlord_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch feedback messages for the logged-in landlord
$loggedInLandlordId = $_SESSION['landlord_id'];
$sqlFeedback = "SELECT communications.*, tenants.FirstName AS SenderName 
                FROM communications 
                JOIN tenants ON communications.SenderID = tenants.TenantID
                WHERE ReceiverID = $loggedInLandlordId
                ORDER BY SentDateTime DESC";
$resultFeedback = mysqli_query($conn, $sqlFeedback);
$feedbackMessages = mysqli_fetch_all($resultFeedback, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets\add_tenant.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-3">
        <h2>Feedback Messages</h2>

        <!-- Display feedback messages -->
        <?php foreach ($feedbackMessages as $feedback) : ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">From: <?php echo $feedback['SenderName']; ?></h5>
                    <p class="card-text">Message: <?php echo $feedback['Message']; ?></p>
                    <p class="card-text">Sent at: <?php echo $feedback['SentDateTime']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>