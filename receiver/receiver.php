<?php
session_start();
if (!isset($_SESSION['empCode']) || !isset($_SESSION['empName'])) {
    header("Location: ../index.php");
    exit();
}

// Database connection
include('../config/connect.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receiver Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <style>
        #card {
            text-decoration: none;
        }
        #card .card-footer span {
            color: black;
        }
        #card .card-footer:hover {
            background: rgb(240,19,19);
            background: linear-gradient(90deg, rgba(240,19,19,1) 0%, rgba(255,10,2,1) 35%, rgba(145,3,3,1) 100%);
            color: white;
        }
        .notification {
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body class="vh-100" style="background: linear-gradient(rgba(241,241,241), rgba(243,243,243,0.8)), url('../images/bg.webp') no-repeat center fixed; background-size: cover; width: 100%;">
    <!-- Navbar -->
    <?php include('../receiver/receiver-navbar.php'); ?>
    <!-- Navbar -->
    <section class="vh-80 d-flex align-items-center">
        <div class="container">
            <div class="row mt-4 p-2">
                <?php
                // Fetch Applied Packages
                $sql1 = "SELECT COUNT(*) AS total_applied FROM orders WHERE Status = 'Employee_Applied'";
                $result1 = mysqli_query($conn, $sql1);
                $total_applied = $result1 ? mysqli_fetch_assoc($result1)['total_applied'] : 0;

                // Fetch Approved Packages
                $sql2 = "SELECT COUNT(*) AS total_approved FROM orders WHERE Status = 'Approved'";
                $result2 = mysqli_query($conn, $sql2);
                $total_approved = $result2 ? mysqli_fetch_assoc($result2)['total_approved'] : 0;

                // Fetch List of Drivers
                $sql3 = "SELECT COUNT(*) AS total_drivers FROM users WHERE UserType = 2";
                $result3 = mysqli_query($conn, $sql3);
                $total_drivers = $result3 ? mysqli_fetch_assoc($result3)['total_drivers'] : 0;
                ?>

                <!-- Applied Package -->
                <div class="col-lg-4 mt-2">
                    <a href="package.php" id="card">
                        <div class="card shadow-sm text-light">
                            <div class="card-body p-1 text-dark">
                                <div class="row g-1">
                                    <div class="col-lg-12">
                                        <div class="p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">Applied Package</h6>
                                                <div class="notification">
                                                    <?php echo $total_applied; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <span>More <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- List of Drivers -->
                <div class="col-lg-4 mt-2">
                    <a href="assigndriver.php" id="card">
                        <div class="card shadow-sm text-light">
                            <div class="card-body p-1 text-dark">
                                <div class="row g-1">
                                    <div class="col-lg-12">
                                        <div class="p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">Assign Drivers</h6>
                                                <div class="notification">
                                                    <?php echo $total_drivers; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <span>More<i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <hr />
            <h5>History</h5>
            <div class="border p-2 rounded-2 bg-light bg-opacity-75">
                <?php
                // Fetch historical orders for the logged-in employee
                $employeeCode = $conn->real_escape_string($_SESSION['empCode']);
                $sql = "SELECT * FROM orders WHERE EmpCode = '$employeeCode' AND Status != 'Employee_Applied'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    ?>
                    <div class="table-responsive" style="font-size: 15px;">
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
                                        <td><a href="edit.php?id=<?php echo $row['ID']; ?>" class="btn btn-sm"><i class="bi bi-pencil-square"></i></a></td>
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
    </section>
</body>
</html>
