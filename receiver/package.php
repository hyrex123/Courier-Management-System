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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body class="vh-100" style="background: linear-gradient(rgba(241,241,241), rgba(243,243,243,0.8)), url('../images/bg.webp') no-repeat center fixed; background-size: cover; width: 100%;">

    <!-- Navbar -->
    <?php include('../receiver/receiver-navbar.php'); ?>
    <!-- Navbar -->

    <section class="vh-80 d-flex align-items-center">
        <div class="container mt-4">
            <div class="d-flex justify-content-between mb-3">
                <h6>Applied Package</h6>
                <a href="#" class="btn btn-sm rounded-1 btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">View Emp</a>
            </div>

            <!-- Popup for employee master -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title fs-5" id="exampleModalLabel">Employee Master</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php
                            $sql_emp = "SELECT * FROM users";
                            $result_emp = $conn->query($sql_emp);

                            if ($result_emp->num_rows > 0) {
                                ?>
                                <div class="table-responsive" style="font-size: 13px;">
                                    <table id="example" class="table table-striped table-borderless">
                                        <thead>
                                            <tr>
                                                <th>EmpCode</th>
                                                <th>EmpName</th>
                                                <th>Department</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $result_emp->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['EmpCode']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['EmpName']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['Department']); ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            } else {
                                ?>
                                <p class="p-2">No employees found</p>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="border p-2 rounded-2 bg-light bg-opacity-75 mt-2">
                <?php
                $sql = "SELECT * FROM orders WHERE Status = 'Employee_Applied'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    ?>
                    <div class="table-responsive" style="font-size: 13px;">
                        <table id="example1" class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>EmpCode</th>
                                    <th>EmpName</th>
                                    <th>OrderNo</th>
                                    <th>E_Commerce</th>
                                    <th>Applied_Date</th>
                                    <th>Actions</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['EmpCode']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_by']); ?></td>
                                        <td><?php echo htmlspecialchars($row['OrderNO']); ?></td>
                                        <td><?php echo htmlspecialchars($row['ECommerce']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                        <td>
                                            <a class="btn btn-sm rounded-1 btn-success shadow-sm approve-btn" href="../php/package_id.php?id=<?php echo $row['ID']; ?>" data-id="<?php echo $row['ID']; ?>">Approve</a>
                                            <td><input type="checkbox" name="selected_orders[]" value="<?php echo htmlspecialchars($row['OrderNO']); ?>"></td>
                                        </td>

                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                            <!-- Align the button to the right -->
                            <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Proceed</button>
                                </div>
                    <?php
                } else {
                    ?>
                    <p class="p-2">No orders found</p>
                    <?php
                }
                ?>
            </div>

        </div>
    </section>

    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
$(document).ready(function () {
    $('#example').DataTable();
    $('#example1').DataTable();

    $('.approve-btn').click(function (event) {
        event.preventDefault(); // Prevent the default action (i.e., navigating to package_id.php)

        var button = $(this); // Get the clicked button
        var url = button.attr('href'); // Get the URL from the button's href attribute

        // Send an AJAX request to package_id.php
        $.ajax({
            url: url,
            type: 'GET', // Assuming the package_id.php processes GET requests
            success: function(response) {
                // On success, change the button text to "Approved"
                button.text('Approved').removeClass('btn-success').addClass('btn-secondary');
                button.css('pointer-events', 'none'); // Disable further clicks
            },
            error: function() {
                alert('Error processing the request. Please try again.');
            }
        });
    });
});
</script>

</body>
</html>
