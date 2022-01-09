<?php
session_start();
if (isset($_SESSION['email'])) {
} else {
    header('location:login.php');
}
include('class/database.php');
class signInUp extends database
{
    protected $link;

    public function signInFunction()
    {
        if (isset($_POST['signIn'])) {
            $email = $_SESSION['email'];
            $name = $_POST['name'];
            $id_number = $_POST['id_number'];
            $security = $_POST['security'];

            $six_digit_random_number = random_int(100000, 999999);

            $sql = "SELECT * from qr_tbl where user_email = '$email' AND product_id = '$id_number' AND `security` = '$security' ";
            $res = mysqli_query($this->link, $sql);

            if (mysqli_num_rows($res) > 0) {
                $sqlUpdate = "UPDATE qr_tbl SET user_confirm = 1, `security` = '$six_digit_random_number', `product_name` = '$name' where user_email = '$email' AND product_id = '$id_number' ";
                $resUpdate = mysqli_query($this->link, $sqlUpdate);
                if ($resUpdate) {
                    header('location:change-link.php');
                }
            } else {
                return 'Wrong Information';
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
                            <h4 class="font-weight-bold pt-5 pb-4">Add New Item</h4>

                            <?php if ($objSignIn) { ?>
                            <?php if (strcmp($objSignIn, 'Wrong Information') == 0) { ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Wrong Information!</strong>
                            </div>
                            <?php } ?>


                            <?php } ?>
                        </div>
                        <input type="text" name="name" class="form-control p-4   bg-light" placeholder="Enter Item Name"
                            required>
                        <input type="text" class="form-control mt-4 p-4  bg-light" name="id_number"
                            placeholder="Enter your Id Number" required>
                        <input type="number" class="form-control mt-4 p-4  bg-light" name="security"
                            placeholder="Enter Security Code" required>


                        <button type="submit" name="signIn"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">ADD</button>
                        <!-- <small class="font-weight-bold mt-1 text-muted"><a href="forget_password.php"
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