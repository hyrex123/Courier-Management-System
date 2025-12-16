<?php
session_start();
if (!isset($_SESSION['empCode'])) {
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
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(rgba(241,241,241), rgba(243,243,243,0.8)), url('../images/bg.webp') no-repeat center fixed; background-size: cover; position: relative; width: 100%;">
    <!-- Navbar -->
    <?php include('employee-navbar.php');?>
    <!-- Navbar -->
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6><i class="bi bi-person-circle"></i> Profile</h6>
                    </div>
                    <div class="card-body">
                        <table class="table" style="font-size:15px;">
                            <tr>
                                <th>Name</th>
                                <td><?php echo $_SESSION['empName'];?></td>
                            </tr>
                        </table>
                        <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a>
                        <a href="#" class="btn btn-sm btn-secondary mx-1" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</a>
                    </div>
                    <div class="card-footer p-1" style="background-color:#f01313;color:white;"></div>
                </div>
            </div>
        </div>
    </div>

    <?php 
        $empcode = $_SESSION['empCode'];
        $sql = "SELECT * FROM users WHERE EmpCode = '$empcode'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['phone1'] = $row['phone1'];
                $_SESSION['phone2'] = $row['phone2'];
                $_SESSION['id'] = $row['ID'];
            }
        }
    ?>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class = "p-2" method="POST" action="../php/edit_profile.php">
                        <input type="hidden" name = "id" value = "<?php echo $_SESSION['id'];?>">
                        <div class="mb-2">
                            <label for="edit-phone" class="form-label">Phone Number 1</label>
                            <input type="number" class="form-control" id="edit-phone" name="phone1" value = "<?php echo  $_SESSION['phone1'];?>">
                        </div>
                        <div class="mb-2">
                            <label for="edit-phone" class="form-label">Phone Number 2</label>
                            <input type="number" class="form-control" id="edit-phone" name="phone2" value = "<?php echo  $_SESSION['phone2'];?>">
                        </div>
                        <button type="submit" class="btn rounded-1 mt-2 text-light shadow-sm" style = "background-color:#f01313;">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="../php/change_password.php">
                        <input type = "hidden" name = "empCode" value = "<?php echo $_SESSION['empCode'];?>">
                        <div class="mb-3">
                            <label for="current-password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current-password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new-password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new-password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn rounded-1 mt-2 text-light shadow-sm" style="background-color:#f01313;"> Change</button>
                    </form>
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
