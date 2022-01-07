<?php
session_start();

include('class/database.php');
class signInUp extends database
{
    protected $link;
    public function signUpFunction()
    {
        if (isset($_POST['signup'])) {
            //addslashes take different ascii value and trim will remove start and last white space
            $fname = addslashes(trim($_POST['name']));
            $title = addslashes(trim($_POST['title']));
            $company = addslashes(trim($_POST['company']));
            $age = addslashes(trim($_POST['age']));
            // $age = addslashes(trim($_POST['age']));

            $email = addslashes(trim($_POST['email']));
            $phone = addslashes(trim($_POST['phone']));

            $img = 'user_img/' . time() . '_' . addslashes(trim($_FILES['image']['name']));

            $img1 = time() . '_' . addslashes(trim($_FILES['image']['name']));

            $target = 'user_img/' . $img1;

            $pass = trim($_POST['password']);

            //This will hash the password
            $password = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "select * from user_tbl where email = '$email'";
            $res = mysqli_query($this->link, $sql);
            $sql2 = "select * from user_tbl where company = '$company'";
            $res2 = mysqli_query($this->link, $sql2);
            if (mysqli_num_rows($res) > 0) {
                $msg = "Email is Taken";
                return $msg;
            } else if (mysqli_num_rows($res2) > 0) {
                $msg = "Company name is used";
                return $msg;
            } else {

                $sql3 = "INSERT INTO `user_tbl` (`id`, `pid`, `name`, `company`, `title`, `age`, `img`, `email`, `password`, `phone`, `created`) VALUES (NULL, NULL, '$fname', '$company', '$title', '$age', '$img', '$email', '$password', '$phone', CURRENT_TIMESTAMP)";
                $res3 = mysqli_query($this->link, $sql3);
                if ($res3) {
                    move_uploaded_file($_FILES['image']['tmp_name'], $target);
                    $_SESSION['email'] = $email;
                    //header function will redirect the user to profile.php page
                    header('location:result.php');
                } else {
                    $msg = "Not Added";
                    return $msg;
                }
            }
        }
        # code...
    }
}
$obj = new signInUp;
$objSignUp = $obj->signUpFunction();

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
        font-family: 'Lato', sans-serif;

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


                <!-- <form action="" method="post"> -->
                <div class="col-md-6 offset-3 ">
                    <form action="" method="post" enctype="multipart/form-data" data-parsley-validate>

                        <div class="text-center">
                            <h4 class="font-weight-bold pt-5">SIGNUP</h4>

                            <?php if ($objSignUp) { ?>
                            <?php if (strcmp($objSignUp, 'Email is Taken') == 0) { ?>
                            <div class="alert alert-warning alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Email is Taken</strong>
                            </div>
                            <?php } ?>
                            <?php if (strcmp($objSignUp, 'Company name is used') == 0) { ?>
                            <div class="alert alert-warning alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Company name is used</strong>
                            </div>
                            <?php } ?>
                            <?php if (strcmp($objSignUp, 'Not Added') == 0) { ?>
                            <div class="alert alert-warning alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Invalid Information!</strong>
                            </div>
                            <?php } ?>
                            <?php if (strcmp($objSignUp, 'Added') == 0) { ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Congratulation!</strong> Profile is created!
                            </div>
                            <?php } ?>

                            <?php } ?>
                        </div>
                        <input type="text" name="name" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Full Name" required>
                        <input type="text" name="title" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Person Title" required>
                        <input type="email" name="email" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Email Address" required>
                        <input type="text" name="company" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Company Name" required>
                        <input type="number" name="age" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Age" required>
                        <input type="text" name="phone" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Phone Number" required>
                        <input type="password" id="passwordField" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Password" data-parsley-minlength="5" required>
                        <input data-parsley-equalto="#passwordField" type="password"
                            class="form-control mt-4 p-4 border-0 bg-light" name="password"
                            placeholder="Confirm Password" required>
                        <div class="custom-file mt-4">
                            <input type="file" name="image" class="custom-file-input" accept="image/*" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose image</label>
                        </div>
                        <button name="signup" type="submit"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SIGNUP</button>

                    </form>
                </div>
                <!-- </form> -->
            </div>

        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>

    <script src="js/datepicker.js"></script>
    <script>
    $('[data-toggle="datepicker"]').datepicker({
        autoClose: true,
        viewStart: 2,
        format: 'dd/mm/yyyy',

    });
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    </script>
</body>

</html>