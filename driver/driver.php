<?php
session_start();
if (!isset($_SESSION['empCode']) || !isset($_SESSION['empName'])) {
    header("Location: ../index.php");
    exit();
}

// Database connection
include('../config/connect.php');

// Retrieve selected orders and driver code from session
$selected_orders = isset($_SESSION['selected_orders']) ? $_SESSION['selected_orders'] : [];
$driver_code = isset($_SESSION['driver_code']) ? $_SESSION['driver_code'] : '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <div class="border p-2 rounded-2 bg-light bg-opacity-75 mt-2">
            <h5>Packages Assigned</h5>
            <div class="table-responsive" style="font-size: 13px;">
                <table class="table table-striped table-borderless">
                    <thead>
                        <tr>
                            <th>OrderNo</th>
                            <th>EmpName</th>
                            <th>E_Commerce</th>
                            <th>Delivery Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($selected_orders)) {
                            foreach ($selected_orders as $orderNO) {
                                // Fetch order details based on the selected OrderNO
                                $sql_order = "SELECT OrderNO,created_by, ECommerce, delivery_date FROM orders WHERE OrderNO = ?";
                                $stmt_order = $conn->prepare($sql_order);
                                $stmt_order->bind_param("s", $orderNO);
                                $stmt_order->execute();
                                $result_order = $stmt_order->get_result();

                                if ($result_order->num_rows > 0) {
                                    while ($row = $result_order->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['OrderNO']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['created_by']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['ECommerce']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['delivery_date']) . "</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                        } else {
                            echo "<tr><td colspan='4'>No Packages Assigned  .</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

</body>
</html>
