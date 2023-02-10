<?php
session_start();
include 'connect.php';
include 'lib/function.php';
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>พิมพ์สรุประหว่างสัปดาห์</title>
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
<script>
    print();
</script>
<body class="oneColFixCtr">

<div id="container">
    <div id="content" class="page">
        <?php
            // print_r($_POST);
            // echo"<br><br>";
            // print_r($_SESSION);
            $t_id=$_SESSION['teacher_id'];
            $sem=$_SESSION['sem'];
            $day=$_POST['d_end'];
            $depart_id=$_SESSION['depart_id'];
            $t_name=get_teacherName($t_id);
            $depart_name=get_departName($depart_id);

            $week_round=$_POST['w_start']."-".$_POST['w_end'];
            if ($sem=='' || $t_id=='' || $week_round=='-'){
                header( "location: summary.php" );
            }
            $_SESSION['week_round']=$week_round;
       
            

        ?>
        <!-- <div id="right">สัปดาห์ที่ <?php echo $week_day['0'] ?></div> -->
        <div class="col-lg-12 center">
            <table width="90%" align="center"  cellpadding="0" cellspacing="0">
                <tr>
                    <td class="center"><h2>แบบใบเบิกค่าสอนพิเศษ</h2></td>
                    <!-- <td class="center">1</td> -->
                   
                </tr>
                <tr>
                    <!-- <td class="center">1</td> -->
                    <td class="center"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; วิทยาลัยเทคนิคชลบุรี</h3></td>
                </tr>
                <tr>
                    
                </tr>
            </table>
            <table width="70%" align="center">
                <tr>
                    <td align="right" width="100px">แผนกวิชา </td>
                    <td width="50px"></td>
                    <td class="left" ><?php echo get_departName($_SESSION['depart_id']) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="left" >[ <?php echo chk_ch($t_id,$sem)==true?"<b> / </b>" :"&nbsp;"  //===true แสดง '/'   ?> ] ปวช. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
                        ( &nbsp; ) ปีที่ 1 &nbsp;&nbsp;&nbsp;
                        ( &nbsp; ) ปีที่ 2 &nbsp;&nbsp;&nbsp;
                        ( &nbsp; ) ปีที่ 3
                    </td>
                    
                </tr>
                <tr>
                    <td align="right">ระดับชั้น</td>
                    <td></td>
                    <td align="left" >[ <?php echo chk_s($t_id,$sem)==true?"<b> / </b>" :"&nbsp;"  //===true แสดง '/'   ?> ] ปวส. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        ( &nbsp; ) ปีที่ 1 &nbsp;&nbsp;&nbsp;
                        ( &nbsp; ) ปีที่ 2
                    </td>
 
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="left" >[ &nbsp; ] หลักสูตรพิเศษ</td>
                </tr>
                <tr>
                    <td align="right">ประจำเดือน</td>
                    <td></td>
                    <?php 
                    if (getMonth($_POST['d_start']) == getMonth($_POST['d_end'])){
                        ?>
                        <td class="left"><?php echo getMonth2($_POST['d_start'])?></td>
                        <?php
                    }else{
                        ?>
                        <td class="left"><?php echo getMonth($_POST['d_start'])." - ".getMonth2($_POST['d_end']) ?></td>
                        <?php
                    }
                    ?>
                    
                    
                    </tr> 
            </table>

            <table width="70%" align="center">
                <tr>
                    <td>
                        <table  >
                            <tr>
                                <td rowspan="2">เงินค่าสอนพิเศษ&nbsp;</td>
                                <td>[ &nbsp; ] ครูประจำ</td>
                            </tr>
                            <tr>
                                <td>[ &nbsp; ] ครูพิเศษ</td>
                            </tr>
                        
                        </table>
                    </td>
                    <td>
                        <table  >
                            <tr>
                                <td rowspan="3">ระดับชั้น&nbsp;</td> 
                                
                                <td class="left">[ <?php echo chk_ch($t_id,$sem)==true?"<b> / </b>" :"&nbsp;"  //===true แสดง '/'   ?> ] มัธยมศึกษาตอนปลาย (ปวช.)</td>
                            </tr>
                            <tr>
                                <td class="left">[ <?php echo chk_s($t_id,$sem)==true?"<b> / </b>" :"&nbsp;"  //===true แสดง '/'  ?>] สูงกว่ามัธยมศึกษาตอนปลาย (ปวส.)</td>
                            </tr>
                            <tr>                          
                                <td class="left">[ &nbsp; ] หลักสูตรพิเศษ</td>
                            </tr>
                        
                        </table>
                    </td>
                </tr>
            </table>
            <h3>
        </div>
        <table width="80%" align="center">
            <tr>
            <td>ชื่อ <?php echo $t_name  ?>  </td>
            <td>ตำแหน่ง  <?php echo $_SESSION['position']  ?>  </td>
            </tr>
        </table>
        <!-- <TABLE width="90%" align="center" border="1" cellpadding="0" cellspacing="0"> -->
        <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr align="center">
                <th width="45px">สป.ที่</th>
                <th width="140px">ระยะเวลาที่สอน</th>
                <th width="70px">รหัสวิชา</th>
                <th>ชื่อวิชา</th>
                <th width="40px">รวม<br>ชม.<br>ในเวลา</th>
                <th width="40px">รวม<br>ชม.<br>นอกเวลา</th>
            </tr> 
            <?php
                $c=0;
                
                foreach ($_POST  as $key => $value ){
                    
                    $s=explode(":",$key);
                    if ($s[1]=="in" && $s[0]!="sum"){
                        $c++;
                        $v_in=$s[0].":in";
                        $v_out=$s[0].":out";
                        if($c==1){
                            ?>
                            <tr>
                                <td><?php echo $_POST['w_start']." - ".$_POST['w_end'] ?></td>
                                <td><?php echo chDay4($_POST['d_start'])." - ".chDay4($_POST['d_end']) ?></td>
                            <?php 
                        }else{
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                        <?php
                        }
                        ?>
                        <td><?php echo $s['0'] ?></td>
                        <td><?php echo get_subjectName($s['0']) ?></td>
                        <td align="center"><?php echo $_POST[$v_in] ?></td>
                        <td align="center"><?php echo $_POST[$v_out] ?></td>
                        </tr>
                        <?php

                    }  
                }
            ?>
                <tr>
                    <td colspan="4" align="right">รวมจำนวนคาบที่สอน &nbsp;&nbsp;</td>
                    <td align="center"><?php echo $_POST['sum:in'] ?></td>
                    <td align="center"><?php echo $_POST['sum:out'] ?></td>
                
                </tr>      
        </table>
        <br><br><br>
    </div><!-- content -->


    <div id="content" >
        <table  width="80%" align="center">
            <tr>
                <td class="right">ที่ <?php echo get_departName($_SESSION['depart_id']) ?></td>
            </tr>
            <tr>
                <td class="big">จำนวนที่ขอเบิก</td>
            </tr>
            <tr>
            </tr>
            
        
        </table>
        <table width="80%" align="center">
            <tr>
                <td>ระดับ ปวช. </td>
                <td>จำนวน</td>
                <td class="right"><?php echo ($_POST['sum_ch']=='')?'0':$_POST['sum_ch'] ?></td>
                <td> &nbsp; หน่วยชั่วโมง อัตราหน่วยชั่วโมงละ &nbsp; 200 &nbsp; บาท เป็นเงิน</td>
                <td class="right"><?php echo number_format(intval($_POST['sum_ch'])*200)?></td>
                <td>&nbsp; บาท</td>
            </tr>
            <tr> 
                <td>ระดับ ปวส. </td>
                <td>จำนวน</td>
                <td class="right"><?php echo ($_POST['sum_s']=='')?'0':$_POST['sum_s'] ?></td>
                <td> &nbsp; หน่วยชั่วโมง อัตราหน่วยชั่วโมงละ &nbsp;  270 &nbsp; บาท เป็นเงิน</td>
                <td class="right"><?php echo number_format(intval($_POST['sum_s'])*270)?></td>
                <td>&nbsp; บาท</td>
            </tr>
            <?php 
                $sum_total=(intval($_POST['sum_ch'])*200)+(intval($_POST['sum_s'])*270) ;
            ?>
            <tr>
                <td colspan="4" class="right">รวมเป็นเงินทั้งสิ้น &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="right"><?php echo number_format($sum_total) ?></td>
                <td>&nbsp; บาท</td>
            </tr>
        </table>
                <br><br>
        <table width="80%" align="center">
            <tr>
                <td width="250">&nbsp;</td>
                <td class="center">ลงชื่อ ............................................ผู้ขอเบิก</td>
            </tr>
            <tr>
                <td >&nbsp;</td>
                <td class="center">( <?php echo $t_name ?> )</td>
            </tr>
            <tr>
                <td >&nbsp;</td>
                <td class="center">ตำแหน่ง <?php echo $_SESSION['position']  ?></td>
            </tr>
            <tr>
                <td >&nbsp;</td>
                <td class="center">วันที่ <?php echo chDay2($day)  ?></td>
            </tr>
        </table>
        <hr width="80%">
        <table width="80%" align="center" >
            <tr>
                <td class="big" colspan="2" >คำรับรองของผู้บังคับบัญชา</td>
            </tr>
            <tr>
                <td colspan="2">ได้ตรวจใบเบิกค่าสอนนี้แล้วขอรับรองว่าผู้เบิกมีสิทธิ์เบิกได้ตามระเบียบและจำนวนที่ขอเบิกจริง</td>
            </tr>
            <tr>
                <td width="250px">เสนอ &nbsp;&nbsp;รองผู้อำนวยการฝ่ายวิชาการ </td>
                <td>เสนอ &nbsp;&nbsp;ผู้อำนวยการวิทยาลัยเทคนิคชลบุรี</td>
            </tr>
            <tr>
                <td>&nbsp; </td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;ลงชื่อ ............................................</td>
                <td >&nbsp;&nbsp;ลงชื่อ ............................................</td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( <?php echo get_head_depart($_SESSION['depart_id'])?> )</td>
                <!-- <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(นายวีรศักดิ์  ภักดีงาม)</td> -->
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(นางสองเมือง กุดั่น)</td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หัวหน้าแผนกวิชา</td>
                <!-- <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้แทนฝ่ายวิชาการ</td> -->
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รองผู้อำนวยการฝ่ายวิชาการ</td>
            </tr>
            <tr>
                <td>&nbsp; </td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;ลงชื่อ ............................................</td>
                <td >&nbsp;&nbsp;ลงชื่อ ............................................</td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(นายสาธิต วรรณสุทธิ์)</td>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(นายอำนวย  เหิมขุนทด)</td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;หัวหน้างานพัฒนาหลักสูตรการเรียนการสอน</td>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;รองผู้อำนวยการฝ่ายบริหารทรัพยากร</td>
            </tr>
        
        </table>
        <hr width="80%">
        <table width="80%" align="center">
            <tr>
                <td class="big" colspan="2" >อนุมัติ</td>
            </tr>
            <tr>
                <td></td>
                <td>ได้รับเงินจำนวน &nbsp;&nbsp; <?php echo number_format($sum_total) ?> &nbsp;&nbsp; บาท</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td> (<?php echo Convert($sum_total)?>) </td>
            </tr>
            <tr>
                <td></td>
                <td>&nbsp;ไปถูกต้องแล้ว</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;ลงชื่อ ............................................</td>
                <td >&nbsp;&nbsp;ลงชื่อ ............................................</td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(นายนิทัศน์ วีระโพธิ์ประสิทธิ์)</td>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $t_name?>)</td>
            </tr>
            <tr>
                <td >&nbsp;ตำแหน่งผู้อำนวยการวิทยาลัยเทคนิคชลบุรี</td>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ผู้รับเงิน</td>
            </tr>
            <tr>
                <td >&nbsp;วันที่ ....... เดือน ....................... พ.ศ. ..........</td>
                <td ></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td ></td>
                <td >&nbsp;&nbsp;ลงชื่อ ............................................</td>
            </tr>
            
            <tr>
                <td ></td>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(นางสาวสุชาดา แสงงาม)</td>
            </tr>
            <tr>
                <td ></td>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หัวหน้างานการเงิน</td>
            </tr>


        </table>
    </div><!-- content -->
    <br><br><br>
</div><!-- container -->
</body>
</html>

<?php
//  echo "sem1=".$sem;
//  echo "sem2=".$_SESSION['sem'];
// $week_round=$_POST['w_start']."-".$_POST['w_end'];

$chk_round=chk_round($sem,$t_id,$week_round);

if (!$chk_round){
    $sql="INSERT INTO `sum_week`(`sem`, `depart_id`, `depart_name`, `week_round`, `teacher_id`, `teacher_name`, `price`) 
        VALUES ('".$sem."','$depart_id','$depart_name','$week_round','$t_id','$t_name','$sum_total')";
    // echo $sql;
    if (mysqli_query($conn, $sql)) {
        // echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
}else{
    $sql="UPDATE `sum_week` SET `price`='$sum_total' 
    WHERE `sem`='$sem' and `week_round`='$week_round' and `teacher_id`='$t_id'" ;
    if (mysqli_query($conn, $sql)) {
        // echo "Record updated successfully";
      } else {
        echo "Error updating record: " . mysqli_error($conn);
      }
}
// echo $sql;


function chk_round($sem,$t_id,$week_round){
    global $conn;
    $sql="SELECT * FROM `sum_week` WHERE `sem`='$sem' AND `teacher_id`='$t_id' AND `week_round`='$week_round'";
    // echo $sql;
    $res=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($res) ;
    if ($num>0){
        return true;
    }
}

