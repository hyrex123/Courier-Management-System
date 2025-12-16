<style>
    #a-text{
        color:white;
    }
    #a-text:hover{
        color:black;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary shadow text-light" style = "background: rgb(240,19,19); background: linear-gradient(90deg, rgba(240,19,19,1) 0%, rgba(255,10,2,1) 35%, rgba(145,3,3,1) 100%);">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a class="navbar-brand mt-2 mt-lg-0" href="home.php">
                <div class="shadow">
                    <img src="../images/logo.png" class = "img-fluid shadow" alt="logo" style = "width:45px; height:45px;">
                </div>
            </a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="home.php" id = "a-text"><i class="bi bi-house"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="status.php"  id = "a-text"><i class="bi bi-arrow-up"></i> Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="history.php"  id = "a-text"><i class="bi bi-clock-history"></i> History</a>
                </li>
            </ul>
        </div>

        <div class="d-flex align-items-center">
            <span class="mx-1"><?php echo ($_SESSION['empName']); ?> &nbsp;</span>
            <div class="dropdown">
                <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-5 text-light"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                    <li><a class="dropdown-item" href="profile.php">My profile</a></li>
                    <li><a class="dropdown-item" href="../php/logout.php">Logout</a></li>
                </ul>

            </div>
        </div>
    </div>
</nav>

