<?php
session_start();

if (isset($_SESSION['email'])) {
} else {
    header('location:login.php');
}
include('class/database.php');
class profile extends database
{
    protected $link;
    public function showProfile()
    {
        $email = $_SESSION['email'];
        $sql = "select * from user_tbl where email = '$email' ";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
}
$obj = new profile;
$objShow = $obj->showProfile();
// $objInsertInfo = $obj->insertProfileInfo();
$row = mysqli_fetch_assoc($objShow);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <style>
    .profileImage {
        height: 200px;
        width: 200px;
        object-fit: cover;
        border-radius: 50%;
        margin: 10px auto;
        cursor: pointer;

    }



    .upload_btn {
        background-color: #EEA11D;
        color: #05445E;
        transition: 0.7s;
    }

    .upload_btn:hover {
        background-color: #05445E;
        color: #EEA11D;
    }

    .navbar-brand {
        width: 7%;
    }

    .bg_color {
        background-color: #fff !important;
    }

    .gap {
        margin-bottom: 95px;
    }

    body {
        font-family: 'Lato', sans-serif;
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>


    <section>
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <h3 class="float-left d-block font-weight-bold" style="color: #05445E"><span
                            class="text-secondary font-weight-light">Welcome |</span>
                        <?php echo $row['name'] ?>
                    </h3>

                    <div class="account bg-white mt-5 p-5 rounded">
                        <div id="output"></div>

                        <h3 class="font-weight-bold mb-5" style="color: #05445E">QR Code Collections</h3>

                        <div class="table-responsive">

                            <table id="userTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Product ID</th>
                                        <th>link</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>


                            </table>
                        </div>
                        <div id="updateModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Update</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name">Product Name</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Enter Product Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="link">Link</label>
                                            <input type="text" class="form-control" id="link" placeholder="Enter link">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" id="txt_userid" value="0">
                                        <button type="button" class="btn btn-success btn-sm" id="btn_save">Save</button>
                                        <button type="button" class="btn btn-default btn-sm"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script>
    //This ajax call will take the user info to update.php
    var userDataTable = $('#userTable').DataTable({
        'processing': true,
        'serverSide': true,
        'columnDefs': [{
            orderable: false,
            targets: 0
        }],
        'serverMethod': 'post',
        "pageLength": 10,
        'ajax': {
            'url': 'ajaxFile.php'
        },
        'columns': [{
            data: 'product_name'
        }, {
            data: 'product_id'
        }, {
            data: 'link'
        }, {
            data: 'action'
        }, ]
    });

    // Update record
    $('#userTable').on('click', '.updateUser', function() {
        var id = $(this).data('id');

        $('#txt_userid').val(id);

        // AJAX request
        $.ajax({
            url: 'ajaxFile.php',
            type: 'post',
            data: {
                request: 2,
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {

                    $('#name').val(response.data.name);
                    $('#link').val(response.data.link);


                } else {
                    alert("Invalid ID.");
                }
            }
        });

    });


    // Save user 
    $('#btn_save').click(function() {
        var id = $('#txt_userid').val();

        var name = $('#name').val().trim();
        var link = $('#link').val().trim();


        if (name != '' && link != '') {

            // AJAX request
            $.ajax({
                url: 'ajaxFile.php',
                type: 'post',
                data: {
                    request: 3,
                    id: id,
                    name: name,
                    link: link,

                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 1) {
                        // alert(response.message);

                        // Empty the fields
                        $('#name', '#link').val('');
                        $('#txt_userid').val(0);

                        // Reload DataTable
                        userDataTable.ajax.reload();

                        // Close modal
                        $('#updateModal').modal('toggle');
                    } else {
                        alert(response.message);
                    }
                }
            });

        } else {
            alert('Please fill all fields.');
        }
    });
    </script>
    <script>
    document.addEventListener("contextmenu", function(prevent) {
        prevent.preventDefault();
    })
    </script>
</body>

</html>