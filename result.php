<?php
session_start();



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
        <div class="bg-white">

            <div style="width:100%; height:700px;" id="orgchart" />


        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>

    <script src="js/datepicker.js"></script>
    <script src="js/orgchart.js"></script>
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
    // let result = '';
    $.ajax({
        type: "GET",
        url: "ajaxFile.php",
        dataType: "json",
        success: function(response) {

            var data = response;



            var chart = new OrgChart(document.getElementById("orgchart"), {
                template: "diva",
                // miniMap: true,

                showYScroll: OrgChart.scroll.visible,
                showXScroll: OrgChart.scroll.visible,
                mouseScrool: OrgChart.action.zoom,

                nodeBinding: {
                    field_0: "name",
                    field_1: "title",
                    field_2: "phone",
                    field_3: "age",
                    img_0: "img"

                },
                nodes: data,

            });


            // result = response
            // console.log(result);
        }
    });
    // console.log(result);
    </script>

</body>

</html>