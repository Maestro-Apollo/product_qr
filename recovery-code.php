<?php
session_start();
include('class/database.php');
class loginPage extends database
{

    protected $link;

    public function loginFunction()
    {

        if (isset($_POST['submit'])) {
            $hash = $_POST['hash'];
            $code = trim($_POST['code']);

            $sqlP = "SELECT * from user_tbl where `hash` = '$hash' AND code = '$code' ";
            $resP = mysqli_query($this->link, $sqlP);

            $x = 0;
            $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                . '0123456789'); // and any other characters
            shuffle($seed); // probably optional since array_is randomized; this may be redundant
            $rand = '';
            foreach (array_rand($seed, 6) as $k) $rand .= $seed[$k];

            $codeUpdate = $rand;


            if (mysqli_num_rows($resP) > 0) {
                $row = mysqli_fetch_assoc($resP);
                $email = $row['email'];


                $sql = "UPDATE `user_tbl` SET `code`= '$codeUpdate' WHERE email = '$email'";
                $res = mysqli_query($this->link, $sql);
                if ($res) {
                    $_SESSION['email'] = $email;
                    header('location:reset-password.php');
                }
            } else {
                return '<div class="alert alert-warning alert-dismissible">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Invalid Information!</strong>
</div>';
            }
        }

        # code...
    }
}
$obj = new loginPage;
$objRe = $obj->loginFunction();


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

                            <h4 class="font-weight-bold pt-5 pb-4">Recovery Code</h4>


                            <strong>Please check your email!</strong>

                            <?php if (isset($objRe)) {
                                echo $objRe;
                            } ?>

                        </div>
                        <input type="text" name="code" class="form-control p-4 bg-light" placeholder="Enter your code"
                            required>
                        <input type="hidden" name="hash" class="form-control pill rt-mb-15" placeholder="Enter Code"
                            value="<?php echo $_GET['hash']; ?>" required>


                        <button type="submit" name="submit"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">Submit</button>
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