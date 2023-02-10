<?php
session_start(); 
header('Content-Type: text/html; charset=UTF-8');
// echo __DIR__."/../";
// include '../../connect.php';
include '../lib/function.php';
// header('Content-Type: application/json; charset=utf-8');

if(isset($_GET['show_time'])){
        
    //คำสั่ง SQL เลือก id และ  ชื่อจังหวัด
    $sql = "SELECT * FROM `time` order by list";
    
    //ประมวณผลคำสั่ง SQL
    $result = $conn->query($sql);

    //ตรวจสอบ จำนวนข้อมูลที่ได้ มีค่ามากกว่า  0 หรือไม่
    if ($result->num_rows > 0) {
        
        //วนลูปแสดงข้อมูลที่ได้ เก็บไว้ในตัวแปร $row
        while($row = $result->fetch_assoc()) {
            
            //เก็บข้อมูลที่ได้ไว้ในตัวแปร Array 
            $json_result[] = [
                'id'=>$row['id'],
                'name'=>$row['time'],
            ];
        }
        
        //ใช้ Function json_encode แปลงข้อมูลในตัวแปร $json_result ให้เป็นรูปแบบ Json
        echo json_encode($json_result);
        
    } 
}

//ตรวจสอบว่า มีค่า ตัวแปร $_GET['show_province'] เข้ามาหรือไม่      //แสดงรายชื่อจังหวัด
if(isset($_GET['show_depart'])){
      
    //คำสั่ง SQL เลือก id และ  ชื่อจังหวัด
    $sql = "select people_dep_id,people_dep_name 
    from people_dep where people_depgroup_id=3
    and people_dep_name like 'แผนก%'";
    
    // echo $sql;exit();  
    //ประมวณผลคำสั่ง SQL
    $result = $conn->query($sql);

    //ตรวจสอบ จำนวนข้อมูลที่ได้ มีค่ามากกว่า  0 หรือไม่
    if ($result->num_rows > 0) {
        
        //วนลูปแสดงข้อมูลที่ได้ เก็บไว้ในตัวแปร $row
        while($row = $result->fetch_assoc()) {
            
            //เก็บข้อมูลที่ได้ไว้ในตัวแปร Array 
            $json_result[] = [
                'id'=>$row['people_dep_id'],
                'name'=>$row['people_dep_name'],
            ];
        }
        
        //ใช้ Function json_encode แปลงข้อมูลในตัวแปร $json_result ให้เป็นรูปแบบ Json
        echo json_encode($json_result);
        
        
    } 
}


//ตรวจสอบว่า มีค่า ตัวแปร $_GET['province_id'] เข้ามาหรือไม่  //แสดงรายชืออำเภอ
if(isset($_GET['depart_id'])){

    //กำหนดให้ตัวแปร $province_id มีค่าเท่ากับ $_GET['province_id]
    $depart_id = $_GET['depart_id'];
    
    //คำสั่ง SQL เลือก AMPHUR_ID และ  AMPHUR_NAME ที่มี depart_ID เท่ากับ $depart_id
    $sql="SELECT DISTINCT p1.`people_id`,concat(p1.`people_name`,'  ',p1.`people_surname`) as name ";
    $sql.=" FROM `people` p1";
    $sql.=" INNER JOIN people_pro p2 ON p1.`people_id`=p2.`people_id` ";
    $sql.=" WHERE p2.people_dep_id='".$depart_id."' ";
    $sql.="  and `people_exit`=0 order by people_stagov_id";
    
    //ประมวณผลคำสั่ง SQL
    $result = $conn->query($sql);

    //ตรวจสอบ จำนวนข้อมูลที่ได้ มีค่ามากกว่า  0 หรือไม่
    if ($result->num_rows > 0) {
        
        //วนลูปนำข้อมูลที่ได้ เก็บไว้ในตัวแปร $row
        while($row = $result->fetch_assoc()) {
            
            //เก็บข้อมูลที่ได้ไว้ในตัวแปร Array 
            $json_result[] = [
                'id'=>$row['people_id'],
                'name'=>$row['name'],
            ];
        }
        
        //ใช้ Function json_encode แปลงข้อมูลในตัวแปร $json_result ให้เป็นรูปแบบ Json
        echo json_encode($json_result);
        
    } 
}

if(isset($_GET['show_depart2'])){
        
    //คำสั่ง SQL เลือก id และ  ชื่อจังหวัด
    $sql = "select people_dep_id,people_dep_name from people_dep where people_depgroup_id=3";
    
    //ประมวณผลคำสั่ง SQL
    $result = $conn->query($sql);

    //ตรวจสอบ จำนวนข้อมูลที่ได้ มีค่ามากกว่า  0 หรือไม่
    if ($result->num_rows > 0) {
        
        //วนลูปแสดงข้อมูลที่ได้ เก็บไว้ในตัวแปร $row
        while($row = $result->fetch_assoc()) {
            
            //เก็บข้อมูลที่ได้ไว้ในตัวแปร Array 
            $json_result[] = [
                'id'=>$row['people_dep_id'],
                'name'=>$row['people_dep_name'],
            ];
        }
        
        //ใช้ Function json_encode แปลงข้อมูลในตัวแปร $json_result ให้เป็นรูปแบบ Json
        echo json_encode($json_result);
        
    } 
}

if(isset($_GET['show_subject'])){
    $teacher_id=$_GET['show_subject'];
    $sem=$_SESSION['sem'];
    $sql = "SELECT `subject_id`,`subject_name` FROM `studing` where teacher_id='$teacher_id' and semes='$sem' group by `subject_id` ";
    // echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $json_result[] = [
                'id'=>$row['subject_id'],
                'name'=>$row['subject_id']." : ".$row['subject_name'],
            ];
        }
        echo json_encode($json_result);       
    } 
}

if(isset($_GET['show_group'])){
    $sem=$_SESSION['sem'];
    $subject_id=$_GET['show_group'];
    $sql = "SELECT s.`student_group_id`,g.group_name FROM `studing` s 
    INNER JOIN std_group g on s.`student_group_id`=g.group_id 
    WHERE s.`subject_id`='$subject_id' and semes='$sem'";
    //  var_dump($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $json_result[] = [
                'id'=>$row['student_group_id'],
                'name'=>$row['student_group_id']." : ".$row['group_name'],
            ];
        }
        echo json_encode($json_result);       
    } 
}

//show in db deaw_money ========สอนชดเชย=============
if(isset($_GET['show_group2'])){
    $sem=$_SESSION['sem'];
    $subject_id=$_GET['show_group2'];
    $teacher_id=$_GET['teacher_id'];
    $sql = "SELECT `std_group`  FROM `draw_money` WHERE `t_id` LIKE '$teacher_id' and `subject`='$subject_id' and sem='$sem'";
    //  var_dump($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $json_result[] = [
                'id'=>$row['std_group'],
                'name'=>$row['std_group'],
            ];
        }
        echo json_encode($json_result);       
    } 
}

if(isset($_GET['draw_dpr1'])){
    $sem=$_SESSION['sem'];
    $t_id=$_SESSION['teacher_id'];
    $subject_id=$_GET['draw_dpr1'];
    $sql = "SELECT `drp1` FROM `draw_money` WHERE `subject`='$subject_id' and `sem`='$sem' AND `t_id`='$t_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $json_result[] = [
                'id'=>$row['drp1'],
                'name'=>$row['drp1'],
            ];
        }
        echo json_encode($json_result);       
    } 
}

if(isset($_GET['draw_day1'])){
    $sem=$_SESSION['sem'];
    $t_id=$_SESSION['teacher_id'];
    $subject_id=$_GET['draw_day1'];
    $sql = "SELECT `day1` FROM `draw_money` WHERE `subject`='$subject_id' and `sem`='$sem' AND `t_id`='$t_id'";
    // var_dump($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $json_result[] = [
                'id'=>$row['day1'],
                'name'=>$row['day1'],
            ];
        }
        echo json_encode($json_result);       
    } 
}

// ========สอนชดเชย=============

if(isset($_GET['show_dpr1'])){
    $sem=$_SESSION['sem'];
    $subject_id=$_GET['show_dpr1'];
    $sql = "SELECT `dpr1`,`dpr2`,`dpr3`,dpr4 FROM `studing` WHERE `subject_id`='$subject_id' and semes='$sem' group by `dpr1`";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $json_result[] = [
                'id'=>$row['dpr1'].",".$row['dpr3'].",".$row['dpr4'],
                'name'=>$row['dpr1']." : ".$row['dpr2']." , ".$row['dpr3'],
            ];
        }
        echo json_encode($json_result);       
    } 
}

if(isset($_GET['show_week'])){
    $sem=$_GET['show_week'];
    $sql = "SELECT `week_no`,`day_start`,`day_stop` FROM `day_week` WHERE `sem`='$sem'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if (isset($_SESSION['week_day']) ){
                $week_day=explode(":",$_SESSION['week_day']); //[0] => 1 (number of week)
                $sel=$row['week_no']==$week_day[0]?'selected':'' ;
            }
            $json_result[] = [
                'id'=>$row['week_no'].":".$row['day_start'].":".$row['day_stop'],
                'name'=>"สป.ที่ ".$row['week_no']." - เริ่ม ".chDay($row['day_start'])." - ถึง ".chDay($row['day_stop']),
                'selected'=>$sel ,
            ];
        }
        echo json_encode($json_result);       
    } 
}
