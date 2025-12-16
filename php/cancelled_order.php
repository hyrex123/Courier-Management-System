<?php
include('../config/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $reason = $conn->real_escape_string($_POST['reason']);
    $id = $conn->real_escape_string($_POST['id']);
    $current_date = date('Y-m-d H:i:s');

    $sql = "UPDATE  orders SET Status = 'Cancelled', cancelled_reasons = '$reason' WHERE ID = '$id'";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to home.php after successful submission
        ?>
            <script>
                alert("Thank you! Your package has cancelled successfully!");
                window.location.href = '../employee/status.php';
            </script>
        <?php
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
