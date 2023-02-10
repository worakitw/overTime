<?php 
session_start(); 
include 'header.php'; 
include 'connect.php';
include 'lib/function.php';

if(isset($_POST['select_teacher'])){
  $_SESSION["depart_id"]=$_POST['depart_id'];
  $_SESSION['teacher_id']=$_POST['teacher_id'];
}
$sem=$_SESSION['sem'];
$t_id=$_SESSION['teacher_id'];
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
        text-align: center
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
        <div class="col-lg-6 "><!-- right -->
                <form action="" method="post">
                    <div class="form-group">
                        <label for="sem">ภาคเรียน:</label>
                        <select class="form-control" id="sem" name="sem">
                            <option value="1/2562" <?php if($sem=="1/2562")echo "selected"?>> 1/2562</option>
                            <option value="2/2562" <?php if($sem=="2/2562")echo "selected"?>>2/2562</option>
                            <option value="1/2563" <?php if($sem=="1/2563")echo "selected"?>>1/2563</option>
                            <option value="1/2563" <?php if($sem=="2/2563")echo "selected"?>>2/2563</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start_week">เลือกสัปดาห์ :</label>
                        <select class="form-control form-control-sm select2-single" id="start_week" name="start_week">
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
                // ============บันทึกลง db ===================
                if (isset($_POST['show_subject_week'])){ 
                    $_SESSION['week_day']=$_POST['start_week'];
                    $week_day=explode(":",$_SESSION['week_day']);
                    $sql="SELECT * FROM `studing` WHERE `teacher_id`='".$_SESSION['teacher_id']."' 
                        and `subject_id` != '9999 9999' and `subject_id` != 'Home Room' ORDER by `dpr1`";
                    // echo $sql;
                    $res=mysqli_query($conn,$sql);    
                    $c=0;   
                    $day= $week_day['1']  ;
                    $d=0;
                    // echo get_multi_group_name("qqq");
                    // echo get_multi_group_name($sem,$t_id,"3901-2107","08.30-13.30");
                    while($row=mysqli_fetch_assoc($res)){  
                        $c++;
                        $periad=$row['dpr4'];
                        $subject_id=$row['subject_id'];
                        $std_group=get_multi_group_name($sem,$t_id,$subject_id,$row['dpr3']);
                        $time=$row['dpr3'] ;
                        if($f_day==$row['dpr2']){
                            $d--;
                        }
                        $repeat = strtotime("+".$d." day",strtotime($day));
                        $day2 = date('Y-m-d',$repeat); //==วันปัจจุบัน====
                        $day1=$row['dpr2'];
                        $drp1=$row['dpr1'];
                        

                        
                        //===เก็บเข้า db============= 
                        //===check ก่อนเก็บ=============  
                        
                        $chk=chk_samedata($sem,$t_id,$day1,$subject_id,$std_group,$time);  
                        if (!$chk){
                            $sql="INSERT INTO `draw_money`(`sem`, `t_id`, `day1`,drp1, `subject`, `std_group`, `time`, `period`) 
                            VALUES ('$sem','$t_id','$day1','$drp1','$subject_id','$std_group','$time','$periad')";
                            // $res=mysqli_query($conn,$sql);
                            if (!mysqli_query($conn,$sql)) {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }        
                        }  
                        
                        $f_day=$row['dpr2'];
                        $d++; //เพิ่มวันที่     
                            
                    } //======close while ========
                    ?>
  <!-- ===============แสดงรายการสอน รายสัปดาห์========================= -->
                    <div class="col-lg-12 ">
                    
                    <h4 style="margin-left:150px">สัปดาห์ที่ <?php echo $week_day['0'] ?></h4>

                    <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
                        <tr class="text-center">
                        <th>ว/ด/ป</th>
                        <th>รหัสวิชา</th>
                        <th>ชั้นเรียน</th>
                        <th>เวลาที่สอน</th>
                        <th>ชั่วโมงสอน</th>
                        <th>หมายเหตุ</th>
                        </tr> 
                        <?php
                        // $_SESSION['week_day']=$_POST['start_week'];
                        // $week_day=explode(":",$_SESSION['week_day']);
                        // $day= $week_day['1']  ;
                        $sql="SELECT * FROM `draw_money` WHERE `sem`='$sem' AND `t_id`='$t_id' order by drp1 ";
                        $res=mysqli_query($conn,$sql);
                        $sum=0; 
                        $d1=0;
                        

                        while($row=mysqli_fetch_assoc($res)){ 
                            // echo "f=".$f_day1."n=".$row['day1']."<br>";
                            if($f_day1==$row['day1']){
                                $d1--;
                            }
                            $repeat = strtotime("+".$d1." day",strtotime($day));
                            $day2 = date('Y-m-d',$repeat); //==วันปัจจุบัน====
                            $pe=$row['period'] ; //คาบสอน
                            $sum+=$pe ;

                            // =====ตรวจสอบวันหยุด=======
                            $chk_holiday=chk_holiday($sem,$day2);
                            $chk_leave=chk_leave($sem,$t_id,$day2);
                            // print_r($chk_holiday);
                            if (is_array($chk_holiday)){
                                $sum-=$pe ;
                                // echo "f_ho=".$f_holiday."day1=".$row['day1']."<br>";
                                if ($f_holiday==$row['day1']){
                                    $f_day1=$row['day1'] ;
                                    $d1++;
                                    continue;                                        
                                }
                                ?>
                                <tr class="text-center">
                                <td><?php 
                                        // if ($f_day1 == $row['day1']){
                                        //     echo "";
                                        // }else{
                                        //     echo .$row['day1'] ." &nbsp; ". $day2 ;
                                        //     // echo $row['day1'] ." &nbsp; ". chday($day2) ;
                                        // }
                                        echo $row['day1'] ." &nbsp; ". chday($day2) ;
                                        ?>
                                    </td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td><?php echo $chk_holiday[0] ?></td>
                                </tr>
                                <?php
                                $f_holiday=$row['day1'];
                            }
                            else if(is_array($chk_leave)){
                                $sum-=$pe ;
                                // echo "f_ho=".$f_holiday."day1=".$row['day1']."<br>";
                                if ($f_leave==$row['day1']){
                                    $f_day1=$row['day1'] ;
                                    $d1++;
                                    continue;                                        
                                }
                                ?>
                                <tr class="text-center">
                                <td><?php 
                                        // if ($f_day1 == $row['day1']){
                                        //     echo "";
                                        // }else{
                                        //     echo .$row['day1'] ." &nbsp; ". $day2 ;
                                        //     // echo $row['day1'] ." &nbsp; ". chday($day2) ;
                                        // }
                                        echo $row['day1'] ." &nbsp; ". chday($day2) ;
                                        ?>
                                    </td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td><?php echo $chk_leave[0] ?></td>
                                </tr>
                                <?php
                                $f_leave=$row['day1'];

                            }
                            else{
                                ?>
                                <tr class="text-center">
                                    <td><?php 
                                        if ($f_day1 == $row['day1']){
                                            echo "";
                                        }else{
                                            // echo $row['day1'] ." &nbsp; ". $day2 ;
                                            echo $row['day1'] ." &nbsp; ". chday($day2) ;
                                        }
                                        // echo $row['day1'] ." &nbsp; ". $day2 ;
                                        ?>
                                    </td>
                                    <td><?php echo $row['subject'] ?></td>
                                    <td><?php echo $row['std_group'] ?></td>
                                    <td><?php echo $row['time'] ?></td>
                                    <td><?php echo $pe ?></td>
                                    <td><?php echo "" ?></td>
                                </tr>
                                <?php
                                //================chk สอนแทน====================
                                if(){

                                }
                                
                            }
                            ?>

                            

                            <?php 
                        
                            $f_day1=$row['day1'] ;
                            $d1++;
                        }
                            ?>
                        <tr>
                        <td colspan="4" align="right">รวม &nbsp;&nbsp;&nbsp;</td>
                        <td align="center"><?php echo $sum ?></td><td></td>
                        </tr>     
                        </table>
                        
                    
                        <br>
                        <div class="text-center">
                            <form action="print_week.php" method="post">
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
                    


                <?php                  
                }
                ?>


  <!-- ---------end รายการสอน รายสัปดาห์--------- -->
                <?php
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
            <button type="submit" name="select_teacher" class="btn btn-primary" >Submit</button>
            </form>
            <?php
            }
            ?>
        </div><!-- /.col-left -->

      <div class="col-lg-6">
        
      </div><!-- /.col-lg-12 -->
   
    </div><!-- /.row -->
  </div><!-- /.container -->



</main>



<?php include 'footer.php'; ?>

    
<script>
$(document).ready(function() {
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
            $("#start_week").append("<option value='"+ value.id +"'> " + value.name + "</option>");
            // $("#stop_week").append("<option value='"+ value.id +"'> " + value.name + "</option>");
        });
      }
    });


});
</script>

<?php

