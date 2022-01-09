<?php
session_start();
include 'config.php';

$request = 1;
if (isset($_POST['request'])) {
    $request = $_POST['request'];
}

// DataTable data
if ($request == 1) {
    ## Read value
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = ' qr_created_at'; // Column name
    $columnSortOrder = ' DESC'; // asc or desc

    $searchValue = mysqli_escape_string($con, $_POST['search']['value']); // Search value

    ## Search 
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " and (link like '%" . $searchValue . "%' or 
            product_id like'%" . $searchValue . "%' )  ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($con, "select count(*) as allcount from qr_tbl");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($con, "select count(*) as allcount from qr_tbl WHERE 1" . $searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from qr_tbl WHERE 1" . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
    $arr = array();
    $i = 0;
    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button
        $updateButton = "<a download href='QR_Codes/" . $row['qr_image'] . "' class='btn btn-sm btn-block btn-info'>Download</a>";

        $img = "<img src='QR_Codes/" . $row['qr_image'] . "' alt=''>";




        $action = $updateButton;

        $data[] = array(
            "product_id" => $row['product_id'],
            "qr_image" => $img,
            "link" => $row['link'],
            "action" => $action
        );
    }

    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
    exit;
}

// Fetch user details
if ($request == 2) {
    $id = 0;

    if (isset($_POST['id'])) {
        $id = mysqli_escape_string($con, $_POST['id']);
    }

    $record = mysqli_query($con, "SELECT * FROM qr_tbl WHERE qr_id=" . $id);

    $response = array();

    if (mysqli_num_rows($record) > 0) {
        $row = mysqli_fetch_assoc($record);
        $response = array(
            "name" => $row['product_name'],
            "link" => $row['link'],

        );

        echo json_encode(array("status" => 1, "data" => $response));
        exit;
    } else {
        echo json_encode(array("status" => 0));
        exit;
    }
}

// Update user
if ($request == 3) {
    $id = 0;

    if (isset($_POST['id'])) {
        $id = mysqli_escape_string($con, $_POST['id']);
    }

    // Check id
    $record = mysqli_query($con, "SELECT qr_id FROM qr_tbl WHERE qr_id=" . $id);
    if (mysqli_num_rows($record) > 0) {

        $name = mysqli_escape_string($con, trim($_POST['name']));



        $link = mysqli_escape_string($con, trim($_POST['link']));


        if ($name != '' && $link != '') {

            mysqli_query($con, "UPDATE qr_tbl SET product_name='" . $name . "',link='" . $link . "' WHERE qr_id=" . $id);

            echo json_encode(array("status" => 1, "message" => "Record updated."));
            exit;
        } else {
            echo json_encode(array("status" => 0, "message" => "Please fill all fields."));
            exit;
        }
    } else {
        echo json_encode(array("status" => 0, "message" => "Invalid ID."));
        exit;
    }
}

// Delete User