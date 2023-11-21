<?php
require_once 'config.php';

// Fetch all tenants from the database
$sql = "SELECT * FROM tenants";
$result = mysqli_query($conn, $sql);
$tenants = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets\tenantlist.css">
</head>

<body>
    <div class="container mt-4">
        <h2>Tenant List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tenants as $tenant) : ?>
                    <tr>
                        <td><?php echo $tenant['TenantID']; ?></td>
                        <td><?php echo $tenant['FirstName']; ?></td>
                        <td><?php echo $tenant['LastName']; ?></td>
                        <td><?php echo $tenant['Email']; ?></td>
                        <td><?php echo $tenant['PhoneNumber']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>