<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <style>
            .divider:after,
            .divider:before {
                content: "";
                flex: 1;
                height: 1px;
                background: #eee;
            }
            .h-custom {
                height: calc(100% - 105px);
            }
            @media (max-width: 450px) {
                .h-custom {
                height: 100%;
            }
        }
        </style>
    </head>
    <body>
        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div class="#">
                    <img src="images/logo.png" class = "img-fluid shadow" alt="logo" style = "width:70px; height:70px;">
                </div>
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-3">
                        <div class="border p-4 shadow rounded-2">
                            <form action = "php/check_login.php" method = "POST">
                                <div class="d-flex flex-row align-items-center justify-content-center">
                                    <h5 class="text-center">Courier Management System</h5>
                                </div>

                                <div class="divider d-flex align-items-center my-4">
                                    <!-- <p class="text-center fw-bold mx-3 mb-0">***</p> -->
                                </div>

                                <!-- input -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example3">Username</label>
                                    <input type="text" id="form3Example3" name = "username" class="form-control form-control shadow-sm"
                                    placeholder="Enter your username here.." required />
                                </div>

                                <!-- Password input -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example4">Password</label>
                                    <input type="password" id="form3Example4" name = "password" class="form-control form-control shadow-sm"
                                    placeholder="Enter password" required />
                                </div>

                                <div class="text-center mt-4">
                                    <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn shadow text-light w-100"
                                    style="background-color:#f01313;">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <br /><br />
            <!-- Footer -->
            <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-3 px-2 px-xl-3" style="background: rgb(240,19,19); background: linear-gradient(90deg, rgba(240,19,19,1) 0%, rgba(255,10,2,1) 35%, rgba(145,3,3,1) 100%); font-size: 15px;">
                <!-- Copyright -->
                <div class="text-white mb-2 mb-md-2">
                    Copyright © 2024. All rights reserved.
                </div>
            </div>
        </section>
    </body>
</html>