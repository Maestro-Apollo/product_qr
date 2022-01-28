<?php
session_start();


include('class/database.php');
class loginPage extends database
{

    protected $link;

    public function loginFunction()
    {

        if (isset($_POST['submit'])) {
            $email = trim($_POST['email']);


            $seed = str_split('0123456789'); // and any other characters
            shuffle($seed); // probably optional since array_is randomized; this may be redundant
            $rand = '';
            foreach (array_rand($seed, 6) as $k) $rand .= $seed[$k];

            $code = $rand;
            $text = $email . $code . time();
            $hash = md5($text);

            $sqlP = "SELECT * from user_tbl where email = '$email' ";
            $resP = mysqli_query($this->link, $sqlP);




            if (mysqli_num_rows($resP) > 0) {
                $sql = "UPDATE `user_tbl` SET `hash`= '$hash',`code`= '$code' WHERE email = '$email'";
            } else {
                return '<div class="alert alert-danger">
                <strong>Please Sign Up!</strong>
            </div>';
            }


            $res = mysqli_query($this->link, $sql);
            if ($res) {
                $email2 = $email;

                $subject = "Verification Code";
                $message = 'This is one time 6 digits code!<br><br>';
                // $message .= "Please approve this user<br>";
                // $message .= "Click this link: <br><br>";
                $message .= 'Your code is: ';
                $message .= "<h3><b>$code</b></h3><br>";

                $headers = "From: info@encryptclothing.co.uk \r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type: text/html;charset=UTF-8" . "\r\n";

                if (mail($email, $subject, $message, $headers)) {
                    header('location:recovery-code.php?hash=' . $hash);
                } else {
                    return '<div class="alert alert-danger">
                <strong>Invalid Information!</strong>
            </div>';
                }
            }
        }
        # code...
    }
}
$obj = new loginPage;
$objFor =  $obj->loginFunction();

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
                    <form method="post" data-parsley-validate>

                        <div class="text-center">
                            <h4 class="font-weight-bold pt-5 pb-4">Forget Password</h4>

                            <?php if (isset($objFor)) {
                                echo $objFor;
                            } ?>
                        </div>
                        <input type="email" name="email" class="form-control p-4 bg-light"
                            placeholder="Enter your email address" required>



                        <button type="submit" name="submit"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">Send</button>
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
    <script>

    </script>
</body>

</html>