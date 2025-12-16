<?php
session_start();
include('../config/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empCode = $_SESSION['empCode']; // Use session variable for employee code
    $currentPassword = $conn->real_escape_string($_POST['current_password']);
    $newPassword = $conn->real_escape_string($_POST['new_password']);
    $confirmPassword = $conn->real_escape_string($_POST['confirm_password']);

    // Fetch current password from database
    $sql = "SELECT Password FROM users WHERE EmpCode = '$empCode'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc(); 
        $Password = $row['Password'];

        if ($currentPassword === $Password) { // Compare with plain text password
            if ($newPassword === $confirmPassword) {
                // Update the password in the database without hashing
                $updateSql = "UPDATE users SET Password = '$newPassword' WHERE EmpCode = '$empCode'";

                if ($conn->query($updateSql) === TRUE) {
                    // Redirect to profile.php after successful submission
                    ?>
                    <script>
                        alert("Password changed successfully!");
                        window.location.href = '../employee/profile.php';
                    </script>
                    <?php
                    exit();
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            } else {
                ?>
                    <script>
                        alert("New password do not match!");
                        window.location.href = '../employee/profile.php';
                    </script>
                    <?php
            }
        } else {
            ?>
                <script>
                    alert("Current password is incorrect!");
                    window.location.href = '../employee/profile.php';
                </script>
            <?php
        }
    } else {
        echo "Employee code not found.";
    }
}

$conn->close();
?>
