<?php
session_start();

include('class/database.php');
class signInUp extends database
{
    protected $link;

    public function signInFunction()
    {
        if (isset($_POST['signIn'])) {
            $email = $_SESSION['email'];
            $password = $_POST['password'];

            $pass = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE user_tbl SET password = '$pass' WHERE email = '$email' ";
            $res = mysqli_query($this->link, $sql);
            if ($res) {
                return 'Updated!';
            } else {
                return 'Invalid Information';
            }
        }
        # code...
    }
}
$obj = new signInUp;
$objSignIn = $obj->signInFunction();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
    <style>
    body {
        font-family: 'Raleway', sans-serif;
    }

    .navbar-brand {
        width: 7%;
    }

    .bg_color {
        background-color: #fff !important;
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="container bg-white pr-4 pl-4  log_section pb-5">

            <div class="row">
                <div class="col-md-6 offset-3 ">
                    <form action="" method="post" data-parsley-validate>

                        <div class="text-center">
                            <h4 class="font-weight-bold pt-5 pb-4">Reset Password</h4>

                            <?php if ($objSignIn) { ?>
                            <?php if (strcmp($objSignIn, 'Updated!') == 0) { ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Password Updated!</strong>
                            </div>
                            <?php } ?>
                            <?php if (strcmp($objSignIn, 'Invalid Information') == 0) { ?>
                            <div class="alert alert-warning alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Please Sign Up!</strong>
                            </div>
                            <?php } ?>

                            <?php } ?>
                        </div>

                        <input type="password" class="form-control mt-4 p-4  bg-light" id="password" name="password"
                            placeholder="Enter your password" required>
                        <input data-parsley-equalto="#password" type="password" class="form-control mt-4 p-4  bg-light"
                            name="confirmPassword" placeholder="Confirm Password" required>


                        <button type="submit" name="signIn"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">LOGIN</button>
                        <!-- <small class="font-weight-bold mt-1 text-muted"><a href="forget-password.php"
                                style="color: #05445E;">Forget
                                Password</a></small> -->
                        <!-- <hr>
                        <small class="font-weight-bold mt-1 text-muted">Don't have an account? <a href="register.php"
                                style="color: #05445E;">Forget Password</a></small> -->

                    </form>
                </div>

                <!-- <form action="" method="post"> -->

                <!-- </form> -->
            </div>

        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>
</body>

</html>