<?php
session_start();
require_once 'config.php';

// Check if the landlord is logged in
if (!isset($_SESSION['landlord_id'])) {
    header('Location: index.php');
    exit();
}

// Check if PropertyID is provided
if (isset($_SESSION['property_id'])) {
    $propertyId = $_SESSION['property_id'];
} else {
    header('Location: manage_properties.php');
    exit();
}

// Fetch rooms for the specified property
$sqlRooms = "SELECT * FROM rooms WHERE PropertyID = $propertyId";
$resultRooms = mysqli_query($conn, $sqlRooms);
$rooms = mysqli_fetch_all($resultRooms, MYSQLI_ASSOC);

// Handle room status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $roomId = $_POST['room_id'];
    $newStatus = $_POST['new_status'];

    $sqlUpdateStatus = "UPDATE rooms SET IsAvailable = $newStatus WHERE RoomID = $roomId";
    if (mysqli_query($conn, $sqlUpdateStatus)) {
        // Redirect to refresh the page after updating status
        header("Location: view_rooms.php?PropertyID=$propertyId");
        exit();
    } else {
        $updateError = "Error updating room status: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rooms</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets\add_tenant.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-3">
        <h2>Your Rooms</h2>

        <!-- Display rooms -->
        <?php foreach ($rooms as $room) : ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Room <?php echo $room['RoomNumber']; ?></h5>
                    <p class="card-text">Rate: $<?php echo $room['Rate']; ?></p>
                    <p class="card-text">
                        <?php
                        if ($room['IsAvailable'] == 1) {
                            echo "Status: Vacant";
                        } else {
                            echo "Status: Not Available";
                        }
                        ?>
                    </p>
                    <!-- Form for updating room status -->
                    <form method="post" action="view_rooms.php?property_id=<?php echo $propertyId; ?>">
                        <input type="hidden" name="room_id" value="<?php echo $room['RoomID']; ?>">
                        <label for="new_status">Update Status:</label>
                        <select name="new_status" id="new_status" class="form-control">
                            <option value="1">Vacant</option>
                            <option value="0">Not Available</option>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-warning mt-2">Update Status</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>