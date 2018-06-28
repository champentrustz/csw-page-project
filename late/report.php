
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
$teacherNumber = $_SESSION['teacher_number'];
$date_day_show = date("d/m/Y");

$date_day = $_REQUEST['date_search'];


if($date_day == null || $date_day == ''){
    $date_day = date("Y-m-d");
}

$_SESSION['date_day'] = $date_day;

if($teacherNumber == null || $teacherNumber == ''){
    ?>
    <script>window.location.href='login.php';</script>
    <?php
}

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
    <meta name="description" content="Responsive admin dashboard and web application ui kit. A 4px left border for the activated or hovered menu item.">
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

<!--    <header class="header bg-ui-general">-->
<!--        <div class="header-info">-->
<!--            <h1 class="header-title ">-->
<!--                 <span class="text-info">รายงานนักเรียนที่มาโรงเรียนสาย</span>-->
<!---->
<!--            </h1>-->
<!--        </div>-->

<!--    </header>-->


    <div class="container">

        <br/>


        <div class="card">


<!--            <h4 class="card-title show-font"><span class="icon ti-files"></span> รายงาน</h4>-->
            <div class="card-body">



                         <div class="form-inline">

                            <div class="form-group">

                        <div class="input-group">
                            <input type="text" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" value="<?php print $date_day_show?>" id="date-search">
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


                <button class="btn btn-primary" data-provide="loader" data-url="report_tb_late.php" data-target="#loader-target" style="display: none"  id="button-late">Button</button>
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
    var dateSearch = $( "#date-search" ).val();

    var date = dateSearch.substring(0,2 );
    var month = dateSearch.substring(3,5);
    var year = dateSearch.substring(6,10);

    var dateFormat = year+'-'+month+'-'+date

    $.post( "./report", {"date_search": dateFormat})

</script>

<script>

    $('#date-search').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
</script>
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



<script>
    async function dateSearch() {


        var dateSearch = $( "#date-search" ).val();

        var date = dateSearch.substring(0,2 );
        var month = dateSearch.substring(3,5);
        var year = dateSearch.substring(6,10);

        var dateFormat = year+'-'+month+'-'+date

        $.post( "./report", {"date_search": dateFormat})


        refreshTabel();

    }

    function refreshTabel()
    {
        $('#button-late').click();
    }
</script>


</body>
</html>
