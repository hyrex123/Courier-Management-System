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
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(rgba(241,241,241), rgba(243,243,243,0.8)), url('../images/bg.webp') no-repeat center fixed; background-size:cover; position:relative; width:100%">
    <!-- Navbar -->
    <?php include('employee-navbar.php');?>
    <!-- Navbar -->
    <div class="container mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="bg-light bg-opacity-25">
                <?php
                    // Fetch historical orders
                    $employeeCode = $conn->real_escape_string($_SESSION['empCode']);
                    $sql = "SELECT * FROM orders WHERE EmpCode = '$employeeCode' ORDER BY created_at DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                ?>
                            <div class="card mt-3 shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center text-light" style="background: rgb(240,19,19); background: linear-gradient(90deg, rgba(240,19,19,1) 0%, rgba(255,10,2,1) 35%, rgba(145,3,3,1) 100%);">
                                    <h6 class="mb-0">Package Detail 
                                        <?php 
                                            if($row['Status'] != 'Receiver_Approved' && $row['Status'] != 'Admin_Approved'){
                                                ?>
                                                    | <a href="edit.php?id=<?php echo $row['ID']?>" class = "btn"><i class="bi bi-pencil-square"></i></a>
                                                <?php
                                            }
                                        ?>
                                    </h6>
                                    <div class="notification">
                                        <i class="bi bi-calendar-check-fill"></i>
                                        <span style="font-size: 16px;">
                                            <?php
                                            $createdAt = $row['created_at'];
                                            $date = new DateTime($createdAt);
                                            echo htmlspecialchars($date->format('d/m/Y'));
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table" style="font-size:14px;">
                                        <tr>
                                            <th>Package Arrived At</th>
                                            <td><?php echo htmlspecialchars($row['arrived_location']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Package ID</th>
                                            <td><?php echo htmlspecialchars($row['packageID']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Order No</th>
                                            <td><?php echo htmlspecialchars($row['OrderNO']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>E-Commerce</th>
                                            <td><?php echo htmlspecialchars($row['ECommerce']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Purchase Date</th>
                                            <td>
                                                <?php 
                                                $purchaseDate = $row['PurchaseDate'];
                                                $pdate = new DateTime($purchaseDate);
                                                echo htmlspecialchars($pdate->format('d/m/Y'));
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                            if($row['Status'] == 'Cancelled'){
                                                ?>
                                                    <tr>
                                                        <th>Cancelled Reason</th>
                                                        <td><?php echo htmlspecialchars($row['cancelled_reasons']); ?></td>
                                                    </tr>
                                                <?php
                                            }
                                        ?>
                                    </table>
                                    <?php 
                                    if($row['Status'] != 'Receiver_Approved' && $row['Status'] != 'Admin_Approved' && $row['Status'] != 'Cancelled' ){
                                    ?>
                                        <form action="../php/cancelled_order.php" method="POST">
                                            <input type="hidden" name = "id" value = "<?php echo $row['ID'];?>">
                                            <div class="mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label">Cancelled Reason</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" name = "reason" rows="3" required></textarea>
                                            </div>
                                            <button type = "submit" class="btn btn-danger rounded-1 shadow-sm">Cancel</button>
                                        </form> 
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="card-footer p-1" style="background-color:#f01313;color:white;">
                                </div>
                            </div>             
                <?php
                        }
                    } else {
                        echo '<p>No orders found.</p>';
                    }
                ?>
                </div>
            </div>
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
