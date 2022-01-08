<?php
// header("Content-type: image/png");
// include_once('./phpqrcode/qrlib.php');

// $path = 'QR_Codes/';
// $file = $path . uniqid() . ".png";
// $text = "Something";
// QRcode::png("something to incode", $file, QR_ECLEVEL_L, 10, 3);
// echo "<img src='" . $file . "'>";

include('./class/database.php');
include_once('./phpqrcode/qrlib.php');
class profile extends database
{
    protected $link;


    public function insertQR()
    {
        $email = addslashes(trim($_POST['email']));
        $id_number = addslashes(trim($_POST['id_number']));
        $link = addslashes(trim($_POST['link']));


        $image = $id_number . ".png";

        $sqlFind = "SELECT * from qr_tbl where product_id = '$id_number' ";
        $resFind = mysqli_query($this->link, $sqlFind);
        if (mysqli_num_rows($resFind) > 0) {
            return 'ID Number is already used';
        } else {
            $sql = "INSERT INTO `qr_tbl` (`qr_id`, `product_id`, `qr_image`, `link`, `user_email`, `qr_created_at`) VALUES (NULL, '$id_number', '$image', '$link', '$email', CURRENT_TIMESTAMP)";

            $res = mysqli_query($this->link, $sql);
            if ($res) {
                $path = 'QR_Codes/';
                $file = $path . $id_number . ".png";
                $rawFile = $id_number . ".png";
                $text = 'https://codekey-centrale.fr/product_qr/user-link.php?id=' . $id_number;
                QRcode::png($text, $file, QR_ECLEVEL_L, 10, 3);

                return "<div class='text-center'><img class='w-75' src='" . $file . "'><br><a href='QR_Codes/" . $rawFile . "' download class='btn btn-success'>Download</a></div>";
            } else {
                return false;
            }
        }
    }
}
$obj = new profile;
$objInsertInfo = $obj->insertQR();

echo $objInsertInfo;