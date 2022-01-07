<?php
session_start();

include('class/database.php');
class loginPage extends database
{

    protected $link;

    public function loginFunction()
    {
        if (isset($_POST['submit'])) {
            $custom = addslashes(trim($_POST['custom']));
            $email = trim($_POST['email']);
            $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                . '0123456789'); // and any other characters
            shuffle($seed); // probably optional since array_is randomized; this may be redundant
            $rand = '';
            foreach (array_rand($seed, 6) as $k) $rand .= $seed[$k];

            $code = $rand;
            $text = $custom . $email . $code . time();
            $hash = md5($text);

            $sqlP = "SELECT * from user_tbl where email = '$custom' ";
            $resP = mysqli_query($this->link, $sqlP);

            $x = 0;

            if (mysqli_num_rows($resP) > 0) {
                $x = 1;
                $sql = "UPDATE `user_tbl` SET `hash`= '$hash',`code`= '$code' WHERE email = '$custom'";
            }

            if ($x == 0) {
                return 'Please Sign Up';
            }
            $res = mysqli_query($this->link, $sql);
            if ($res) {

                $_SESSION['get_email'] = $custom;

                $subject = "Website: Password Change";
                $message = 'Your code is: ';
                $message .= "<b>$code</b><br>";
                $message .= "This is one time code";
                $message .= "Click this link: <br>";
                $message .= '<a style="padding:10px 60px;background-color: #F3CC3C;color:#000;font-weight:600;text-decoration:none" href="https://homework-6.000webhostapp.com/recovery_code.php?recovery=' . $hash . '">Recover Password</a>';
                $headers = "From: info@joinautonomy.eu \r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type: text/html;charset=UTF-8" . "\r\n";
                if (mail($email, $subject, $message, $headers)) {
                    return 'Email is Send!';
                }

                // header('location:recovery_code.php?recovery=' . $hash);
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
                            <h4 class="font-weight-bold pt-5 pb-4">FORGET PASSWORD</h4>

                            <?php if ($objLog) { ?>

                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong><?php echo $objLog; ?></strong>
                            </div>



                            <?php } ?>
                        </div>
                        <input type="email" name="email" class="form-control p-4  border-0 bg-light"
                            placeholder="Email Address you want to receive code" required>
                        <input type="email" class="form-control mt-4 p-4 border-0 bg-light" name="custom"
                            placeholder="Enter your email address in site" required>


                        <button type="submit" name="submit"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">Send Email</button>
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