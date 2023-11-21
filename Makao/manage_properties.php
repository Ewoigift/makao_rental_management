<?php
session_start();
require_once 'config.php';

// Check if the landlord is logged in
if (!isset($_SESSION['landlord_id'])) {
    header('Location: index.php');
    exit();
}

if(isset($_POST['view-property'])){
    $propertyId = $_POST['property_idd'];
    $_SESSION['property_id'] = $propertyId;
    header('Location: view_rooms.php');
}

// Fetch properties for the logged-in landlord
$loggedInLandlordId = $_SESSION['landlord_id'];
$sqlProperties = "SELECT * FROM properties WHERE LandlordID = $loggedInLandlordId";
$resultProperties = mysqli_query($conn, $sqlProperties);
$properties = mysqli_fetch_all($resultProperties, MYSQLI_ASSOC);

// Handle adding new property
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_property'])) {
    $propertyName = $_POST['property_name'];
    $address = $_POST['address'];

    $sqlAddProperty = "INSERT INTO properties (LandlordID, PropertyName, Address) VALUES ($loggedInLandlordId, '$propertyName', '$address')";
    if (mysqli_query($conn, $sqlAddProperty)) {
        header('Location: manage_properties.php'); // Redirect to refresh the page
        exit();
    } else {
        $addError = "Error adding property: " . mysqli_error($conn);
    }
}

// Handle editing or deleting a property
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && isset($_GET['id'])) {
    $propertyId = $_GET['id'];

    // Handle deletion
    if ($_GET['action'] === 'delete') {
        $sqlDeleteProperty = "DELETE FROM properties WHERE PropertyID = $propertyId AND LandlordID = $loggedInLandlordId";
        if (mysqli_query($conn, $sqlDeleteProperty)) {
            header('Location: manage_properties.php'); // Redirect to refresh the page
            exit();
        } else {
            $deleteError = "Error deleting property: " . mysqli_error($conn);
        }
    }

    // Handle editing
    if ($_GET['action'] === 'edit') {
        // Fetch property details for editing
        $sqlGetProperty = "SELECT * FROM properties WHERE PropertyID = $propertyId AND LandlordID = $loggedInLandlordId";
        $resultProperty = mysqli_query($conn, $sqlGetProperty);
        $propertyDetails = mysqli_fetch_assoc($resultProperty);

        // Display the edit form
        echo '<div class="card mt-3">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">Edit Property</h5>';
        echo '<form method="post" action="manage_properties.php">';
        echo '<input type="hidden" name="edit_id" value="' . $propertyDetails['PropertyID'] . '">';
        echo '<div class="form-group">';
        echo '<label for="edit_property_name">Property Name:</label>';
        echo '<input type="text" class="form-control" id="edit_property_name" name="edit_property_name" value="' . $propertyDetails['PropertyName'] . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="edit_address">Address:</label>';
        echo '<input type="text" class="form-control" id="edit_address" name="edit_address" value="' . $propertyDetails['Address'] . '" required>';
        echo '</div>';
        echo '<button type="submit" name="edit_property" class="btn btn-success">Save Changes</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
}

// Handle saving changes for an edited property
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_property'])) {
    $editPropertyId = $_POST['edit_id'];
    $editPropertyName = $_POST['edit_property_name'];
    $editAddress = $_POST['edit_address'];

    $sqlEditProperty = "UPDATE properties SET PropertyName = '$editPropertyName', Address = '$editAddress' WHERE PropertyID = $editPropertyId AND LandlordID = $loggedInLandlordId";
    if (mysqli_query($conn, $sqlEditProperty)) {
        header('Location: manage_properties.php'); // Redirect to refresh the page
        exit();
    } else {
        $editError = "Error editing property: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Properties</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets\add_tenant.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-3">
        <h2>Your Properties</h2>

        <!-- Display properties -->
        <?php foreach ($properties as $property) : ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $property['PropertyName']; ?></h5>
                    <p class="card-text">Address: <?php echo $property['Address']; ?></p>
                    <form action="manage_properties.php" method="POST">
                        <button type="submit" name="view-property" class="btn btn-primary">View</button>
                        <input style="display:none" type="number" name="property_idd" value="<?php echo($property['PropertyID'])?>">
                    </form>
                    <a href="?action=edit&id=<?php echo $property['PropertyID']; ?>" class="btn btn-warning">Edit</a>
                    <a href="?action=delete&id=<?php echo $property['PropertyID']; ?>" class="btn btn-danger">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Form for adding a new property -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Add New Property</h5>
                <form method="post" action="manage_properties.php">
                    <div class="form-group">
                        <label for="property_name">Property Name:</label>
                        <input type="text" class="form-control" id="property_name" name="property_name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <button type="submit" name="add_property" class="btn btn-success">Add Property</button>
                </form>
                <?php if (isset($addError)) : ?>
                    <p class="text-danger"><?php echo $addError; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>