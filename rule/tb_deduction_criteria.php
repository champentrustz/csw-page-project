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

function display_timetype($status){
    if($status=='1'){
        $show_status = "<span class='glyphicon glyphicon-ok text-success'></span>";
    }elseif($status=='2'){
        $show_status = "สาย";
    }elseif($status=='3'){
        $show_status = "ลา";
    }elseif($status=='4'){
        $show_status = "ลาป่วย";
    }elseif($status=='5'){
        $show_status = "ขาดเรียน";
    }elseif($status=='6'){
        $show_status = "ลากิจ";
    }elseif($status=='7'){
        $show_status = "กิจกรรม";
    }
    return $show_status;
}

?>

<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>

<br/>
<div class="table-responsive-lg" style="font-size: 16px">
    <table class="table table-xl table-hover table-bordered fixed" data-page-length='100' data-provide="datatables"  >
        <thead>
        <tr>
            <th  class="text-center" style="font-weight: bold;">ที่</th>
            <th  class="text-center" style="font-weight: bold;">เกณฑ์</th>
            <th  class="text-center " style="font-weight: bold;">คะแนน</th>
            <th  class="text-center"><span class="fa fa-cog"></span></th>
            <th  class="text-center"><span class="fa fa-cog"></span></th>

        </tr>
        </thead>
        <tbody>

        <?php
        $sql_rule_type = "SELECT * FROM tb_ruletypes WHERE tb_ruletype_status = 1 ORDER BY tb_ruletype_score asc, tb_ruletype_id asc";
        $result_rule_type = mysqli_query($conn, $sql_rule_type);
        $i = 0;

        $count = mysqli_num_rows($result_rule_type);
        if($count > 0) {
            while ($row_rule_type = mysqli_fetch_assoc($result_rule_type)) {
                $i++;


                ?>
                <tr style="font-size: 16px">
                    <td class="text-center"><?php print $i?></td>
                    <td width="65%"><?php print $row_rule_type['tb_ruletype_name']?></td>
                    <td class="text-center"><?php print $row_rule_type['tb_ruletype_score']?> คะแนน</td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm show-font" data-toggle="modal" data-target="#modal-edit-<?php print $i?>">แก้ไข</button>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm show-font" data-provide="tooltip" title="แก้ไข" type="submit">ลบ</button>
                    </td>

                </tr>
                <div class="modal fade" id="modal-edit-<?php print $i?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title show-font" id="myModalLabel">แก้ไขเกณฑ์การตัดคะแนนความประพฤติ</h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body ">


                                <form class="form-type-material">

                                    <div class="form-group">
                                        <label for="rule-name" style="font-size: 14px" class="text-info">เกณฑ์</label>
                                        <input type="text" class="form-control show-font" value="<?php print $row_rule_type['tb_ruletype_name']?>" id="rule-name">
                                    </div>

                                    <div class="form-group">
                                        <label for="rule-score" style="font-size: 14px" class="text-info">คะแนน</label>
                                        <input type="number" class="form-control col-md-2 show-font" value="<?php print $row_rule_type['tb_ruletype_score']?>" id="rule-score">
                                    </div>


                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-bold btn-pure btn-secondary show-font" data-dismiss="modal" style="font-size: 16px">ปิด</button>
                                <button type="button" class="btn btn-bold btn-pure btn-primary show-font" style="font-size: 16px">แก้ไข</button>
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


