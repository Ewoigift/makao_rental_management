<?php
session_start();
require_once 'config.php';

// Check if the tenant is logged in
if (!isset($_SESSION['tenant_id'])) {
    header('Location: tenantlogin.php');
    exit();
}

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_feedback'])) {
    $tenantId = $_SESSION['tenant_id'];
    $message = $_POST['message'];

    $sqlInsertFeedback = "INSERT INTO communications (SenderID, ReceiverID, Message, SentDateTime) 
                        VALUES ($tenantId, $landlordId, '$message', NOW())";

    if (mysqli_query($conn, $sqlInsertFeedback)) {
        $feedbackSuccess = "Feedback submitted successfully!";
    } else {
        $feedbackError = "Error submitting feedback: " . mysqli_error($conn);
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give Feedback</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets\add_tenant.css">
</head>

<body>
    <?php include 'tenant_nav.php'; ?>

    <div class="container mt-3">
        <h2>Give Feedback</h2>

        <!-- Display feedback submission status -->
        <?php if (isset($feedbackSuccess)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $feedbackSuccess; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($feedbackError)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $feedbackError; ?>
            </div>
        <?php endif; ?>

        <!-- Feedback Form -->
        <form method="post" action="tenantlogin.php">
            <div class="form-group">
                <label for="message">Your Feedback:</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" name="submit_feedback" class="btn btn-primary">Submit Feedback</button>
        </form>
    </div>
</body>

</html>