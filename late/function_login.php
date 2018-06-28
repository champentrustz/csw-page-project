<head>
    <meta charset="UTF-8">
</head>
<?php
session_start();
include '../config_db.php';

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$sql_login = "SELECT * FROM tb_teachers WHERE tb_teacher_number = '".$username."' and tb_teacher_password = '".$password."' and tb_teacher_status = 1";
$result = mysqli_query($conn, $sql_login);
$count = mysqli_num_rows($result);
if($count > 0){

    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['teacher_name'] = $row['tb_teacher_name'];
        $_SESSION['teacher_number'] = $row['tb_teacher_number'];
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

