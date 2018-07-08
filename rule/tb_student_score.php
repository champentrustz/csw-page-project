<?php
session_start();
include '../config_db.php';

function convertDateThai($data){
    $year = substr($data,0,4);
    $month = substr($data,5,2);
    $date = substr($data,8,2);
    $year = (int)$year + 543;
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


    return $date.' '.$month.' '.$year;

}

$semester = $_SESSION['semester'];
$year = $_SESSION['year'];

$date_day = date("Y-m-d");


?>



<br/>
<div class="table-responsive-lg" style="font-size: 16px">
    <table class="table table-lg table-hover table-bordered" data-page-length='100' data-provide="datatables">
        <thead>
        <tr>
            <th  class="text-center" style="font-weight: bold;">ที่</th>

            <th  class="text-center" style="font-weight: bold;">รหัส</th>
            <th  class="text-center " style="font-weight: bold;">รูป</th>
            <th  class="text-center " style="font-weight: bold;">ชื่อ-นามสกุล</th>
            <th  class="text-center " style="font-weight: bold;">ชั้น</th>
            <th  class="text-center" style="font-weight: bold;">คะแนนที่เหลือ</th>
            <th  class="text-center "><span class="icon fa fa-cog"></span></th>
            <th  class="text-center "><span class="icon fa fa-cog"></span></th>

        </tr>
        </thead>
        <tbody>

        <?php
        $sql_rule = "SELECT DISTINCT tb_student_code FROM tb_rules WHERE tb_rule_semester = '".$semester."' and tb_rule_year = '".$year."' and tb_rule_status = 1";
        $result_rule = mysqli_query($conn, $sql_rule);
        $i = 0;

        $count = mysqli_num_rows($result_rule);
        if($count > 0) {
            while ($row_rule = mysqli_fetch_assoc($result_rule)) {

                $i++;
                $sql_student = "SELECT * FROM tb_students WHERE tb_student_code = '" . $row_rule['tb_student_code'] . "'";
                $result_student = mysqli_query($conn, $sql_student);
                $row_student = mysqli_fetch_assoc($result_student);
                $sql_room = "SELECT * FROM tb_rooms WHERE tb_room_id = '" . $row_student['tb_student_degree'] . "'";
                $result_room = mysqli_query($conn, $sql_room);
                $row_room = mysqli_fetch_assoc($result_room);
                $sql_rule_again = "SELECT * FROM tb_rules WHERE tb_student_code = '".$row_rule['tb_student_code']."' and tb_rule_semester = '".$semester."' and tb_rule_year = '".$year."' and tb_rule_status = 1";
                $result_rule_again = mysqli_query($conn, $sql_rule_again);
                $sum_score = 0;
                while($row_rule_again = mysqli_fetch_assoc($result_rule_again)){
                    $sum_score += $row_rule_again['tb_rule_score'];
                }

                $sql_add_score_rule = "SELECT * FROM tb_add_rule_score WHERE student_code = '".$row_rule['tb_student_code']."' and semester = '".$semester."' and year = '".$year."' and status = 1";
                $result_add_score_rule = mysqli_query($conn, $sql_add_score_rule);
                $sum_add_score = 0;
                while($row_add_score_rule = mysqli_fetch_assoc($result_add_score_rule)){
                    $sum_add_score += $row_add_score_rule['score'];
                }

                $real_score = (100 - $sum_score) + $sum_add_score;

                ?>
                <tr style="font-size: 16px">

                    <td class="text-center"><?php print $i ?></td>
                    <td class="text-center"><?php print $row_student['tb_student_code']?></td>
                    <td class="text-center"><img class="zoom" src="../file_student/small/<?php print $row_student['tb_student_code']?>.jpg" style="width:60px;height:78px"></td>
                    <td width="20%"><?php print $row_student['tb_student_name']?> <?php print $row_student['tb_student_sname']?></td>
                    <td class="text-center"><?php print $row_room['tb_room_name'] ?></td>
                    <td class="text-center"><?php print $real_score?></td>

                    <td class="text-center">
                        <form method="post" action="view-detail">
                            <input type="hidden" value="<?php print $row_student['tb_student_code']?>" name="studentCode">
                            <input type="hidden" value="<?php print $semester?>" name="semester">
                            <input type="hidden" value="<?php print $year?>" name="year">
                        <button class="btn btn-info btn-sm show-font" data-provide="tooltip" title="รายละเอียด" type="submit">รายละเอียด</button>
                        </form>
                    </td>

                    <td class="text-center">
                        <button class="btn btn-success btn-sm show-font" data-toggle="modal" data-target="#modal-add-score<?php print $i?>">เพิ่มคะแนน</button>
                    </td>

                </tr>

                <div class="modal fade" id="modal-add-score<?php print $i?>" tabindex="-1">

                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title show-font" id="myModalLabel">เพิ่มคะแนนความประพฤติ</h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body bg-secondary">
                                <div class="card ">
                                    <h4 class="card-title show-font"><span class="icon ti-user"></span> ข้อมูลนักเรียน</h4>
                                    <div class="card-body">

                                        <div class="sidebar-profile" id="profile">
                                            <img class="avatar " src="../file_student/small/<?php print $row_student['tb_student_code']?>.jpg" >

                                            <div class="profile-info">


                                                        <h6 class="show-font text-default">ชื่อ : <?php print $row_student['tb_student_name']?> <?php print $row_student['tb_student_sname']?></h6>



                                                        <h6 class="show-font text-default">รหัสนักเรียน : <?php print $row_student['tb_student_code']?></h6>



                                                        <h6 class="show-font text-default">ชั้น : <?php print $row_room['tb_room_name']?></h6>



                                                        <h6 class="show-font text-default">เบอร์ผู้ปกครอง : <?php print $row_student['tb_student_phone']?></h6>



                                            </div>
                                        </div>

                                    </div>


                                </div>

                                <div class="card ">
                                    <h4 class="card-title show-font"><span class="icon ti-star"></span> เพิ่มคะแนนความประพฤติ</h4>
                                    <div class="card-body">


                                                    <h6 class="show-font text-default" style="margin-top: 10px">พฤติกรรม</h6>



                                                    <select name="ruletype" class="form-control show-font" style="font-size:17px;" id="rule" required>
                                                        <option value="" class="show-font">เลือกพฤติกรรม</option>
                                                        <?php
                                                        $sql_rule_type = "SELECT * FROM tb_ruletypes WHERE tb_ruletype_status = 1 and tb_ruletype_type = 'INCREASE' order by  tb_ruletype_score asc,tb_ruletype_id asc";
                                                        $result_rule_type = mysqli_query($conn, $sql_rule_type);

                                                        while ($row_ruletype = mysqli_fetch_assoc($result_rule_type)) {
                                                            ?>
                                                            <option class="show-font" value="<?php echo $row_ruletype['tb_ruletype_id'];?>"><?php echo $row_ruletype['tb_ruletype_name'];?> (<? print $row_ruletype['tb_ruletype_score']?> คะแนน)</option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>

                                                    <div id="check-ruletype">

                                                    </div>



                                                    <h6 class="show-font text-default" style="margin-top: 10px">คะแนนที่ตัด</h6>

                                                    <input class="form-control" type="number" min="0" id="score" name="score" required>

                                                    <div id="check-score">

                                                    </div>


                                                    <input class="form-control" type="hidden" name="studentCode" required value="<?php print $row_student['tb_student_code']?>">



                                                    <h6 class="show-font text-default" style="margin-top: 10px">สถานที่</h6>

                                                    <input class="form-control show-font" type="text" name="place" id="place">



                                                    <h6 class="show-font text-default" style="margin-top: 10px">ภาคเรียน</h6>

                                                    <input class="form-control" type="text" name="semester" value="<?php print $semester?>-<?php print $year+543?>" required readonly>




                                                    <h6 class="show-font text-default" style="margin-top: 10px">วันที่</h6>

                                                    <input class="form-control" type="text" name="date" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?php print $date_day?>" id="date" required>





                                    </div>




                                </div>




                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success show-font" style="font-size: 16px" onclick="addRuleScore('<?php print $i?>','<?php print $row_student['tb_student_code']?>')">บันทึก</button>
                                <button type="button" class="btn btn-danger show-font" style="font-size: 16px" data-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>

                </div>
                <?php
            }
        }

        ?>


        </tbody>

    </table>
</div>
<br/>

<script>
    async function addRuleScore(i,student_code) {



        let admin_id =  '<?php print $_SESSION['admin_id']?>'
        let ruletype =  $( "#rule" ).val();
        let score =  $( "#score" ).val();
        let place =  $( "#place" ).val();
        let date =  $( "#date" ).val();
        let id = i;


        if(score != '' && ruletype != '' ) {

            const resp = await fetch('https://www.csw.ac.th/csw_api/add_rule_score.php', {
                method: 'post',
                headers: {
                    Accept: 'application/json',
                },
                body: JSON.stringify({
                    admin_id: admin_id,
                    studentCode: student_code,
                    ruletype: ruletype,
                    score: score,
                    place: place,
                    date: date,
                }),
            });

            $('.modal-backdrop').remove();
            window.location.reload();


        }
        else if(score == '' && ruletype != '' ) {

            $( "#check-score" ).html('<label class="text-danger">โปรกรอกคะแนน</label>');
            $( "#check-ruletype" ).html('');

        }

        else if(score != '' && ruletype == '' ) {

            $( "#check-ruletype" ).html('<label class="text-danger">โปรดเลือกเกณฑ์</label>');
            $( "#check-score" ).html('');

        }
        else{
            $( "#check-ruletype" ).html('<label class="text-danger">โปรดเลือกเกณฑ์</label>');
            $( "#check-score" ).html('<label class="text-danger">โปรกรอกคะแนน</label>');
        }



    }


</script>

<script>
    async function changeStatus(number,id) {

        console.log('click');

        let timeID = id;
        let reason =  $( "#reason"+number ).val();

        const resp = await fetch('https://www.csw.ac.th/csw_api/check_late.php', {
            method: 'post',
            headers: {
                Accept: 'application/json',
            },
            body: JSON.stringify({
                timeID :  timeID,
                reason :  reason,
            }),
        });

        refreshTabel(resp);

    }



    function refreshTabel(resp)
    {
        $('#button-late').trigger('click');
    }

</script>

