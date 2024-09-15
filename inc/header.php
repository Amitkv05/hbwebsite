<!-- Header Start -->

<nav id="nav-bar" class="navbar navbar-expand-lg navbar-dark bg-green px-lg-3 py-lg-2 shadow-sw sticky-top">
    <div class="container-fluid">    
    <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><img src="images\icon\airplane.png" style="width: 30px;" alt=""> <?php echo $settings_r['site_title'] ?> </a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link me-2" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="rooms.php">Hotel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="package.php">Package</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="facilities.php">Facilities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="contact.php">Contact us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php
                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                    echo <<<data
                        <div class="btn-group ">
                            <button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                               $_SESSION[username]
                            </button>
                            <ul class="dropdown-menu dropdown-menu-lg-end">
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="bookings.php">Bookings</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    data;
                } else {
                    echo <<<data
                            <button type="button" class="btn btn-outline_dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Login
                            </button>
                            <button type="button" class="btn btn-outline_dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">
                                Register
                            </button>
                        data;
                }
                ?>
            </div>
        </div>
    </div>
</nav>

<!--Login Modal -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" id="login-form">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <!-- me = margin end -->
                        <i class="bi bi-person-circle fs-3 me-3"></i> User Login
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label class="form-label">User Name</label>
                            <input type="text" name="username" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control shadow-none" required>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <button type="submit" name="login" class="btn btn-dark shadow-none">
                                Login
                            </button>
                            <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password?</a>
                        </div>
                    </div>
                </div>
                <?php
                require('inc/login.php');
                ?>
            </form>
        </div>
    </div>
</div>

<!-- User Registration  Modal -->
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="register-form" action="" method="post">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <!-- me = margin end -->
                        <i class="bi bi-person-lines-fill fs-3 me-3"></i> User Registration
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- lh = line height -->
                    <span class="badge rounded-pill text-dark bg-light text-wrap lh-base">
                        Note: Your details must match with your ID (Aadhar card, password, driving license, etc.)
                        that will be required during check-in.
                    </span>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Name</label>
                                <input name="name" type="text" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">User Name</label>
                                <input name="username" type="text" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Password</label>
                                <input name="password" type="password" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input name="confirmpassword" type="password" class="form-control shadow-none" required>
                            </div>
                            <div class="text-center my-1">
                                <button type="submit" name="register" class="btn btn-dark shadow-none">
                                    Register
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
require('inc/register.php');
?>


<!-- Header end -->