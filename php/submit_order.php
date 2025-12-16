<?php
include('../config/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $orderID = $conn->real_escape_string($_POST['orderNo']);
    $orderNo = strtoupper($orderID);
    $purchaseDate = $conn->real_escape_string($_POST['purchaseDate']);
    $ecommerce = $conn->real_escape_string($_POST['ecommerce']);
    $empcode = $conn->real_escape_string($_POST['empcode']);
    $empname = $conn->real_escape_string($_POST['empname']);
    $location = $conn->real_escape_string($_POST['location']);
    $notMentioned = $conn->real_escape_string($_POST['NotMentioned-text']);  // Changed from Others to NotMentioned-text
    $current_date = date('Y-m-d H:i:s');
    $status = "Employee_Applied";

    // Check if the orderNo already exists for the same purchaseDate and ecommerce
    $check_sql = "SELECT * FROM orders WHERE OrderNO = '$orderNo' AND PurchaseDate = '$purchaseDate' AND ECommerce = '$ecommerce'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Order already exists, show an error message
        ?>
            <script>
                alert("Error: The order number already exists for the same purchase date and e-commerce.");
                window.history.back();
            </script>
        <?php
        exit();
    } else {
        // Proceed with the insertion if no duplicate is found
        if (!$notMentioned) {
            $sql = "INSERT INTO orders (OrderNO, PurchaseDate, ECommerce, EmpCode, location, Status, created_by, created_at)
            VALUES ('$orderNo', '$purchaseDate', '$ecommerce', '$empcode', '$location','$status','$empname','$current_date')"; // Changed from Others to NotMentioned
        } else {
            $sql = "INSERT INTO orders (OrderNO, PurchaseDate, ECommerce, EmpCode, location, Status, created_by, created_at)
            VALUES ('$orderNo', '$purchaseDate', '$notMentioned', '$empcode', '$location', '$status','$empname','$current_date')"; // Changed from Others to NotMentioned
        }

        if ($conn->query($sql) === TRUE) {
            // Redirect to home.php after successful submission
            ?>
                <script>
                    alert("Thank you! Your courier application has been submitted successfully!");
                    window.location.href = '../employee/status.php';
                </script>
            <?php
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
