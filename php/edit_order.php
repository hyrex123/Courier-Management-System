<?php
include('../config/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $orderID = $conn->real_escape_string($_POST['orderNo']);
    $orderNo = strtoupper($orderID);
    $purchaseDate = $conn->real_escape_string($_POST['purchaseDate']);
    $ecommerce = $conn->real_escape_string($_POST['ecommerce']);
    $id = $conn->real_escape_string($_POST['id']);
    $notMentioned = $conn->real_escape_string($_POST['NotMentioned-text']);  // Changed from Others to NotMentioned-text
    $current_date = date('Y-m-d H:i:s');

    // Proceed with the insertion if no duplicate is found
    if (!$notMentioned) {
        $sql = "UPDATE  orders SET OrderNO = '$orderNo', PurchaseDate = '$purchaseDate', ECommerce = '$ecommerce' WHERE ID = '$id'";
    } else {
        $sql = "UPDATE  orders SET OrderNO = '$orderNo', PurchaseDate = '$purchaseDate', ECommerce = '$notMentioned' WHERE ID = '$id'";
    }

    if ($conn->query($sql) === TRUE) {
        // Redirect to home.php after successful submission
        ?>
            <script>
                alert("Thank you! Your package edit successfully!");
                window.location.href = '../employee/edit.php?id=<?php echo $id;?>';
            </script>
        <?php
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
