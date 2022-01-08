<?php
session_start();

include('class/database.php');
class signInUp extends database
{
}
$obj = new signInUp;

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
        <div class="container bg-white pr-4 pl-4 shadow log_section pb-5">

            <div class="row">


                <!-- <form action="" method="post"> -->
                <div class="col-md-6">
                    <h4 class="font-weight-bold pt-5 text-center">CREATE QR CODE</h4>
                    <form action="" id="myForm">
                        <input type="email" name="email" class="form-control mt-4 p-4  bg-light"
                            placeholder="User Email Address" required>
                        <input type="text" name="id_number" class="form-control mt-4 p-4  bg-light"
                            placeholder="Enter ID number" required>
                        <input type="text" name="link" class="form-control mt-4 p-4  bg-light" placeholder="Enter URL"
                            required>
                        <button name="signup" type="submit"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">GENERATE</button>

                    </form>
                </div>
                <div class="col-md-6">
                    <div id="output"></div>

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

    <script>
    $(document).ready(function() {
        $('#myForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "ajax-qr-code.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#output').fadeIn().html(response);

                }
            });
            this.reset();

        });
    })
    </script>
</body>

</html>