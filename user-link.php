<?php
session_start();

include('class/database.php');
class profile extends database
{
    protected $link;

    public function showLink()
    {
        $id = $_GET['id'];
        $sql = "SELECT * from qr_tbl where product_id = '$id'";
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
$objInsertInfo = $obj->showLink();
$row = mysqli_fetch_assoc($objInsertInfo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


</head>

<body>

    <script>
    window.location.href = '<?php echo $row['link']; ?>';
    </script>
</body>

</html>