<?php
session_start();
include 'connect.php';
include 'lib/function.php';
//================save excel file==========================
if(isset($_GET['act'])){
	if($_GET['act']== 'excel'){
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=export.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
}
//========================================================
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>พิมพ์รายสัปดาห์</title>
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
            text-align: center; 
        }
        td.right{
            text-align: right; 
        }
        #right{
            font-size: 12px;
            text-align: right; 
        }
        #content tr td{
            /* font-weight: bold; */
            text-align: left;
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
        table.center {
            margin-left: auto; 
            margin-right: auto;
        }
        td.center{
            text-align: center;
        }
        a {
            color: black;
            text-decoration: none;
        }
        a:visited {
            color: black;
        }
        a:hover, a:active, a:focus {
            color: black;
        }
    </style>
</head>

<body class="oneColFixCtr">
<div id="container">
    <div id="content">
        <?php
        $week_day=explode(":",$_SESSION['week_day']);
        $t_id=$_SESSION['teacher_id'];
        $sem=$_SESSION['sem'];
        $teacher_name=get_teacherName($_SESSION['teacher_id']);
        // $head_depart=get_head_depart($_SESSION['depart_id']);
        $week_day=explode(":",$_SESSION['week_day']);
        $day= $week_day['1']  ;
        ?>
        <div id="right">สัปดาห์ที่ <?php echo $week_day['0'] ?></div>

        <h2 class="center"><a href="?act=excel"> ใบเบิกค่าสอนพิเศษ</a></h2> 
        
        <table width="90%" class="center" >
            <tr>
            <td>คำขอเบิก</td>
            <td></td>
            </tr>
            <tr>
                <td width="50%">ข้าพเจ้า <?php echo $teacher_name ?></td><td>ตำแหน่ง <?php echo $_SESSION['position'] ?></td>
            </tr>
            <tr>
                <td>สังกัด วิทยาลัยเทคนิคชลบุรี </td><td>ขอยื่นคําขอรับเงินค่าสอนพิเศษ</td>
            </tr>
            <tr>
                <td>ต่อ ผู้อํานวยการวิทยาลัยเทคนิคชลบุรี </td><td>ดังต่อไปนี้ </td>
            </tr>
        </table> 
        <table width="80%" class="center">
            <tr>
                <td>ข้าพเจ้าได้สอนในระดับ </td>
                <td>[ 
                    <?php echo chk_s($t_id,$sem)==true?"<b> / </b>" :"&nbsp;"  //===true แสดง '/'   ?>             
                ] สูงกว่าระดับมัธยมศึกษาตอนปลาย (ปวส. ปวท.)</td>
            </tr>
            <tr>
                <td></td>
                <td>[ 
                    <?php echo chk_ch($t_id,$sem)==true?"<b> / </b>" :"&nbsp;"  //===true แสดง '/'   ?>
                ] มัธยมศึกษาตอนปลาย (ปวช.)</td>
            </tr>
        </table>
        <table width="80%" class="center">
            <tr>
            <td>วันที่ <?php echo chDay2($week_day['1'] ) ?>  </td>
            <td>ถึงวันที่  <?php echo chDay2($week_day['2'] ) ?>  </td>
            </tr>
        </table>
        <!-- <TABLE width="90%" align="center" border="1" cellpadding="0" cellspacing="0"> -->
        <table width="90%" border="1" class="center" cellpadding="0" cellspacing="0">
            <tr class="text-center">
                <th width="110px">ว/ด/ป</th>
                <th width="70px">รหัสวิชา</th>
                <th width="30%">ชั้นเรียน</th>
                <th width="70px">เวลาที่สอน</th>
                <th>ชั่วโมง</th>
                <th width="100px">หมายเหตุ</th>
            </tr> 
            <?php
            $dayofweek=array('จันทร์','อังคาร','พุธ','พฤหัส','ศุกร์','เสาร์','อาทิตย์');
            $d1=0;
            foreach($dayofweek as $v_day){
                        
                $repeat = strtotime("+".$d1." day",strtotime($day));
                $day2 = date('Y-m-d',$repeat); //==วันปัจจุบัน====
                $day2_date[]=$day2;
                //$c_day++; //เลขวัน จันทร์=1
                // echo $v_day."<br>"; 
                $d1++;
            }
            //print_r($day2_date);
            $sql="SELECT * FROM `draw_money` 
                WHERE `sem`='$sem' 
                AND `t_id`='$t_id' 
                GROUP BY drp1
                ORDER BY `drp1`" ;
            // echo $sql;die();
            $res=mysqli_query($conn,$sql);
            $sum=0; 
            $d1=0;
            $c=0;                                         

            while($row=mysqli_fetch_assoc($res)){ 
                $pe=$row['period'] ; //คาบสอน
                $sum+=$pe ;
                // $repeat = strtotime("+".$d1." day",strtotime($day));
                // $day2 = date('Y-m-d',$repeat); //==วันปัจจุบัน====
                // =====ตรวจสอบวันหยุด=======
                $chk_holiday=chk_holiday($sem,$day2_date[$c]);
                // print_r($chk_holiday);
                // =====ตรวจสอบวันลา=======
                $chk_leave=chk_leave($sem,$t_id,$day2_date[$c]);
                // print_r($chk_leave);
                // =====ตรวจสอบสอนแทน=======
                $chk_instead=chk_instead($sem,$t_id,$day2_date[$c]);
                // print_r($chk_instead);
                //ตารางปกติใน draw_money
                                
                // =====ถ้ามีวันหยุด=======
                if (is_array($chk_holiday)){
                    $sum-=$pe ;
                    // echo "f_ho=".$f_holiday."day1=".$row['day1']."<br>";
                    if ($f_holiday==$row['day1']){
                        $f_day1=$row['day1'] ;
                        $c++;
                        continue;                                        
                    }
                    ?>
                    <tr class="text-center">
                    <td class="l">
                        <?php 
                        echo $row['day1'] ." &nbsp; ". chday3($day2_date[$c]) ;
                        ?>
                        </td>
                    <td align='center'>-</td>
                    <td align='center'>-</td>
                    <td align='center'>-</td>
                    <td align='center'>-</td>
                    <td><?php echo $chk_holiday[0] ?></td>
                    </tr>
                    <?php
                    $f_holiday=$row['day1'];
                    $c++;
                    continue;
                }
                // =======ถ้ามีวันลา
                else if (is_array($chk_leave)){
                    $sum-=$pe ;
                    // echo "f_ho=".$f_holiday."day1=".$row['day1']."<br>";
                    if ($f_leave==$row['day1']){
                        $f_day1=$row['day1'] ;
                        $c++;
                        continue;                                        
                    }else {
                        ?>
                        <tr class="text-center">
                        <td class="l">
                            <?php 
                            echo $row['day1'] ." &nbsp; ". chday3($day2_date[$c]) ;
                            ?>
                            </td>
                        <td align='center'>-</td>
                    <td align='center'>-</td>
                    <td align='center'>-</td>
                    <td align='center'>-</td>
                        <td><?php echo $chk_leave[0] ?></td>
                        </tr>
                        <?php
                        $f_leave=$row['day1'];
                        $c++;
                        continue; 
                    }
                }
                // =======ถ้ามีสอนแทน
                if (is_array($chk_instead)){
                    // echo $c."<br>";
                    // echo $day2_date[$c];
                    // echo "<pre>";
                    // print_r($chk_instead);
                    foreach ($chk_instead as $v){
                        $pe_instead=$v['period'];
                        $sum+=$pe_instead ;
                        $_time=explode("-",$v['time']);
                        $time=get_time($_time[0])."-".get_time($_time[1]);
                        ?>
                        <tr class="text-center">
                            <td class="l">
                                <?php 
                                if ($f_day1 == getDay_dpr($v['dpr1'])){
                                    echo "";
                                }else{
                                    echo getDay_dpr($v['dpr1']) ." &nbsp; ". chday3($day2_date[$c]) ;
                                }
                                ?>
                            </td>
                        <td><?php echo $v['subj_id']?></td>
                        <td class="l"><?php echo $v['std_group']?></td>
                        <td><?php echo $time?></td>
                        <td style="text-align: center"><?php echo $v['period'] ?></td>
                        <td><?php echo $v['comment']?></td>
                        </tr>
                        <?php
                        $f_day1=getDay_dpr($v['dpr1']); 
                    }
                    $c++;
                    continue;
                }
                //=========ตารางปกติ
                else{
                    // echo "aaaaa".$day2_date[$c];
                    if($row['subject']!='' ){ 
                        ?>
                        
                        <tr class="text-center">
                            <td class="l"><?php 
                                if ($f_day1 == $row['day1']){
                                    echo "";
                                }else {
                                    echo $row['day1'] ." &nbsp; ". chday3($day2_date[$c]) ;
                                    $c++;
                                }
                                ?>
                            </td>
                            <td><?php echo $row['subject'] ?></td>
                            <td class="l"><?php echo $row['std_group'] ?></td>
                            <td><?php echo $row['time'] ?></td>
                            <td style="text-align: center"><?php echo $pe ?></td>
                            <!-- สอนชดเชย เพิ่ม comment -->
                            <?php
                            $drp1=$row['drp1'];
                            $comment=chk_compensate($sem,$t_id,$day2_date[$c],$drp1);

                            ?>
                            <td><?php echo $comment ?></td>
                        </tr>
                        <?php
                    }
                }
                // echo $day2;
                $instead_day_f=$day2_date[$c];
                $f_day1=$row['day1'] ;
                
            }//end while


             ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr> 
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>   
                                <tr>
                                <td colspan="4" style="text-align: right">รวม &nbsp;&nbsp;&nbsp;</td>
                                <td style="text-align: center"><?php echo $sum ?></td><td></td>
                                </tr>     
                            </table>
        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td width="50%"></td>
                <td>รวมชั่วโมง ในเวลา</td> <td><?php echo $_POST['in'] ?> &nbsp;&nbsp; คาบ </td>  
                <td>นอกเวลา</td> <td><?php echo $_POST['out'] ?> &nbsp;&nbsp; คาบ</td>
            </tr>
        </table>

        <br><br><br>
        <table width="90%" align="center">
            <tr>
            <td width="10%"></td>
            <td colspan="3">ได้ตรวจใบเบิกค่าสอนนี้แล้ว ขอรับรองว่าผู้เบิกมีสิทธิ์เบิกได้ตามระเบียบและจำนวนที่ขอเบิกจริง</td>
            </tr>
            <tr><td><br><br><br></td></tr>
            <tr>
                <td width="100px"></td>
                <td>ลงชื่อ...................................หัวหน้าแผนกวิชา</td>
                <td>ลงชื่อ...................................</td>
            </tr>
            <tr>
                <td ></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo get_head_depart($_SESSION['depart_id'])?>)</td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo get_teacherName($t_id)?>)</td>
            </tr> 
        </table>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
</div>
</body>
</html>
