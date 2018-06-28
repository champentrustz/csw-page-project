<?php

include '../config_db.php';

$date_day = date("Y-m-d");
$date_time = date('H:i:s');

$username="0618481177";
$password="chamnan";
$secret="sf4356kh";
$sender="CSW_School";

$content = file_get_contents("https://www.csw.ac.th/csw_api/get_sms_late_data.php");

$jsonArrays = json_decode($content,true);

foreach ($jsonArrays as $data){

    
           if($data['deduction_score'] == false){
               $msg = urlencode(iconv("UTF-8","windows-874",$data['student_name'].' วันนี้มาสาย ('.$data['num_late'].') '.$data['time'].' / ร.ร.ชำนาญฯ 0618481177'));
               $dest= $data['telephone'];
               $POSTVARS="username=$username&password=$password&secret=$secret&sender=$sender&dest=$dest&msg=$msg";

               $curl = curl_init();
               curl_setopt($curl, CURLOPT_URL, 'http://www.thaiwebsms.com/vip/api_cckz.php');
               curl_setopt($curl, CURLOPT_POST, true);
               curl_setopt($curl, CURLOPT_POSTFIELDS, $POSTVARS);
               curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
               $result = curl_exec ($curl);
               curl_close ($curl);
           }




}

$sql_sms = "INSERT INTO tb_sms_late (date, time)VALUES ('".$date_day."', '".$date_time."');";
$result = mysqli_query($conn, $sql_sms);


print "
	<script language='javascript'>
		window.location.href='sms-late';
	</script>
	";