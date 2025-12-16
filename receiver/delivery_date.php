<?php
session_start();
if (!isset($_SESSION['empCode']) || !isset($_SESSION['empName'])) {
    header("Location: ../index.php");
    exit();
}

// Database connection
include('../config/connect.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['select_order']) && !empty($_POST['select_order'])) {
        // Get the selected order numbers
        $selected_orders = $_POST['select_order'];

        // Get the current date
        $current_date = date('Y-m-d');

        // Prepare the SQL statement
        $sql = "UPDATE orders SET delivery_date = ? WHERE OrderNO = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {
            // Loop through each selected order
            foreach ($selected_orders as $order_no) {
                // Bind parameters and execute
                $stmt->bind_param('ss', $current_date, $order_no);
                $stmt->execute();
            }

            // Close the statement
            $stmt->close();

            // Redirect or show success message
            header("Location: receiver.php?status=success");
            exit();
        } else {
            // Handle errors (e.g., log them or show a message)
            echo "Error preparing the SQL statement.";
        }
    } else {
        // Handle case where no orders are selected
        echo "No orders selected.";
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect to home if accessed directly
    header("Location: receiver.php");
    exit();
}
?>
