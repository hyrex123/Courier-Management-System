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
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM orders WHERE ID = '$id'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $_SESSION['orderID'] = $row['OrderNO'];
                            $_SESSION['purchaseDate'] = $row['PurchaseDate'];
                            $_SESSION['ecommerce'] = $row['ECommerce'];
                        }
                    }
                ?>
                <div class="card mb-8 shadow-sm border border-danger">
                    <!-- <div class="card-header"><h6>Edit Courier</h6></div> -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Edit Package Detail</h6>
                        <div class="notification">
                            <a href="home.php" style = "text-decoration:none; color:black;">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="../php/edit_order.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <div class="row g-8 align-items-center mb-2">
                                <div class="col-lg-6">
                                    <label for="orderNo" class="col-form-label">Order ID</label>
                                </div>
                                <div class="col-lg-5">
                                    <input type="text" id="orderNo" name="orderNo" value = "<?php echo $_SESSION['orderID'];?>"class="form-control shadow-sm" aria-describedby="orderHelpInline">
                                </div>
                            </div>
                            <div class="row g-8 align-items-center mb-2">
                                <div class="col-lg-6">
                                    <label for="purchaseDate" class="col-form-label">Purchase Date</label>
                                </div>
                                <div class="col-lg-5">
                                    <input type="date" id="purchaseDate" name="purchaseDate" value = "<?php echo $_SESSION['purchaseDate'];?>" class="form-control shadow-sm" aria-describedby="dateHelpInline">
                                </div>
                            </div>
                            <div class="row g-8 align-items-center mb-2">
                                <div class="col-lg-6">
                                    <label for="ecommerce" class="col-form-label">E-Commerce</label>
                                </div>
                                <div class="col-lg-5">
                                    <select class="form-select shadow-sm" id="ecommerce" name="ecommerce" required>
                                        <option value="<?php echo $_SESSION['ecommerce'];?>" selected><?php echo $_SESSION['ecommerce'];?></option>
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
                            <button type="submit" class="btn rounded-1 mt-2 text-light shadow-sm" style = "background-color:#f01313;">Edit</button>
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
