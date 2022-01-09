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

        $six_digit_random_number = random_int(100000, 999999);

        $image = $id_number . ".png";

        $sqlFind = "SELECT * from qr_tbl where product_id = '$id_number' ";
        $resFind = mysqli_query($this->link, $sqlFind);
        if (mysqli_num_rows($resFind) > 0) {
            return '<div class="alert alert-danger alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>ID Number already used!</strong>
          </div>';
        } else {
            $sql = "INSERT INTO `qr_tbl` (`qr_id`, `product_id`, `qr_image`, `link`, `user_email`, `qr_created_at`,`product_name`,`user_confirm`,`security`) VALUES (NULL, '$id_number', '$image', '$link', '$email', CURRENT_TIMESTAMP,'',0,'$six_digit_random_number')";

            $res = mysqli_query($this->link, $sql);
            if ($res) {
                $path = 'QR_Codes/';
                $file = $path . $id_number . ".png";
                $rawFile = $id_number . ".png";
                $text = 'https://encryptclothing.co.uk/user-link.php?id=' . $id_number;
                QRcode::png($text, $file, QR_ECLEVEL_L, 10, 3);

                $subject = "New Item";
                $message = 'Add this item to your <b>Register New Item</b> menu. <br> ';
                $message .= 'Your Security Code is: ';
                $message .= "<b>$six_digit_random_number</b><br>";
                $message .= "This is one time code. After adding new item it will change.<br>";
                $message .= "Product ID Number: ";
                $message .= "<b>$id_number</b><br>";
                $message .= "Download your QR Code: <br><br>";
                $message .= '<a download style="padding:10px 60px;background-color: #F3CC3C;color:#000;font-weight:600;text-decoration:none" href="https://encryptclothing.co.uk/QR_Codes/' . $rawFile . '">Download</a>';
                $headers = "From: info@joinautonomy.eu \r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type: text/html;charset=UTF-8" . "\r\n";

                if (mail($email, $subject, $message, $headers)) {
                    return "<div class='text-center'><img class='w-75' src='QR_Codes/" . $rawFile . "'><br><a href='QR_Codes/" . $rawFile . "' download class='btn btn-success'>Download</a></div>";
                }
            } else {
                return false;
            }
        }
    }
}
$obj = new profile;
$objInsertInfo = $obj->insertQR();

echo $objInsertInfo;