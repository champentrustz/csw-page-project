
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");

$date_day_show = date("d/m/Y");




$adminID = $_SESSION['admin_id'];
if($adminID == null || $adminID == ''){
    ?>
    <script>window.location.href='login';</script>
    <?php
}
function ThDate()
{
//วันภาษาไทย
    $ThDay = array ( "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์" );
//เดือนภาษาไทย
    $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );

//กำหนดคุณสมบัติ
    $week = date( "w" ); // ค่าวันในสัปดาห์ (0-6)
    $months = date( "m" )-1; // ค่าเดือน (1-12)
    $day = date( "d" ); // ค่าวันที่(1-31)
    $years = date( "Y" )+543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.

    return "วัน$ThDay[$week] 
		ที่ $day  
		เดือน $ThMonth[$months] 
		พ.ศ. $years";
}

$date_day = $_REQUEST['date_search'];


if($date_day == null || $date_day == ''){
    $date_day = date("Y-m-d");
}

$_SESSION['date_day'] = $date_day;

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>C.S.W. Online Behavior</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <link href="../css/core.min.css" rel="stylesheet">
    <link href="../css/app.min.css" rel="stylesheet">
    <link href="../css/style.min.css" rel="stylesheet">


    <!-- Favicons -->
</head>


<style>

    @import url('https://fonts.googleapis.com/css?family=Athiti');
    *{
        font-family: 'Athiti', sans-serif;
    }
    .show-font{
        font-family: 'Athiti', sans-serif;
    }

    .zoom {
        -webkit-transition: all 0.35s ease-in-out;
        -moz-transition: all 0.35s ease-in-out;
        transition: all 0.35s ease-in-out;
        cursor: -webkit-zoom-in;
        cursor: -moz-zoom-in;
        cursor: zoom-in;
    }

    .zoom:hover,
    .zoom:active,
    .zoom:focus {
        -ms-transform: scale(2.5);
        -moz-transform: scale(2.5);
        -webkit-transform: scale(2.5);
        -o-transform: scale(2.5);
        transform: scale(2.5);
        position:relative;
        z-index:100;
    }

</style>

<body>



<!-- Preloader -->
<div class="preloader">
    <div class="spinner-dots">
        <span class="dot1"></span>
        <span class="dot2"></span>
        <span class="dot3"></span>
    </div>
</div>




<?php include "side-bar.php";?>


<!-- Main container -->
<main class="main-container">

    <div class="card text-center">
        <div class="col-md-12">
            <h2 class="header-title">
                <p></p>
                <span class="text-info">รายงานนักเรียนที่มาโรงเรียนสาย</span>
                <p></p>
                <!--                <small class="show-font">โรงเรียนชำนาญสามัคคีวิทยา</small>-->
            </h2 class="header-title ">
        </div>

    </div>
    

    <div class="container">


                <div class="card">
                    <div class="card-body">



                        <div class="form-inline">

                            <div class="form-group">

                                <div class="input-group">
                                    <input type="text" class="form-control" style="" data-provide="datepicker" data-position="bottom" data-date-format="dd/mm/yyyy" value="<?php print $date_day_show?>" id="date-search">
                                    <span class="input-group-addon">
                                         <i class="fa fa-calendar"></i>
                                     </span>



                                </div>



                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" onclick="dateSearch()"><span class="show-font">ค้นหา</span></button>
                            </div>
                        </div>


                        <br/>

                        <button class="btn btn-primary" data-provide="loader" data-url="tb_late.php" data-target="#loader-target" style="display: none"  id="button-late">Button</button>
                        <div id="loader-target">



                        </div>

                    </div>
                </div>
    </div>





</main>
<!-- END Main container -->





<!-- Scripts -->
<script src="../js/core.min.js"></script>
<script src="../js/app.min.js"></script>
<script src="../js/script.min.js"></script>


<script>
    var dateSearch = $( "#date-search" ).val();
    var date = dateSearch.substring(0,2 );
    var month = dateSearch.substring(3,5);
    var year = parseInt( dateSearch.substring(6,10));

    var dateFormat = year+'-'+month+'-'+date
    $.post( "./late-report", {"date_search": dateFormat})

</script>



<script>


    $('#date-search').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
</script>

<script>
    async function dateSearch() {


        var dateSearch = $( "#date-search" ).val();

        var date = dateSearch.substring(0,2 );
        var month = dateSearch.substring(3,5);
        var year = parseInt( dateSearch.substring(6,10));

        var dateFormat = year+'-'+month+'-'+date

        $.post( "./late-report", {"date_search": dateFormat})


        refreshTabel();

    }

    function refreshTabel()
    {
        $('#button-late').click();
    }
</script>

<script>

    var click = 0;
    var toggle = 0;

    setTimeout(function(){  $('#button-late').trigger('click'); }, 200);

    $( "#toggle-fold" ).click(function() {
        click ++;
        if(click %2 == 0){
            $('#profile').show();
        }
        else{

            $( document ).on( "mousemove", function( event ) {
                if(click %2 == 0){
                    event.stopPropagation();
                }
                else{
                    if(event.pageX <= 80 && event.pageY >= 0){
                        $('#profile').show('slow');

                    }
                    if(event.pageX >= 260 && event.pageY >= 0){
                        $('#profile').hide('slow');

                    }
                }

            });
        }

    });


</script>


</body>
</html>
