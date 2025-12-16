<?php
include('../config/connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Prepare SQL query to fetch user data
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ss", $username, $password);
        
        // Execute the statement
        $stmt->execute();
        
        // Get the result
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            // Fetch the user data
            $user = $result->fetch_assoc();
            
            // Check the userType and redirect accordingly
            if ($user['UserType'] == 1) {
                $_SESSION['empName'] = $user['EmpName'];
                $_SESSION['empCode'] = $user['EmpCode'];
                $_SESSION['location'] = $user['Location'];
                $_SESSION['role'] = $user['UserType'];
                $_SESSION['ID'] = $user['ID'];

                // Redirect to employee page
                header("Location: ../employee/home.php");
                exit();
            } elseif ($user['UserType'] == 2) {
                // Redirect to driver page
                $_SESSION['empName'] = $user['EmpName'];
                $_SESSION['empCode'] = $user['EmpCode'];
                $_SESSION['location'] = $user['Location'];
                $_SESSION['role'] = $user['UserType'];
                $_SESSION['ID'] = $user['ID'];

                // Redirect to employee page
                header("Location: ../driver/driver.php");
                exit();
            } elseif ($user['UserType'] == 3){
                // Redirect to reciever page
                $_SESSION['empName'] = $user['EmpName'];
                $_SESSION['empCode'] = $user['EmpCode'];
                $_SESSION['location'] = $user['Location'];
                $_SESSION['role'] = $user['UserType'];
                $_SESSION['ID'] = $user['ID'];
                header("Location: ../receiver/receiver.php");
                exit();
            } else {
                echo "admin";
                exit();
            }
        } else {
            ?>
                <script>
                    alert("Invalid username & Password, please try again!!");
                    window.location.href = '../index.php';
                </script>
            <?php
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<p>There was an error processing your request. Please try again later.</p>";
    }

    // Close the connection
    $conn->close();
} else {
    echo "<p>No data received. Please go back and submit the form.</p>";
}
?>

