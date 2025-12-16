<?php
include('../config/connect.php');

// Retrieve and validate the order ID from the query string
$id = $_GET['id'];
if (!is_numeric($id)) {
    die("Invalid ID");
}

// Generate a new package ID for the current date
$date = date('Y-m-d'); // Current date
$query = "SELECT MAX(packageID) as max_id FROM orders WHERE DATE(created_at) = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $date);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$new_package_id = 1; // Default to 1 if no records found for the current date
if ($row['max_id'] !== null) {
    $new_package_id = $row['max_id'] + 1; // Increment the max package_id by 1
}

// Update the order with the new package ID and change its status to 'Approved By Receiver'
$update = "UPDATE orders SET packageID = ?, Status = 'Approved By Receiver', created_at = NOW() WHERE ID = ?";
$stmt = $conn->prepare($update);
$stmt->bind_param('ii', $new_package_id, $id);

if ($stmt->execute()) {
    // Redirect to the Approved Packages page
    header("Location: ../receiver/approve.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
