<head>
    <meta charset="UTF-8">
</head>
<?php
session_start();
include '../config_db.php';

function display_date($date,$type){//shortthai, longthai, shorteng, longeng
    if($date!='0000-00-00' && $date){
        $arr = explode("-",$date);
        if($arr[2]<10){
            $arr[2] = substr($arr[2],1,1);
        }
        $datevalue = $arr[2]." ".convert_month($arr[1],$type)." ".cut_zero($arr[0]+543);
    }else{
        $datevalue = "";
    }
    return $datevalue;
}

function convert_month($month,$language){
    if($language=='longthai'){
        if($month=='01' || $month=='1'){
            $month = "มกราคม";
        }elseif($month=='02' || $month=='2'){
            $month = "กุมภาพันธ์";
        }elseif($month=='03' || $month=='3'){
            $month = "มีนาคม";
        }elseif($month=='04' || $month=='4'){
            $month = "เมษายน";
        }elseif($month=='05' || $month=='5'){
            $month = "พฤษภาคม";
        }elseif($month=='06' || $month=='6'){
            $month = "มิถุนายน";
        }elseif($month=='07' || $month=='7'){
            $month = "กรกฎาคม";
        }elseif($month=='08' || $month=='8'){
            $month = "สิงหาคม";
        }elseif($month=='09' || $month=='9'){
            $month = "กันยายน";
        }elseif($month=='10'){
            $month = "ตุลาคม";
        }elseif($month=='11'){
            $month = "พฤศจิกายน";
        }elseif($month=='12'){
            $month = "ธันวาคม";
        }
        return $month;
    }elseif($language=='shortthai'){
        if($month=='01' || $month=='1'){
            $month = "ม.ค.";
        }elseif($month=='02' || $month=='2'){
            $month = "ก.พ.";
        }elseif($month=='03' || $month=='3'){
            $month = "มี.ค.";
        }elseif($month=='04' || $month=='4'){
            $month = "เม.ย.";
        }elseif($month=='05' || $month=='5'){
            $month = "พ.ค.";
        }elseif($month=='06' || $month=='6'){
            $month = "มิ.ย.";
        }elseif($month=='07' || $month=='7'){
            $month = "ก.ค.";
        }elseif($month=='08' || $month=='8'){
            $month = "ส.ค.";
        }elseif($month=='09' || $month=='9'){
            $month = "ก.ย.";
        }elseif($month=='10'){
            $month = "ต.ค.";
        }elseif($month=='11'){
            $month = "พ.ย.";
        }elseif($month=='12'){
            $month = "ธ.ค.";
        }
        return $month;
    }elseif($language=='shorteng'){
        if($month=='01' || $month=='1'){
            $month = "Jan";
        }elseif($month=='02' || $month=='2'){
            $month = "Feb";
        }elseif($month=='03' || $month=='3'){
            $month = "Mar";
        }elseif($month=='04' || $month=='4'){
            $month = "Apr";
        }elseif($month=='05' || $month=='5'){
            $month = "May";
        }elseif($month=='06' || $month=='6'){
            $month = "Jun";
        }elseif($month=='07' || $month=='7'){
            $month = "Jul";
        }elseif($month=='08' || $month=='8'){
            $month = "Aug";
        }elseif($month=='09' || $month=='9'){
            $month = "Sep";
        }elseif($month=='10'){
            $month = "Oct";
        }elseif($month=='11'){
            $month = "Nov";
        }elseif($month=='12'){
            $month = "Dec";
        }
        return $month;
    }elseif($language=='longeng'){
        if($month=='01'  || $month=='1'){
            $month = "January";
        }elseif($month=='02' || $month=='2'){
            $month = "February";
        }elseif($month=='03' || $month=='3'){
            $month = "March";
        }elseif($month=='04' || $month=='4'){
            $month = "April";
        }elseif($month=='05' || $month=='5'){
            $month = "May";
        }elseif($month=='06' || $month=='6'){
            $month = "June";
        }elseif($month=='07' || $month=='7'){
            $month = "July";
        }elseif($month=='08' || $month=='8'){
            $month = "August";
        }elseif($month=='09' || $month=='9'){
            $month = "September";
        }elseif($month=='10'){
            $month = "October";
        }elseif($month=='11'){
            $month = "November";
        }elseif($month=='12'){
            $month = "December";
        }
        return $month;
    }
}

function cut_zero($val){
    $cut = substr($val,0,1);
    if($cut=='0'){
        $val = substr($val,1,1);
    }
    return $val;
}


$month = date('n');
$year = date('Y');
if($month>='5'  && $month <='10'){
    $semester =1;

}else{
    $semester =2;
    if($month >= 1 && $month <5){
        $year = $year-1;
    }
}

$username="0618481177";
$password="chamnan";
$secret="sf4356kh";
$sender="CSW_School";

$adminID = $_SESSION['admin_id'];
$studentCode= $_REQUEST['studentCode'];
$ruleID = $_REQUEST['ruletype'];
$score = $_REQUEST['score'];
$deduction_late = $_REQUEST['deduction_late'];
$place = $_REQUEST['place'];
$dateFull = $_REQUEST['date'];

if($place == '' || $place == null || $place == 'undefined'){
    $place = '';
}

$dateFormat = substr($dateFull,0,2);
$monthFormat = substr($dateFull,3,2);
$yearFormat = (int)substr($dateFull,6,4) - 543;

$dateFull = $yearFormat.'-'.$monthFormat.'-'.$dateFormat;

$sql_student = "SELECT * FROM tb_students WHERE tb_student_code = '".$studentCode."'";
$result_student = mysqli_query($conn, $sql_student);
$row_student = mysqli_fetch_assoc($result_student);

$sql_ruletype = "SELECT * FROM tb_ruletypes WHERE tb_ruletype_id = '".$ruleID."'";
$result_ruletype = mysqli_query($conn, $sql_ruletype);
$row_ruletype = mysqli_fetch_assoc($result_ruletype);


$sql_rule = "INSERT INTO tb_rules (tb_student_code, tb_ruletype_id, tb_rule_score, tb_rule_area, tb_rule_semester, tb_rule_year, tb_rule_date, tb_rule_status, tb_admin_id)
VALUES ('".$studentCode."', '".$ruleID."', '".$score."', '".$place."', '".$semester."', '".$year."', '".$dateFull."', '1', '".$adminID."');";
$result = mysqli_query($conn, $sql_rule);

$dest= $row_student['tb_student_phone'];

$msg = urlencode(iconv("UTF-8","windows-874",$row_student['tb_student_name']." ".$row_student['tb_student_sname']." ".$row_ruletype['tb_ruletype_name']." วันที่ ".display_date($dateFull,'shortthai')." ถูกตัด ".$score." คะแนน"));

$POSTVARS="username=$username&password=$password&secret=$secret&sender=$sender&dest=$dest&msg=$msg";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://www.thaiwebsms.com/vip/api_cckz.php');
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $POSTVARS);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec ($curl);
curl_close ($curl);

if($deduction_late == 'true'){
    print "<script>
        alert('ตัดคะแนนความประพฤติสำเร็จ !');
            window.location.href = 'late-report';
     
    </script>";
}
else{
    print "<script>
        alert('ตัดคะแนนความประพฤติสำเร็จ !');
            window.location.href = 'deduction-score';
     
    </script>";

}

