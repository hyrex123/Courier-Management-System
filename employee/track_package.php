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
    <title>CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .NotMentioned-input {
            display: none; /* Hide the text box by default */
        }
    </style>
</head>
<body class = "vh-100" style = "background: linear-gradient(rgba(241,241,241), rgba(243,243,243,0.8)), url('../images/bg.webp') no-repeat center fixed; background-size:cover;position:relative; width:100%"></body>
    <!-- Navbar -->
    <?php include('employee-navbar.php');?>
    <!-- Navbar -->
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <?php 
                    $pid = $_GET['packageID'];
                    $sql = "SELECT * FROM orders WHERE packageID = '$pid'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                           ?>
                            <div class="card mb-8 shadow-sm border border-danger">
                                <!-- <div class="card-header"><h6>Edit Courier</h6></div> -->
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><i class="bi bi-geo-alt-fill"></i> Package Location</h6>
                                    <div class="notification">
                                        <a href="home.php" style = "text-decoration:none; color:black;">
                                            <i class="bi bi-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table" style="font-size:14px;">
                                        <tr>
                                            <th>PackageID</th>
                                            <td><?php echo htmlspecialchars($row['packageID']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Package Arrived At</th>
                                            <td><?php echo htmlspecialchars($row['arrived_location']); ?> <i class="bi bi-geo"></i></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="card-footer p-1" style = "background: rgb(240,19,19); background: linear-gradient(90deg, rgba(240,19,19,1) 0%, rgba(255,10,2,1) 35%, rgba(145,3,3,1) 100%);"></div>
                            </div>
                           <?php
                        }
                    }
                ?>
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
