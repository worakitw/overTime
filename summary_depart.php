<?php
session_start();
include 'connect.php';
include 'lib/function.php';
header('Content-Type: text/html; charset=UTF-8');
?>
้<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>พิมพ์สรุปแผนกวิชา</title>
    <!-- <link rel="stylesheet" href="css/bootstrap3.min.css"> -->
    <style type="text/css">
        body {
            /* font: 100% Verdana, Arial, Helvetica, sans-serif; */
            background: #666666;
            margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
            padding: 0;
            text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
            color: #000000;

        }
        .oneColFixCtr #container {
            width: 600px;  /* using 20px less than a full 800px width allows for browser chrome and avoids a horizontal scroll bar */
            background: #FFFFFF;
            margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
            border: 0px solid #000000;
            text-align: left; /* this overrides the text-align: center on the body element. */
        }
        .oneColFixCtr #mainContent {
            padding: 0 20px; /* remember that padding is the space inside the div box and margin is the space outside the div box */
        }
        .center{
            /* font-size: 12px; */
            text-align: center; 
        }
        #right{
            font-size: 12px;
            text-align: right; 
        }
        #content tr td{
            /* font-weight: bold; */
            /* text-align: center; */
            font-size:12px;
            padding: 1px;
        }
        #content th{
            font-size:12px;
        }
        #content h2 {
            background-color: transparent;
            color: #000;
            font-size: 14px;
            font-weight: bold;
            margin: 15px 0 0px 0;
            padding: 0px 0 6px 0;
            margin-left: 40px;
        }
        div.page { 
	        page-break-after: always; 
        }
        .right{
            text-align: right;
        }
        .left{
            text-align: left;
        }
        .center{
            text-align: center;
        }
        .big{
            font-size: 16px;
            font-weight: bold;
        }

    </style>
</head>

<body class="oneColFixCtr">

<div id="container">   
    <div id="content" class="page">
        <?php
            // print_r($_POST);
            // echo"<br><br>";
            // print_r($_SESSION);
            $t_id=$_SESSION['teacher_id'];
            $sem=$_SESSION['sem'];
            $depart_id=$_SESSION['depart_id'];
            // $t_name=get_teacherName($t_id);
            $depart_name=get_departName($depart_id);
            $week=$_SESSION['week_round'];
            $arrweek=explode("-",$week);
            $start_week=$arrweek['0'];
            $end_week=$arrweek['1'];
            // get_summary($sem,$t_id,$week);
            $end_day=get_end_day($end_week,$sem);
            $start_day=get_start_day($start_week,$sem);
            if ($sem=='' || $depart_id=='' || $week=='' ){
                header( "location: summary.php" );
            }


       
            

        ?>
        <div class="col-lg-12 center">
            <table width="90%" align="center"  cellpadding="0" cellspacing="0">
                <tr>
                    <td width="350px">&nbsp;</td>
                    <td>วิทยาลัยเทคนิคชลบุรี</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo $depart_name ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <table width="90%" align="center">
                <tr>
                    <td width="250px"> </td>
                    <td>วันที่ <?php echo chDay2($end_day)?></td>
                </tr>
                <tr>
                    <td>เรื่อง &nbsp;&nbsp;&nbsp; รับรองการตรวจใบเบิกคําสอนพิเศษ </td>
                    <td></td>
                </tr>
                <tr>
                    <td>เรียน &nbsp;&nbsp;&nbsp; ผู้อํานวยการวิทยาลัยเทคนิคชลบุรี </td>
                    <td></td>
                </tr>
                <tr>
                    <td> &nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan='2'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        ด้วย<?php echo $depart_name ?> ได้ทําการตรวจใบเบิกค่าสอนพิเศษ ตั้งแต่สัปดาห์ที่ <?php echo $start_week ?>
                        ถึงสัปดาห์ที่ <?php echo $end_week ?> 
                        วันที่ <?php echo chDay2($start_day)?> ถึงวันที่ <?php echo chDay2($end_day)?>
                         เรียบร้อยแล้ว สรุปเงินค่าสอนพิเศษได้ดังนี้
                    </td>
                </tr>
            </table>
            <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <th>ที่</th>
                    <th>ชื่อ - นามสกุล</th>  
                    <th>จํานวนเงิน</th>
                    <th>หมายเหตุ</th>
                </tr>
                
                <?php
                // $sql="SELECT * FROM `sum_week` WHERE `sem`='$sem' AND `depart_id`='$depart_id' AND `week_round`='$week'";
                $sql="SELECT * FROM `sum_week` sm
                LEFT JOIN teacher_piority tpio on tpio. teacher_id=sm.`teacher_id`
                WHERE `sem`='$sem' AND `depart_id`='$depart_id' AND `week_round`='$week'
                ORDER by tpio.piority";
                // echo $sql;
                // print_r ($_SESSION);
                $res=mysqli_query($conn,$sql);
                $num=mysqli_num_rows($res) ;
                $c=1;
                $sum=0;
                while ($row=mysqli_fetch_assoc($res)){
                    $sum=$sum+$row['price'];              
                    ?>
                    <tr>
                        <td class="center"><?php echo $c++?></td>
                        <td><?php echo $row['teacher_name']?></td>
                        <td class="right"><?php echo number_format($row['price'])?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="2" class="right">รวมจํานวนเงิน &nbsp;&nbsp;&nbsp;</td>
                    <td class="right"><?php echo number_format($sum)?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td></td>
                </tr>
            </table>
            <table width="90%" align="center">
                <tr>
                    <td width="250px"></td>
                    <td class="">( <?php echo Convert($sum)?> )</td>
                </tr>
                <tr>
                    <td class="center">จึงเรียนมาเพื่อทราบ</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="center">ลงชื่อ ...........................................</td>
                    <td class="center">ลงชื่อ ...........................................</td>
                    
                </tr>
                <tr>
                    <td class="center">( <?php echo get_head_depart($depart_id) ?> )</td>
                    <td class="center">( นางสองเมือง กุดั่น )</td>
                </tr>
                <tr>
                    <td class="center">หัวหน้า<?php echo $depart_name ?></td>
                    <td class="center">รองผู้อำนวยการฝ่ายวิชาการ</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="center"></td>
                    <td class="center">ลงชื่อ ...........................................</td>
                    
                </tr>
                <tr>
                    <td class="center"></td>
                    <td class="center">( นายนิทัศน์ วีระโพธิ์ประสิทธิ์ )</td>
                </tr>
                <tr>
                    <td class="center"></td>
                    <td class="center">ผู้อํานวยการวิทยาลัยเทคนิคชลบุรี</td>
                </tr>
            </table>
    </div><!-- content -->
</div><!-- container -->

</body>
</html>
<?php

function get_end_day($end_week,$sem){
    global $conn;
    $sql="SELECT * FROM `day_week` WHERE `week_no`='$end_week' AND sem='$sem' ";
    // var_dump($sql);
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    return $row['day_stop'];
}
function get_start_day($start_week,$sem){
    global $conn;
    $sql="SELECT * FROM `day_week` WHERE `week_no`='$start_week' AND sem='$sem'";
    // echo $sql;
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    return $row['day_start'];
}

