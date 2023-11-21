<?php
require_once 'config.php';

// Check if the add action is triggered
if (isset($_POST['add_tenant'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Check if the TenantID is set, if set, update the existing tenant, else insert a new tenant
    if (isset($_POST['tenant_id']) && is_numeric($_POST['tenant_id'])) {
        $tenantId = $_POST['tenant_id'];
        $sql = "UPDATE tenants SET FirstName='$firstName', LastName='$lastName', Email='$email', PhoneNumber='$phone' WHERE TenantID=$tenantId";
    } else {
        $sql = "INSERT INTO tenants (FirstName, LastName, Email, PhoneNumber) VALUES ('$firstName', '$lastName', '$email', '$phone')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "Tenant saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Check if the delete action is triggered
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $tenantId = $_GET['id'];

        // Check if the tenant exists in the database
        $checkQuery = "SELECT * FROM tenants WHERE TenantID = $tenantId";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Tenant exists, proceed with deletion
            $deleteQuery = "DELETE FROM tenants WHERE TenantID = $tenantId";

            if (mysqli_query($conn, $deleteQuery)) {
                echo "Tenant deleted successfully.";
            } else {
                echo "Error deleting tenant: " . mysqli_error($conn);
            }
        } else {
            echo "Tenant not found.";
        }
    } else {
        echo "Invalid tenant ID.";
    }
}

// Check if the edit action is triggered
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $tenantId = $_GET['id'];

        // Retrieve tenant details for editing
        $editQuery = "SELECT * FROM tenants WHERE TenantID = $tenantId";
        $editResult = mysqli_query($conn, $editQuery);

        if ($row = mysqli_fetch_assoc($editResult)) {
            $editFirstName = $row['FirstName'];
            $editLastName = $row['LastName'];
            $editEmail = $row['Email'];
            $editPhone = $row['PhoneNumber'];
        } else {
            echo "Tenant not found.";
        }
    } else {
        echo "Invalid tenant ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="add_tenant.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Tenant Management</h2>

        <!-- Add/Edit Tenant Form -->
        <!-- Add/Edit Tenant Form -->
        <form action="tenant_management.php" method="post">
            <input type="hidden" name="tenant_id" value="<?php echo isset($tenantId) ? $tenantId : ''; ?>">

            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo isset($editFirstName) ? $editFirstName : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo isset($editLastName) ? $editLastName : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($editEmail) ? $editEmail : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($editPhone) ? $editPhone : ''; ?>" required>
            </div>
            <button type="submit" name="add_tenant" class="btn btn-primary">
                <?php echo isset($tenantId) ? 'Update Tenant' : 'Add Tenant'; ?>
            </button>
            <?php if (isset($tenantId)) : ?>
                <a href="tenant_management.php" class="btn btn-secondary">Cancel</a>
            <?php endif; ?>
        </form>


        <hr>

        <!-- Display Tenants Table -->
        <h3>Current Tenants</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM tenants");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['TenantID']}</td>
                            <td>{$row['FirstName']}</td>
                            <td>{$row['LastName']}</td>
                            <td>{$row['Email']}</td>
                            <td>{$row['PhoneNumber']}</td>
                            <td>
                                <a href='tenant_management.php?action=edit&id={$row['TenantID']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='tenant_management.php?action=delete&id={$row['TenantID']}' class='btn btn-danger btn-sm'>Delete</a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>