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
    <title>Employee Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .NotMentioned-input {
            display: none; /* Hide the text box by default */
        }
    </style>
</head>
<body class = "vh-100" style = "background: linear-gradient(rgba(241,241,241), rgba(243,243,243,0.8)), url('../images/bg.webp') no-repeat center fixed; background-size:cover;position:relative; width:100%">
<!-- Navbar -->
<?php include('employee-navbar.php');?>
<!-- Navbar -->
<section class="vh-80 d-flex align-items-center">
    <div class="container">
        <div class="row mt-4 p-2">
            <div class="col-lg-5 mt-2">
                <?php
                    // Assuming you have already established a database connection in $conn
                    $sql4 = "SELECT COUNT(*) AS total_4_entries FROM orders WHERE Status = 'Admin_Approved'";
                    $result4 = mysqli_query($conn, $sql4);

                    if ($result4) {
                        $row = mysqli_fetch_assoc($result4);
                        $total_entries4 = $row['total_4_entries'];
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                ?>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen-xxl-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">List of arrived packages</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                    // Fetch historical orders
                                    $employeeCode = $conn->real_escape_string($_SESSION['empCode']);
                                    $sql = "SELECT * FROM orders WHERE EmpCode = '$employeeCode' AND Status = 'Admin_Approved'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        ?>
                                            <div class="table-responsive" style = "font-size:15px;">
                                                <table id="example" class="table table-striped table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>Package ID</th>
                                                            <th>E_Commerce</th>
                                                            <th>Received</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            while ($row = $result->fetch_assoc()) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo htmlspecialchars($row['packageID']); ?></td>
                                                                        <td><?php echo htmlspecialchars($row['ECommerce']); ?></td>
                                                                        <td><a href="#" class = "btn btn-sm btn-success">Approved</a></td>
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
                            <div class="modal-footer">
                                <button type="button" class="btn" data-bs-dismiss="modal" style = "background-color:#f01313;color:white;">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm text-light">
                    <div class="card-header d-flex justify-content-between align-items-center" style = "background: rgb(240,19,19); background: linear-gradient(90deg, rgba(240,19,19,1) 0%, rgba(255,10,2,1) 35%, rgba(145,3,3,1) 100%);">
                        <h6 class="mb-0">Status</h6>
                        <div class="notification">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" style = "text-decoration:none; color:white;">
                                <i class="bi bi-bell-fill"></i>
                                <span style="font-size: 16px;"><sup><?php echo $total_entries4;?></sup></span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-1 text-dark">
                        <div class="row g-1">
                            <?php
                                // Assuming you have already established a database connection in $conn
                                $sql1 = "SELECT COUNT(*) AS total_entries FROM orders";
                                $result = mysqli_query($conn, $sql1);

                                if ($result) {
                                    $row = mysqli_fetch_assoc($result);
                                    $total_entries = $row['total_entries'];
                                } else {
                                    echo "Error: " . mysqli_error($conn);
                                }
                            ?>

                            <div class="col-lg-12">
                                <div class="p-1">
                                    <a href="status.php" style = "text-decoration:none;color:black">
                                        <div class="border border-secondary shadow-sm rounded-1 p-2 d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0"><i class="bi bi-bag"></i> Applied Package</h6>
                                            <div class="notification">
                                                <span style = "font-size:16px; font-weight:bold;"><?php echo $total_entries;?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <?php
                                    // Assuming you have already established a database connection in $conn
                                    $sql3 = "SELECT COUNT(*) AS total_pendieng_entries FROM orders WHERE Status = 'Employee_Approved'";
                                    $result3 = mysqli_query($conn, $sql3);

                                    if ($result3) {
                                        $row = mysqli_fetch_assoc($result3);
                                        $total_entries3 = $row['total_pendieng_entries'];
                                    } else {
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                ?>
                                <div class="p-1">
                                    <a href="status.php" style = "text-decoration:none;color:green;">
                                        <div class="border border-success shadow-sm rounded-1 p-2 d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0"><i class="bi bi-bag-check text-success"></i> Package Received</h6>
                                            <div class="notification">
                                                <span style = "font-size:16px; font-weight:bold;color:green;"><?php echo $total_entries3;?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <?php
                                    // Assuming you have already established a database connection in $conn
                                    $sql2 = "SELECT COUNT(*) AS total_pendieng_entries FROM orders WHERE Status != 'Employee_Approved'";
                                    $result2 = mysqli_query($conn, $sql2);

                                    if ($result2) {
                                        $row = mysqli_fetch_assoc($result2);
                                        $total_entries2 = $row['total_pendieng_entries'];
                                    } else {
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                ?>
                                <div class="p-1">
                                    <a href="status.php" style = "text-decoration:none;color:red;">
                                        <div class="border border-danger shadow-sm rounded-1 p-2 d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0"><i class="bi bi-bag-x text-danger"></i> Pending</h6>
                                            <div class="notification">
                                                <span style = "font-size:16px; font-weight:bold; color:red;"><?php echo $total_entries2;?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-secondary bg-opacity-25">
                        <form action="track_package.php" method = "GET">
                            <div class="input-group">
                                <input type="text" name = "packageID" class="form-control" placeholder="Package ID" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button type = "submit" class="btn shadow-sm text-light" type="button" id="button-addon2" style = "background-color:#f01313;font-size:16px;">Track Package</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7 mt-2">
                <!-- Order Details -->
                <div class="card mb-8 shadow-sm border border-danger">
                    <div class="card-header"><h6>Apply Courier</h6></div>
                    <div class="card-body">
                        <form action="../php/submit_order.php" method="POST">
                            <input type="hidden" name="empcode" value="<?php echo $_SESSION['empCode']; ?>">
                            <input type="hidden" name="empname" value="<?php echo $_SESSION['empName']; ?>">
                            <input type="hidden" name="location" value="<?php echo $_SESSION['location']; ?>">
                            <div class="row g-8 align-items-center mb-2">
                                <div class="col-lg-6">
                                    <label for="orderNo" class="col-form-label">Order ID</label>
                                </div>
                                <div class="col-lg-5">
                                    <input type="text" id="orderNo" name="orderNo" class="form-control shadow-sm" aria-describedby="orderHelpInline">
                                </div>
                            </div>
                            <div class="row g-8 align-items-center mb-2">
                                <div class="col-lg-6">
                                    <label for="purchaseDate" class="col-form-label">Purchase Date</label>
                                </div>
                                <div class="col-lg-5">
                                    <input type="date" id="purchaseDate" name="purchaseDate" class="form-control shadow-sm" aria-describedby="dateHelpInline">
                                </div>
                            </div>
                            <div class="row g-8 align-items-center mb-2">
                                <div class="col-lg-6">
                                    <label for="ecommerce" class="col-form-label">E-Commerce</label>
                                </div>
                                <div class="col-lg-5">
                                    <select class="form-select shadow-sm" id="ecommerce" name="ecommerce" required>
                                        <option value="" selected>Select E-Commerce</option>
                                        <option value="Amazon">Amazon</option>
                                        <option value="eBay">eBay</option>
                                        <option value="Shopify">Shopify</option>
                                        <option value="NotMentioned">NotMentioned</option>
                                    </select>
                                    <div id="NotMentioned-input-box" class="NotMentioned-input">
                                        <label for="NotMentioned-text">specify</label>
                                        <input type="text" id="NotMentioned-text" name="NotMentioned-text" class="form-control mt-2">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn rounded-1 mt-2 text-light shadow-sm" style = "background-color:#f01313;">Submit</button>
                            <button type="reset" class="btn rounded-1 mt-2 mx-2 text-light shadow-sm" style = "background-color:#f01313;">Reset</button>
                        </form>

                        <script>
                            document.getElementById('ecommerce').addEventListener('change', function() {
                                var NotMentionedInputBox = document.getElementById('NotMentioned-input-box');
                                if (this.value === 'NotMentioned') {
                                    NotMentionedInputBox.style.display = 'block'; // Show the text box
                                } else {
                                    NotMentionedInputBox.style.display = 'none'; // Hide the text box
                                }
                            });
                        </script>
                    </div>
                    <div class="card-footer p-1" style = "background: rgb(240,19,19); background: linear-gradient(90deg, rgba(240,19,19,1) 0%, rgba(255,10,2,1) 35%, rgba(145,3,3,1) 100%);"></div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
