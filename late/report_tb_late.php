<?php
session_start();
include '../config_db.php';

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



$date_day = $_SESSION['date_day'];



function ThDate($dateSearch)
{

    $year = (int)substr($dateSearch,0,4) + 543;
    $month = substr($dateSearch,6,2);
    $date = substr($dateSearch,8,2);


    switch ($month){
        case 1:
            $month = 'มกราคม';
            break;
        case 2:
            $month = 'กุมภาพันธ์';
            break;
        case 3:
            $month = 'มีนาคม';
            break;
        case 4:
            $month = 'เมษายน';
            break;
        case 5:
            $month = 'พฤษภาคม';
            break;
        case 6:
            $month = 'มิถุนายน';
            break;
        case 7:
            $month = 'กรกฎาคม';
            break;
        case 8:
            $month = 'สิงหาคม';
            break;
        case 9:
            $month = 'กันยายน';
            break;
        case 10:
            $month = 'ตุลาคม';
            break;
        case 11:
            $month = 'พฤศจิกายน';
            break;
        case 12:
            $month = 'ธันวาคม';
            break;
    }



    return "
        วันที่ $date  
		เดือน $month 
		พ.ศ. $year";
}

?>




<div class="table-responsive-lg" data-page-length="25" style="font-size: 16px">

<table class="table table-lg table-hover table-bordered" data-page-length='100' data-provide="datatables">
    <thead>
      <tr>
        <th  class="text-center" style="font-weight: bold;">ที่</th>

        <th  class="text-center" style="font-weight: bold;">รหัส</th>
        <th  class="text-center " style="font-weight: bold;">รูป</th>
        <th  class="text-center " style="font-weight: bold;">ชื่อ-นามสกุล</th>
        <th  class="text-center " style="font-weight: bold;">ชั้น</th>
        <th  class="text-center " style="font-weight: bold;">หมายเหตุ</th>
        <th  class="text-center " style="font-weight: bold;">เวลา</th>
        <th  class="text-center "><span class="icon fa fa-cog"></span></th>

      </tr>
    </thead>
    <tbody>

    <?php
    $sql_time_late = "SELECT * FROM tb_times WHERE tb_time_date = '".$date_day."' and tb_time_type_update = 2 order by tb_time_degree asc, tb_time_stucode asc";
    $result_time_late = mysqli_query($conn, $sql_time_late);
    $i = 0;

    $count = mysqli_num_rows($result_time_late);
    if($count > 0) {
        while ($row_time_late = mysqli_fetch_assoc($result_time_late)) {

            $i++;
            $sql_student = "SELECT * FROM tb_students WHERE tb_student_code = '" . $row_time_late['tb_time_stucode'] . "'";
            $result_student = mysqli_query($conn, $sql_student);
            $row_student = mysqli_fetch_assoc($result_student);
            $sql_room = "SELECT * FROM tb_rooms WHERE tb_room_id = '" . $row_student['tb_student_degree'] . "'";
            $result_room = mysqli_query($conn, $sql_room);
            $row_room = mysqli_fetch_assoc($result_room);

          

            ?>
            <tr style="font-size: 16px"  <?php if($i%2 == 1) echo 'class="bg-pale-info"'?>>
                <td class="text-center"><?php print $i ?></td>
                <td class="text-center"><?php print $row_student['tb_student_code']?></td>
                <td class="text-center"><img class="zoom" src="../file_student/small/<?php print $row_student['tb_student_code']?>.jpg" style="width:60px;height:78px"></td>
                <td><?php print $row_student['tb_student_name']?> <?php print $row_student['tb_student_sname']?></td>
                <td class="text-center"><?php print $row_room['tb_room_name']?></td>
                <td class="text-center"><?php
                    if($row_time_late['tb_time_reason'] == ''){
                    echo '-';
                    }
                    else{
                        print $row_time_late['tb_time_reason'];
                    }?></td>
                <td class="text-center"><?php print substr($row_time_late['tb_time_time'],0,5)?></td>
                <td class="text-center"><button class="btn btn-danger btn-sm show-font" data-provide="tooltip" title="ลบ" onclick="deleteLate('<?php print $row_time_late['tb_time_id']?>')">ลบ</button></td>

            </tr>
            <?php
        }
    }

    ?>


    </tbody>

</table>
</div>
<br/>
<script>
    async function deleteLate(id) {


        let timeID = id;


        const resp = await fetch('https://www.csw.ac.th/csw_api/delete_late.php', {
            method: 'post',
            headers: {
                Accept: 'application/json',
            },
            body: JSON.stringify({
                time_id :  timeID,
            }),
        });

        refreshTabel(resp);

    }


    function refreshTabel(resp)
    {
        $('#button-late').trigger('click');
    }

</script>


