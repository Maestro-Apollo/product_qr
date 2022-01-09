<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light bg_color">
        <div class="container">
            <a class="navbar-brand font-weight-bold" style="font-family: 'Lato', sans-serif; color: #481639"
                href="index.php"><img src="images/leaf.jpg" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="index.php">Home</a>
                    </li>


                    <!-- If the user is logged in and session is set then these nav option will show -->
                    <?php if (isset($_SESSION['email'])) { ?>

                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="check-qr-code.php">Register New Item
                        </a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="change-link.php">Change Your Link
                        </a>
                    </li>


                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="about_us.php">About Us
                        </a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="logout.php">Logout
                        </a>
                    </li>
                    <!-- Bell color changing depending on progress -->





                    <?php } else if ($_SESSION['admin']) { ?>
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="admin.php">List of QR codes
                        </a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="create.php">Create QR Code
                        </a>
                    </li>


                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="about_us.php">About Us
                        </a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="logout.php">Logout
                        </a>
                    </li>
                    <?php } else { ?>
                    <!-- These are when user is not logged in -->
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="login.php">Login
                        </a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="register.php">Register
                        </a>
                    </li>
                    <!-- <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="register.php">Register
                        </a>
                    </li> -->
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="about_us.php">About Us
                        </a>
                    </li>

                    <?php } ?>





                </ul>

            </div>
        </div>
    </nav>
</div>