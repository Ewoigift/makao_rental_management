<?php
require_once 'config.php';

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

mysqli_close($conn);
?>