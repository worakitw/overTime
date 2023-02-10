<?php 
include 'header.php'; 
// include_once 'connect.php';
include 'lib/function.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if(isset($_POST['select_teacher'])){
  $_SESSION["depart_id"]=$_POST['depart_id'];
  $_SESSION['teacher_id']=$_POST['teacher_id'];
  $_SESSION['position']=$_POST['position'];

  
}
if (isset($_SESSION['teacher_id'])){
    $t_id=$_SESSION['teacher_id'];
}
//print_r($_SESSION);
$sem=$_SESSION['sem'];
$c_numberDay=0;
?>
<!-- นำเข้า Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap3.min.css">
    
    <!-- นำเข้า Select2 CSS -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" /> -->
 
 <style>
    table {
        width: 80%;
        margin:auto;
    }
    table, th, td {
        border: 1px solid black;
    }
    th {
        text-align: center;
    }
    input{
        width:50px;
        text-align: center;
    }
    .l {
        text-align: left;
        padding-left : 3px;
    }


 </style>

<main role="main">
   <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

<div class="container marketing">
  <!-- <br><br><br> -->
    <?php
      if (isset($_POST['clear'])){
        unset($_SESSION["depart_id"]);
        unset($_SESSION['teacher_id']);
        unset($_SESSION['position']);
      }
    ?>
    <div class="row">
        
        <div class="col-lg-6 "><!-- left -->
            <h4 class="card-title text-primary">การสอนรายสัปดาห์</h4>
            <?php
            if (isset($_SESSION['teacher_id'])){
                // echo $_SESSION['teacher_id'];

                ?>
                <div class="card bg-primary text-white">
                    <div class="card-body"> <?php echo get_departName($_SESSION['depart_id']) ?></div>
                </div>
                <div class="card bg-primary text-white">
                    <div class="card-body">ครูผู้สอน <?php echo get_teacherName($_SESSION['teacher_id']) ?></div>
                </div>
                <br>
                </div>
                <!-- =========เลือกสัปดาห์==================== -->
                <div class="col-lg-6 "><!-- right -->
                    <form action="" method="post">
                        <div class="form-group">
                            <?php 
                            show_select_sem();
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="start_week">เลือกสัปดาห์ :</label>
                            <select class="form-control form-control-sm select2-single" id="start_week" name="start_week" >
                                <option value="">-- กรุณาเลือกสัปดาห์ --</option>
                            </select>
                        </div>
                        
                        <div class="text-center">
                        <button type="submit" name="show_subject_week" class="btn btn-info "> แสดงข้อมูล </button>
                        &nbsp;&nbsp;&nbsp;
                        <button name="clear" class="btn btn-warning"> เลือกครูใหม่ </button>
                        
                        </div>  
                    </form>
                </div> 
                
                
                <?php 
                // ============แสดงผลตาราง draw_money อ่านจาก studing บันทึกลง draw_money แสดงผลตาราง===================
                if (isset($_POST['show_subject_week'])){ 
                    $_SESSION['week_day']=$_POST['start_week'];//
                    $week_day=explode(":",$_SESSION['week_day']); //array =>2022-07-18
                    // print_r($week_day);
                    //ลบข้อมูลเก่า
                    del_draw_many($sem,$t_id);
                    //เพิ่มข้อมูลใหม่
                    add_draw_money($t_id,$sem);
                    //ปรับฐานข้อมูล drawmoney ให้มีครบ 7 วัน
                    $dayofweek=array('จันทร์','อังคาร','พุธ','พฤหัส','ศุกร์','เสาร์','อาทิตย์');
                    //============================  
                    $c_day=0; 
                    $day= $week_day['1']  ; //วันแรกของสัปดาห์  2022-07-18
                    $d1=0;
                    foreach($dayofweek as $v_day){
                        $repeat = strtotime("+".$d1." day",strtotime($day));
                        $day2 = date('Y-m-d',$repeat); //==วันปัจจุบัน====
                        $day2_date[]=$day2;
                        $c_day++; //เลขวัน จันทร์=1
                        // echo $v_day."<br>";
                        // edit_drawmoney($v_day,$t_id,$sem,$c_day); 
                        $d1++;
                    }
                    // print_r($day2_date);  //[0] => 2022-06-27 [1] => 2022-06-28 [2] => 2022-06-29 
                    // echo"<br>";
                    // print_r($dayofweek); // [0] => จันทร์ [1] => อังคาร [2] => พุธ [3] => พฤหัส [4] => ศุกร์ [5] => เสาร์ [6] => อาทิตย์ 

                    // ===============แสดงรายการสอน รายสัปดาห์=========================
                    ?> 
                    
                    <div class="col-lg-12 ">
                        <h4 style="margin-left:150px">สัปดาห์ที่ <?php echo $week_day['0'] ?></h4>
                        <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
                            <tr class="text-center">
                                <th width="200px">ว/ด/ป</th>
                                <th width="120px">รหัสวิชา</th>
                                <th >ชั้นเรียน</th>
                                <th width="100px">เวลาที่สอน</th>
                                <th>ชั่วโมง</th>
                                <th width="130px">หมายเหตุ</th>
                            </tr> 
                            <?php

                            
                            
                            $sum=0; 
                            $d1=0;
                            $c=0;
                            foreach($dayofweek as $v_day){

                                // echo "วันที่ day2_date =".$day2_date[$c]."<br>";
                                // echo "วันในสัปดาห์ dayofweek =".$dayofweek[$c]."<br>";
                            
                                // =====ตรวจสอบวันหยุด=======
                                $chk_holiday=chk_holiday($sem,$day2_date[$c]);
                                // echo"<pre>";
                                // print_r($chk_holiday);
                                // =====ตรวจสอบวันลา=======
                                $chk_leave=chk_leave($sem,$t_id,$day2_date[$c]);
                                // print_r($chk_leave);
                                
                                //ตารางปกติใน draw_money
                                $chk_draw_money=chk_draw_money($sem,$t_id,$day2,$dayofweek[$c]);
                                // print_r($chk_draw_money);exit();
                                // =====ตรวจสอบสอนแทน=======
                                $chk_instead=chk_instead($sem,$t_id,$day2_date[$c]);
                                //print_r($chk_instead);

                                
                            
                           
                                // =====ถ้ามีวันหยุด=======
                                if (is_array($chk_holiday)){
                                    // echo "==chk_holiday =============<br>";
                                    ?>
                                    <tr class="text-center">
                                    <td class="l">
                                        <?php 
                                        echo $dayofweek[$c] ." &nbsp; ". chday($day2_date[$c]) ;
                                        ?>
                                        </td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td><?php echo $chk_holiday['name'] ?></td>
                                    </tr>
                                    <?php
                                    $f_day1=$dayofweek[$c] ;
                                    $c++;
                                    continue;
                                }
                                 // =======ถ้ามีวันลา
                                else if (is_array($chk_leave)){
                                    // echo "==chk_leave =============<br>";
                                        ?>
                                        <tr class="text-center">
                                        <td class="l">
                                            <?php 
                                            echo $dayofweek[$c] ." &nbsp; ". chday($day2_date[$c]) ;
                                            ?>
                                            </td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><?php echo $chk_leave[0] ?></td>
                                        </tr>
                                        <?php
                                        $f_leave=$dayofweek[$c];
                                        $c++;
                                        continue; 
                                    // }
                                }
                                // =======ตารางปกติ
                                if(is_array($chk_draw_money)){
                                    // echo "==ตารางปกติ =============<br>";
                                    // print_r($chk_draw_money);

                                    foreach ($chk_draw_money as $v){

                                        if($v['subject']!='' ){ 
                                            $pe=$v['period'];

                                            $sum+=$pe ;
                                            $_time=explode("-",$v['time']);
                                            $time=$v['time'];

                                            ?>
                                            
                                            <tr class="text-center">
                                                <td class="l">
                                                    <?php 
                                                    // echo "day1=".$v['day1']." | dayofweek".$dayofweek[$c]."<br>";
                                                    if ($f_day1 == $dayofweek[$c]){
                                                        echo "";
                                                    }else {
                                                        echo $dayofweek[$c] ." &nbsp; ". chday($day2_date[$c]) ;
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $v['subject'] ?></td>
                                                <td class="l"><?php echo $v['std_group'] ?></td>
                                                <td><?php echo $time ?></td>
                                                <td><?php echo $v['period'] ?></td>
                                                <!-- สอนชดเชย เพิ่ม comment -->
                                                <td></td>
                                            </tr>
                                            <?php
                                            $f_day1=$dayofweek[$c];
                                        }else{
                                            continue;
                                        }
                                    }

                                }
                                 // =======ถ้ามีสอนแทน
                                if (is_array($chk_instead)){
                                    // echo "==chk_สอนแทน =============<br>";
                                    
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
                                                    echo getDay_dpr($v['dpr1']) ." &nbsp; ". chday($day2_date[$c]) ;
                                                }
                                                ?>
                                            </td>
                                        <td><?php echo $v['subj_id']?></td>
                                        <td class="l"><?php echo $v['std_group']?></td>
                                        <td><?php echo $time?></td>
                                        <td><?php echo $v['period'] ?></td>
                                        <td><?php echo $v['comment']?></td>
                                        </tr>
                                        <?php
                                        $f_day1=getDay_dpr($v['dpr1']); 
                                    }
                                    $c++;
                                    continue;
                                }
                                $c++;
                            }
    
                            
                            ?>
                            <tr>
                            <td colspan="4" align="right">รวม &nbsp;&nbsp;&nbsp;</td>
                            <td align="center"><?php echo $sum ?></td><td></td>
                            </tr>     
                        </table>
                        
                    
                        <br>
                        <div class="text-center">
                            <form action="print_week5.php" method="post" target="_blank">
                                ในเวลา <input type="text" name="in" id="in" > คาบ &nbsp;&nbsp;  
                                นอกเวลา <input type="text" name="out" id="out"> คาบ   &nbsp;&nbsp;
                                <span class="text-danger">กรอกข้อมูลในช่องนอกเวลาก่อน ระบบจะคำนวณในเวลาให้</span>
                                <br><br>
                                <div class="col-lg-12 " style="text-align:center;">
                                    <button type="submit" class="btn btn-primary" >print</button>
                                </div> 
                            </form>
                        </div>

                    </div>
                    <!-- ---------end รายการสอน รายสัปดาห์--------- -->   
                    <?php   
                }
                // =============ครั้งแรกเลือกครู=============    
            }
            else{
                             ?>
                             <!-- เลือกแผนกวิชา/ครู -->
                             <form action="" method="post">
                                 <div class="form-group">
                                     <label for="depart_id">เลือกแผนกวิชา</label>
                                     <select class="form-control form-control-sm select2-single" id="depart_id" name="depart_id">
                                         <option value="">-- กรุณาเลือกเลือกแผนกวิชา --</option>
                                     </select>
                                 </div>
                                 <div class="form-group">
                                     <label for="teacher" >เลือกครูผู้สอน</label>
                                     <select class="form-control select2-single" id="teacher" name="teacher_id">
                                         <option id="teacher_list"> -- กรุณาเลือกเลือกครูผู้สอน -- </option>
                                     </select>
                                 </div>
                                 <div class="form-group">
                                     <label for="position" >เลือกตำแหน่ง</label>
                                     <select class="form-control select2-single" id="position" name="position" require>
                                         <option value=''> -- กรุณาเลือกเลือกตำแหน่ง -- </option>
                                         <option value="ครูผู้ช่วย">ครูผู้ช่วย</option>
                                         <option value="ครู">ครู</option>
                                         <option value="ครูชำนาญการ">ครูชำนาญการ</option>
                                         <option value="ครูชำนาญการพิเศษ">ครูชำนาญการพิเศษ</option>
                                         <option value="พนักงานราชการ (ครู)">พนักงานราชการ (ครู)</option>
                                         <option value="ครูพิเศษสอน">ครูพิเศษสอน</option>
                                     </select>
                                 </div>
                                 <button type="submit" name="select_teacher" class="btn btn-primary" >Submit</button>
                             </form>
                             <?php

                }
            
                ?>
        </div><!-- /.col-left -->
    </div><!-- /.row -->
</div><!-- /.container -->
</main>



<?php include 'footer.php'; ?>

    
<script>
$(document).ready(function() {
    //  alert("aaa");
    $('#out').focus();
    $('#out').focusout(function(){
        var p_out = $(this).val();
        var sum='<?php echo $sum ?>';
        $('#in').val(sum-p_out);

    });


    $('.select2-single').select2();

    $.ajax({
      url:"ajax/get_data.php",
      dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
      data:{show_depart:'show_depart'}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
      success:function(data){
        
        //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
        $.each(data, function( index, value ) {
          //แทรก Elements ใน id province  ด้วยคำสั่ง append
            $("#depart_id").append("<option value='"+ value.id +"'> " + value.name + "</option>");
        });
      }
    });


    $("#depart_id").change(function(){
					
        //กำหนดให้ ตัวแปร amphur_id มีค่าเท่ากับ ค่าของ  #amphur ที่กำลังถูกเลือกในขณะนั้น
        var depart_id = $(this).val();
        
        $.ajax({
            url:"ajax/get_data.php",
            dataType: "json",//กำหนดให้มีรูปแบบเป็น Json
            data:{depart_id:depart_id},//ส่งค่าตัวแปร amphur_id เพื่อดึงข้อมูล ตำบล ที่มี amphur_id เท่ากับค่าที่ส่งไป
            success:function(data){
                
                //กำหนดให้ข้อมูลใน #district เป็นค่าว่าง
                $("#teacher").text("");
                
                //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data  
                $.each(data, function( index, value ) {
                    
                    //แทรก Elements ข้อมูลที่ได้  ใน id teacher  ด้วยคำสั่ง append
                    $("#teacher").append("<option value='" + value.id + "'> " + value.name + "</option>");
                    
                });
            }
        });				
    });

    var sem="<?php echo $sem ?>";
    $.ajax({
      url:"ajax/get_data.php",
      dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
      data:{show_week:sem}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
      success:function(data){
        
        //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
        $.each(data, function( index, value ) {
          //แทรก Elements ใน id province  ด้วยคำสั่ง append
            $("#start_week").append("<option value='"+ value.id +"' " +value.selected+"> " + value.name + "</option>");
            // $("#stop_week").append("<option value='"+ value.id +"'> " + value.name + "</option>");
        });
        $("#start_week").value("aaaaaa");
      }
    });


});
</script>

<?php
function del_draw_many($sem,$t_id){
    global $conn;
    $sql="DELETE FROM `draw_money` WHERE `sem`='$sem' AND `t_id`='$t_id'";
    // echo $sql;exit();
    $res=mysqli_query($conn,$sql);
    return $res;
}

function add_draw_money($t_id,$sem){
    global $conn;
    $groupNoShow1="('642010001','642010002','642010003','642010004','642010005','642010006','642010007','642010008','642010009','642010010','642010011','642010012',
                                    '64020001','64020002','64020003','64020004','64020005','64020006','64020007','64020008')";
    $groupNoShow2="('643010002','643010003','643010004','643010005','643010006','643010007','643010008',
                    '64030001','64030002','64030003')";
    $groupNoShow3="'__20100%'"; 
    $groupNoShow4="'__30100%'";
    $sql="SELECT * FROM `studing` WHERE `teacher_id`='".$t_id."' and semes='".$sem."'
                        and `subject_id` != '9999 9999' 
                        and `subject_id` != '9999-9999' 
                        and `subject_id` != 'Home Room' 
                        and `student_group_id` NOT IN $groupNoShow1 
                        and `student_group_id` NOT IN $groupNoShow2 
                        and `student_group_id` not like $groupNoShow3 
                        and `student_group_id` not like $groupNoShow4 
                        ORDER by `dpr1`";
                    // echo $sql;
                    // die();
    $res=mysqli_query($conn,$sql); 
    //เพิ่มเข้าตาราง draw_money จากตาราง studing
    while($row=mysqli_fetch_assoc($res)){  
        $c++;
        $periad=$row['dpr4'];
        $subject_id=$row['subject_id'];
        $std_group=get_multi_group_name($sem,$t_id,$subject_id,$row['dpr3'],$row['dpr2']);
        $time=$row['dpr3'] ;
        if($f_day==$row['dpr2']){
            $d--;
        }
        $repeat = strtotime("+".$d." day",strtotime($day));
        $day2 = date('Y-m-d',$repeat); //==วันปัจจุบัน====
        $day1=$row['dpr2'];
        $dpr1=$row['dpr1'];
        
        // echo $day2;
        
        //===เก็บเข้า db============= 
        //===check ก่อนเก็บ สอนหลายกลุ่มเก็บบรรทัดเดียว=============  
        $chk=chk_samedata($sem,$t_id,$day1,$subject_id,$std_group,$time);  
        if (!$chk){
            $sql="INSERT INTO `draw_money`(`sem`, `t_id`, `day1`, `drp1`,`subject`, `std_group`, `time`, `period`) 
            VALUES ('$sem','$t_id','$day1','$dpr1','$subject_id','$std_group','$time','$periad')";
            // echo $sql;
            if (!mysqli_query($conn,$sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                // exit();
            }     
        }
        
           
        
        
        $f_day=$row['dpr2'];
        $d++; //เพิ่มวันที่     
            
    } 
}



function edit_drawmoney($day,$t_id,$sem,$c_day){
    global $conn;
    $sql = "SELECT * FROM `draw_money` 
                WHERE `t_id`='".$t_id."' and `sem`='".$sem."' and day1='$day'";
    // echo $sql."<br>";            
    $res=mysqli_query($conn,$sql);
    // $row=mysqli_fetch_assoc($res);
    if (mysqli_num_rows($res) == 0){
        $sql2="INSERT INTO `draw_money`(`sem`, `t_id`, `day1`,drp1) 
                    values ('$sem','$t_id','$day','$c_day')";
        // echo $sql2."<br>"; 
        $res2=mysqli_query($conn,$sql2);
    }
}