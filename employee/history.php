<?php
session_start();
if (!isset($_SESSION['empCode'])) {
    header("Location: ../index.php");
    exit();
}

// Database connection
include('../config/connect.php');
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body style = "background: linear-gradient(rgba(241,241,241), rgba(243,243,243,0.8)), url('../images/bg.webp') no-repeat center fixed; background-size:cover;position:relative; width:100%"></body>
    <!-- Navbar -->
    <?php include('employee-navbar.php');?>
    <!-- Navbar -->
    <div class="container mt-5">
        <h2>Order History</h2>
        <div class="border p-2 rounded-2 bg-light bg-opacity-75">
        <?php
            // Fetch historical orders
            $employeeCode = $conn->real_escape_string($_SESSION['empCode']);
            $sql = "SELECT * FROM orders WHERE EmpCode = '$employeeCode'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                ?>
                    <div class="table-responsive" style = "font-size:15px;">
                        <table id="example" class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>PackageID</th>
                                    <th>OrderNo</th>
                                    <th>Purchase_Date</th>
                                    <th>E_Commerce</th>
                                    <th>Applied_Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['packageID']); ?></td>
                                                <td><?php echo htmlspecialchars($row['OrderNO']); ?></td>
                                                <td><?php echo htmlspecialchars($row['PurchaseDate']); ?></td>
                                                <td><?php echo htmlspecialchars($row['ECommerce']); ?></td>
                                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                                <td><a href="edit.php?id=<?php echo $row['ID'];?>" class = "btn btn-sm"><i class="bi bi-pencil-square"></i></a></td>
                                            </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                } else {
                    echo '<p>No orders found.</p>';
                }
            ?>
        </div>
    </div>
     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Bootstrap 5 JS -->
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>
</html>
