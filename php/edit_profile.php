<?php
include('../config/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $phone1 = $conn->real_escape_string($_POST['phone1']);
    $phone2 = $conn->real_escape_string($_POST['phone2']);

    $id = $conn->real_escape_string($_POST['id']);

    $sql = "UPDATE  users SET phone1 = '$phone1', phone2 = '$phone2' WHERE ID = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to home.php after successful submission
        ?>
            <script>
                alert("Phone No. updated successfully!");
                window.location.href = '../employee/profile.php';
            </script>
        <?php
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
