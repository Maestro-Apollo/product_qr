<?php
session_start();

include('class/database.php');
class loginPage extends database
{

    protected $link;

    public function loginFunction()
    {
        if (isset($_POST['submit'])) {
            $hash = $_GET['recovery'];
            $code = trim($_POST['code']);
            $email = $_SESSION['get_email'];
            // $username = addslashes(trim($_POST['username']));

            $sqlP = "SELECT * from user_tbl where email = '$email' ";
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
                $rowHash = $row['hash'];
                $rowCode = $row['code'];

                if (strcmp($rowHash, $hash) == 0 and strcmp($rowCode, $code) == 0) {
                    $x = 1;
                    $sql = "UPDATE `user_tbl` SET `code`= '$codeUpdate' WHERE email = '$email'";
                    $res = mysqli_query($this->link, $sql);
                    if ($res) {
                        // $_SESSION['name'] = $username;
                        header('location:reset_password.php');
                    }
                } else {
                    return "Invalid Information";
                }
            }

            if ($x == 0) {
                return 'Sign Up first';
            }
        }
        # code...
    }
}
$obj = new loginPage;
$objLog = $obj->loginFunction();
// $seed = str_split('abcdefghijklmnopqrstuvwxyz'
//     . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
//     . '0123456789'); // and any other characters
// shuffle($seed); // probably optional since array_is randomized; this may be redundant
// $rand = '';
// foreach (array_rand($seed, 6) as $k) $rand .= $seed[$k];

// echo '<h1 class="text-white">' . $rand . '</h1>';


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
                            <h4 class="font-weight-bold pt-5 pb-4">RECOVERY CODE</h4>

                            <?php if ($objLog) { ?>

                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong><?php echo $objLog; ?></strong>
                            </div>



                            <?php } ?>
                        </div>
                        <input type="text" name="code" class="form-control p-4  border-0 bg-light"
                            placeholder="Recovery Code" required>



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