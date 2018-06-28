<head>
    <meta charset="UTF-8">
</head>
<?php
session_start();
include '../config_db.php';

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$sql_login = "SELECT * FROM tb_admin WHERE tb_admin_loginname = '".$username."' and tb_admin_loginpass = '".$password."' and tb_admin_status = 1 and tb_admin_type = 99";
$result = mysqli_query($conn, $sql_login);
$count = mysqli_num_rows($result);
if($count > 0){

    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['admin_id'] = $row['tb_admin_id'];
        $_SESSION['admin_name'] = $row['tb_admin_name'];
        $_SESSION['admin_surname'] = $row['tb_admin_surname'];
    }
    ?>
    <script language="javascript">window.location.href = 'main';</script>
    <?php

}
else{
    ?>
    <script>
        alert('ผิดพลาด! กรุณาตรวจสอบชื่อผู้ใช้งานหรือรหัสผ่าน');
        window.location.href = 'login';
    </script>

<?php
}


?>

