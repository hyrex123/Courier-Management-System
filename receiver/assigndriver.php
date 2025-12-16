<?php
session_start();
if (!isset($_SESSION['empCode']) || !isset($_SESSION['empName'])) {
    header("Location: ../index.php");
    exit();
}

// Database connection
include('../config/connect.php');

// Check if there are selected orders passed from approve.php
$selected_orders = [];
if (isset($_POST['selected_orders'])) {
    $selected_orders = $_POST['selected_orders'];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assign Driver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="vh-100" style="background: linear-gradient(rgba(241,241,241), rgba(243,243,243,0.8)), url('../images/bg.webp') no-repeat center fixed; background-size: cover; position: relative; width: 100%;">
<!-- Navbar -->
<?php include('../receiver/receiver-navbar.php'); ?>
<!-- Navbar -->
<section class="vh-80 d-flex align-items-center">
    <div class="container mt-4">
        <!-- Driver Assignment Form -->
        <form action="driver.php" method="post">
            <div class="border p-2 rounded-2 bg-light bg-opacity-75 mt-2">
                <h5>Assign Driver to Selected Packages</h5>
                <div class="table-responsive" style="font-size: 13px;">
                    <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>OrderNo</th>
                                <th>Emp Name</th>
                                <th>E_Commerce</th>
                                <th>Delivery Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($selected_orders as $orderNO) {
                                // Fetch order details based on the selected OrderNO
                                $sql_order = "SELECT OrderNO, created_by, ECommerce, delivery_date FROM orders WHERE OrderNO = ?";
                                $stmt_order = $conn->prepare($sql_order);
                                $stmt_order->bind_param("s", $orderNO);
                                $stmt_order->execute();
                                $result_order = $stmt_order->get_result();

                                if ($result_order->num_rows > 0) {
                                    while ($row = $result_order->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td><input type='checkbox' name='selected_orders[]' value='" . htmlspecialchars($row['OrderNO']) . "'></td>";
                                        echo "<td>" . htmlspecialchars($row['OrderNO']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['created_by']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['ECommerce']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['delivery_date']) . "</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
              <!-- Dropdown for Drivers -->
              <div class="col-lg-2" style="position: absolute;">
              <h6>Available Drivers</h6>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Select Driver
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php
                        $sql = "SELECT * FROM users WHERE UserType = 2";
                        $result = mysqli_query($conn, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<li>';
                                echo '<a class="dropdown-item" href="#">';
                                echo "<strong>Driver Code:</strong> " . htmlspecialchars($row['EmpCode']) . "<br>";
                                echo "<strong>Name:</strong> " . htmlspecialchars($row['EmpName']);
                                echo '</a>';
                                echo '</li>';
                                echo '<li><hr class="dropdown-divider"></li>'; // Divider between items
                            }
                        } else {
                            echo '<li><p class="dropdown-item">No drivers available.</p></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- Submit button -->
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">Proceed</button>
            </div>
        </form>
    </div>
</section>
<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting immediately

        // Show the success alert
        alert("Packages assigned to driver!");

        // Redirect to homepage after showing the alert
        window.location.href = '../receiver/receiver.php';
    });
</script>
</body>
</html>
