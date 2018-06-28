
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
$teacherNumber = $_SESSION['teacher_number'];
if($teacherNumber == null || $teacherNumber == ''){
    ?>
    <script>window.location.href='login.php';</script>
<?php
}
$date_day = date("Y-m-d");
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="sidebar, bordery">

    <title>C.S.W. Online Check-in</title>

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

<script>
    var refreshTime = 200000; // every 10 minutes in milliseconds
    window.setInterval( function() {
        $.ajax({
            cache: false,
            type: "GET",
            url: "main",
            success: function(data) {
            }
        });
    }, refreshTime );
</script>


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

<!--    <header>-->
<!--        <div class="header-info">-->
<!--            <h1 class="header-title ">-->
<!--                 <span class="text-info">เช็คชื่อนักเรียนที่มาโรงเรียนสาย</span>-->
<!--                <small class="show-font">ประจำวัน--><?php //print thDate()?><!--</small>-->
<!--            </h1>-->
<!--        </div>-->

<!--    </header>-->

    <div class="container">

        <br/>


        <div class="card">
        <div class="card-body">


            <button class="btn btn-primary" data-provide="loader" data-url="tb_late.php" data-target="#loader-target" style="display: none"  id="button-late">Button</button>
            <div id="loader-target">

            </div>

        </div>
        </div>









    </div>
    <div id="log"></div>


</main>
<!-- END Main container -->





<!-- Scripts -->
<script src="../js/core.min.js"></script>
<script src="../js/app.min.js"></script>
<script src="../js/script.min.js"></script>

<script>

    var click = 0;
    var toggle = 0;

    setTimeout(function(){  $('#button-late').trigger('click'); }, 200);

    // $( "#toggle-fold" ).click(function() {
    //     click ++;
    //     if(click %2 == 0){
    //         $('#profile').show();
    //     }
    //     else{
    //
    //         $( document ).on( "mousemove", function( event ) {
    //             if(click %2 == 0){
    //                 event.stopPropagation();
    //             }
    //             else{
    //                 if(event.pageX <= 80 && event.pageY >= 0){
    //                     $('#profile').show('slow');
    //
    //                 }
    //                 if(event.pageX >= 260 && event.pageY >= 0){
    //                     $('#profile').hide('slow');
    //
    //                 }
    //             }
    //
    //         });
    //     }
    //
    // });


</script>


</body>
</html>
