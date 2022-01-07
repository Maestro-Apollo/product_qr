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
            $email = addslashes(trim($_POST['email']));
            $phone = addslashes(trim($_POST['phone']));
            $age = addslashes(trim($_POST['age']));
            $title = addslashes(trim($_POST['title']));
            $password = addslashes(trim($_POST['password']));

            $pass = password_hash($password, PASSWORD_DEFAULT);
            $img = 'user_img/' . time() . '_' . addslashes(trim($_FILES['image']['name']));

            $img1 = time() . '_' . addslashes(trim($_FILES['image']['name']));

            $target = 'user_img/' . $img1;

            $email_admin = $_SESSION['email'];
            $sql3 = "SELECT * from user_tbl where email = '$email_admin' ";
            $res3 = mysqli_query($this->link, $sql3);
            if (mysqli_num_rows($res3) > 0) {
                $row = mysqli_fetch_assoc($res3);
                $pid = $row['id'];
                $company = $row['company'];

                $sqlFind = "SELECT * from user_tbl where email = '$email' ";
                $resFind = mysqli_query($this->link, $sqlFind);
                if (mysqli_num_rows($resFind) > 0) {
                    $msg = 'Email is taken';
                    return $msg;
                } else {
                    $sql2 = "INSERT INTO `user_tbl` (`id`, `pid`, `name`, `company`, `title`, `age`, `img`, `email`, `password`, `phone`, `created`) VALUES (NULL, '$pid', '$fname','$company', '$title', '$age', '$img', '$email', '$pass', '$phone', CURRENT_TIMESTAMP)";
                    $res2 = mysqli_query($this->link, $sql2);
                    if ($res2) {

                        //This session['email'] variable will be accessed by all session_start()
                        move_uploaded_file($_FILES['image']['tmp_name'], $target);

                        //header function will redirect the user to profile.php page
                        header('location:result.php');
                        $msg = "Added";
                        return $msg;
                    }
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
                    <h4 class="font-weight-bold pt-5 text-center">CREATE USER</h4>
                    <?php if ($objSignUp) { ?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><?php echo $objSignUp; ?></strong>
                    </div>
                    <?php } ?>
                    <form action="" method="post" enctype="multipart/form-data" class="form-group"
                        data-parsley-validate>




                        <input name="name" type="text" class="form-control p-4 border-0 bg-light"
                            placeholder="Full Name" required>
                        <input name="age" type="number" min='1' class="form-control p-4 mt-4 border-0 bg-light"
                            placeholder="Age" required>
                        <input name="title" type="text" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Title" required>


                        <input type="email" name="email" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Email Address" required>
                        <input type="password" name="password" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Password" required>
                        <input type="text" name="phone" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Phone Number" required>
                        <div class="custom-file mt-4">
                            <input type="file" name="image" class="custom-file-input" accept="image/*" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose image</label>
                        </div>

                        <button name="signup" type="submit"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>

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
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    </script>
</body>

</html>