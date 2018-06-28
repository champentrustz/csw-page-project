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

$date_day = date("Y-m-d");


?>


<div class="table-responsive-lg " style="font-size: 16px">
<table class="table table-lg table-bordered" data-scroll-y="550px" data-scroll-collapse="true"  data-page-length='100' data-provide="datatables" data-paging="false">
    <thead>
      <tr >
        <th  class="text-center" style="font-weight: bold;">ที่</th>

        <th  class="text-center" style="font-weight: bold;">รหัส</th>
        <th  class="text-center" style="font-weight: bold;">รูป</th>
        <th  class="text-center" style="font-weight: bold;">ชื่อ-นามสกุล</th>
        <th  class="text-center" style="font-weight: bold;">ชั้น</th>
        <th  class="text-center" style="font-weight: bold;">สาย</th>
        <th  class="text-center" style="font-weight: bold;">ขาด</th>
          <th  class="text-center" style="font-weight: bold;">หมายเหตุ</th>
        <th  class="text-center"><span class="fa fa-cog"></span></th>

      </tr>
    </thead>
    <tbody>

    <?php
    $sql_time_absent = "SELECT * FROM tb_times WHERE tb_time_date = '".$date_day."' and tb_time_type != 1 and tb_time_type_update != 2 order by tb_time_degree asc, tb_time_stucode asc";
    $result_time_absent = mysqli_query($conn, $sql_time_absent);
    $i = 0;

    $count = mysqli_num_rows($result_time_absent);
    if($count > 0) {
        while ($row_time_absent = mysqli_fetch_assoc($result_time_absent)) {

            $i++;
            $sql_student = "SELECT * FROM tb_students WHERE tb_student_code = '" . $row_time_absent['tb_time_stucode'] . "'";
            $result_student = mysqli_query($conn, $sql_student);
            $row_student = mysqli_fetch_assoc($result_student);
            $sql_room = "SELECT * FROM tb_rooms WHERE tb_room_id = '" . $row_student['tb_student_degree'] . "'";
            $result_room = mysqli_query($conn, $sql_room);
            $row_room = mysqli_fetch_assoc($result_room);

            $absent = 0;
            $late = 0;

            $sql_data_student = "SELECT * FROM tb_times WHERE tb_time_stucode = '" . $row_student['tb_student_code'] . "' and tb_time_semester = '".$semester."' and tb_time_year = '".$year."' and tb_time_type != 1 ";
            $result_data_student = mysqli_query($conn, $sql_data_student);

            while ($row_data_student = mysqli_fetch_assoc($result_data_student)) {
                if($row_data_student['tb_time_type_update'] == 2){
                    $late++;
                }
                else{
                    $absent++;
                }
            }


            ?>

            <tr style="font-size: 16px;" <?php if($i%2 == 1) echo 'class="bg-pale-info "'?> id="row<?php print $i?>">
                <td class="text-center"><?php print $i ?></td>
                <td class="text-center"><?php print $row_student['tb_student_code']?></td>
                <td class="text-center"><img class="zoom" src="../file_student/small/<?php print $row_student['tb_student_code']?>.jpg" style="width:60px;height:78px"></td>
                <td><?php print $row_student['tb_student_name']?> <?php print $row_student['tb_student_sname']?></td>
                <td class="text-center"><?php print $row_room['tb_room_name'] ?></td>
                <td class="text-center"><?php
                    if($late >= 4) {
                        echo '<span class="text-danger">'.$late.'</span>';
                    }
                    else{
                        print $late;
                    }
                ?>
                </td>
                <td class="text-center"><?php
                    if($absent >= 4) {
                        echo '<span class="text-danger">'.$absent.'</span>';
                    }
                    else{
                        print $absent;
                    }
                    ?>

                </td>
                <td><input class="form-control show-font" type="text" id="reason<?php print $i?>" ></td>
                <td><button class="btn btn-warning btn-sm show-font" data-provide="tooltip" title="บันทึก" onclick="changeStatus('<?php print $i?>','<?php print $row_time_absent['tb_time_id']?>')">บันทึก</button></td>


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
    async function changeStatus(number,id) {


         let timeID = id;
         let reason =  $( "#reason"+number ).val();

        fetch('https://www.csw.ac.th/csw_api/check_late.php', {
             method: 'post',
             headers: {
                 Accept: 'application/json',
             },
             body: JSON.stringify({
                 timeID :  timeID,
                 reason :  reason,
             }),
         });

        refreshTabel(number);

     }

    function refreshTabel(number)
    {
        $('#row'+number).remove();
    }

</script>

