<?php
include_once ('connect.php');
//แปลง 2011-03-08 to 8 มีนาคม 2554
function chDay($s){
	$d=explode("-",$s);
	//print_r($d);
	$arr_month=array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                     'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
	$y=$d[0]+543;
	//$da=ins0($d[0]);
    return del0($d[2])." ".$arr_month[$d[1]-1]." ".$y;
}
//แปลง 2011-03-08 to 8 เดือน มีนาคม พ.ศ. 2554
function chDay2($s){
	$d=explode("-",$s);
	//print_r($d);
	$arr_month=array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                     'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
	$y=$d[0]+543;
	//$da=ins0($d[0]);
   
    return del0($d[2])." เดือน ".$arr_month[$d[1]-1]." พ.ศ. ".$y;
}

//แปลง 2011-03-08 to 8/3/2554
function chDay3($s){
	$d=explode("-",$s);
	//print_r($d);
	$y=$d[0]+543;
    return del0($d[2])."/".del0($d[1])."/".$y;
}

//แปลง 2011-03-08 to 8 มี.ค. 2554
function chDay4($s){
	$d=explode("-",$s);
	//print_r($d);
	$arr_month=array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
                     'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
	$y=$d[0]+543;
	//$da=ins0($d[0]);
   
    return del0($d[2])." ".$arr_month[$d[1]-1]." ".$y;
}


//ตัดเลข 0 ถ้าไม่ถึง 10 //=== 08 >> 8
function del0($s){
    if ($s<10){
        $r=substr($s,1);
    }else{
        $r=$s;
    }
    return $r;
}

function ins0($s){
    if ($s<10){
        $r="0".$s;
    }else{
        $r=$s;
    }
    return $r;
}

//แปลง 2011-03-08 to มีนาคม
function getMonth($s){
	$d=explode("-",$s);
	//print_r($d);
	$arr_month=array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                     'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
	// $y=$d[0]+543;
	//$da=ins0($d[0]);
   
    return $arr_month[$d[1]-1];
}

//แปลง 2011-03-08 to มีนาคม พ.ศ. 2554
function getMonth2($s){
	$d=explode("-",$s);
	//print_r($d);
	$arr_month=array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                     'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
	$y=$d[0]+543;
	//$da=ins0($d[0]);
   
    return $arr_month[$d[1]-1]." พ.ศ. ".$y; ;
}

//แปลง 1-0102-00 to จันทร์
function getDay_dpr($s){
    $arr_day=array('จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์');
    if (is_array($s)){
        $d=explode("-",$s);
        //print_r($d); 
        $da=$arr_day[($d[0]-1)];
    }else{
        $da=$arr_day[($s-1)];
    }
   
    return $da;
}

function get_departName($id){
    global $conn;
    $sql="SELECT `people_dep_id`,`people_dep_name` FROM `people_dep` WHERE `people_dep_id`='$id' ";
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    return $row['people_dep_name'];
}

function get_subjectName($id){
    global $conn;
    $sql="SELECT `subject_name` FROM `studing` WHERE `subject_id`='$id' ";
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    return $row['subject_name'];
}

function get_head_depart($id){
    global $conn;
    $sql="SELECT p1.people_name,p1.people_surname FROM `people_pro` p2 INNER JOIN people p1 ON p1.`people_id`=p2.`people_id` 
    WHERE p2.`people_dep_id`='$id' and p2.`people_stagov_id`='5' and `people_exit`=0";
    // echo $sql;
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    return $row['people_name']." ".$row['people_surname'];
}
function get_teacherName($id){
    global $conn;
    $sql="SELECT `people_id`,concat(`people_name`,' ',`people_surname`)as name FROM `people` WHERE `people_id`='$id' ";
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    return $row['name'];
}

function get_teacherName2($id){
    global $conn;
    $sql="SELECT `people_id`,`people_name` FROM `people` WHERE `people_id`='$id' ";
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    return $row['people_name'];
}

function get_groupName($id){
    global $conn;
    // echo $id;
    $sql="SELECT `student_group_short_name` FROM `student_group` WHERE `student_group_id`='".$id."'";
    // echo $sql."<br>";
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    if ($row){
        return $row['student_group_short_name'];
    }else{
        return $id;
    }
}
    
//======ตรวจสอบ ปวส.==============
function chk_s($t_id,$sem){
    global $conn;
    $sql="SELECT substring(subject_id,1,1) as s FROM `studing` WHERE `semes`='$sem' and `teacher_id`='$t_id' and `subject_id` != '9999 9999' and `subject_id` != 'Home Room'";
    //  echo $sql;
    $res=mysqli_query($conn,$sql);
    while ($row=mysqli_fetch_assoc($res)){
        if ($row['s']=='3'){
            return true;
        }
    }
}
// //======ตรวจสอบ ปวช.==============
function chk_ch($t_id,$sem){
    global $conn;
    $sql="SELECT substring(subject_id,1,1) as s FROM `studing` WHERE `semes`='$sem' and `teacher_id`='$t_id' and `subject_id` != '9999 9999' and `subject_id` != 'Home Room'";
    // echo $sql;
    $res=mysqli_query($conn,$sql);
    while ($row=mysqli_fetch_assoc($res)){
        if ($row['s']=='2'){
            return true;
        }
    }
}

function chk_draw_money($sem,$t_id,$day2,$dayofweek){
    global $conn;
    $sql="SELECT * FROM `draw_money` 
            WHERE `sem`='$sem' 
            AND `t_id`='$t_id' 
            AND day1='$dayofweek'
            GROUP BY drp1
            ORDER BY `drp1`";
    // echo $sql. "<br>";
    $res=mysqli_query($conn,$sql);
    while ($row=mysqli_fetch_assoc($res)) {
        $data[]=$row;
    }
    if (is_array($data)){
        return $data;
    }else{
        return 0;
    }
}

function chk_holiday($sem,$day2){
    global $conn;
    if ($day2 !=''){
        $sql="SELECT * FROM `holiday` WHERE sem='$sem' and `day`='$day2'";
        // echo $sql. "<br>";
        $res=mysqli_query($conn,$sql);
        // $num=0;
        if (mysqli_num_rows($res) > 0) {
            while ($row=mysqli_fetch_assoc($res)) {
                $arr=array("name"=>$row['name'],"day"=>$row['day']);
            }
            if (is_array($arr)){
                return $arr;
            }else{
                return 0;
            }
        }
    }
}

//==ตรวจสอบวันลาหยุดตามวันที่============
function chk_leave($sem,$t_id,$day2){
    global $conn;
    if ($day2 !=''){ 
        $sql="SELECT * FROM `teacher_leave` WHERE `sem`='$sem' AND `teacher_id` ='$t_id' AND `day`='$day2' ";
        // echo $sql. "<br>";
        $res=mysqli_query($conn,$sql);
        if (mysqli_num_rows($res) > 0) {
            while ($row=mysqli_fetch_assoc($res)) {
                $name[]=$row['leave_name'];
            }
            if (is_array($name)){
                return $name;
            }else{
                return 0;
            }
        }
    }
}

//==ตรวจสอบรายวิชาสอนแทนตามช่วงเวลา============
function get_instead($sem,$t_id,$day1,$day2){
    global $conn;
    
    $sql="SELECT DISTINCT i.`subj_id`,s.subject_name
        FROM `instead` i
        LEFT JOIN studing s ON i.`subj_id`=s.subject_id and s.student_group_id=i.`std_group`
        WHERE `sem`='$sem' AND i.`teacher_id` ='$t_id' AND `day` between '$day1' and '$day2' ";
    // echo $sql. "<br>";
    $res=mysqli_query($conn,$sql);
    while ($row=mysqli_fetch_assoc($res)) {
        $subj_id=$row['subj_id'];
        $subject_name=$row['subject_name'];

        $data[]=array("subj_id"=>"$subj_id","subject_name"=> "$subject_name");
    }
    if (is_array($data)){
        return $data;
    }else{
        return 0;
    }
}

function chk_instead($sem,$t_id,$day2){
    global $conn;
    if ($day2 !=''){ 
        $sql="SELECT * FROM `instead` WHERE `sem`='$sem' and `teacher_id`='$t_id' and `day`='$day2' ";
        // echo $sql. "<br>";
        $res=mysqli_query($conn,$sql);
        if (mysqli_num_rows($res) > 0) {
            while ($row=mysqli_fetch_assoc($res)) {
                $subj_id= $row['subj_id'];
                $std_group= get_groupName($row['std_group']);
                $dpr1=$row['day_p_r'];
                $time=$row['time'];
                $period= $row['period'];
                $comment= $row['comment'];

                $data[]=array("subj_id"=>"$subj_id","std_group"=>"$std_group","dpr1"=>"$dpr1","time"=>"$time","period"=>"$period","comment"=>"$comment");
            }
        }
        // print_r($data);exit();
        if (is_array($data)){
            return $data;
        }else{
            return 0;
        }
    }
}

// ตรวจสอบมีข้อมูลสอนชดเชยหรือไม่
function chk_compensate($sem,$t_id,$day2,$drp1){
    global $conn;
    $sql="SELECT * FROM `compensate` 
          WHERE `sem`='$sem' and `t_id`='$t_id' and `day`='$day2' and `drp1`='$drp1'";
    // echo $sql. "<br>";
    $res=mysqli_query($conn,$sql);
    if (mysqli_num_rows($res) > 0) {
        $row=mysqli_fetch_assoc($res);
        $comment= $row['comment'];
    }
    if ($comment !=''){
        return $comment;
    }else{
        return '';
    }
}



function get_multi_group_name($sem,$t_id,$subj_id,$drp3,$drp2){
    global $conn;
    $sql="SELECT `student_group_id` 
    FROM `studing` WHERE `semes`='$sem' and `teacher_id`='$t_id' 
    and `subject_id`='$subj_id' and `dpr3`='$drp3' and `dpr2`='$drp2' order BY `student_group_id`";
    //  echo $sql;
    $res=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($res) ;
    $c=0;
    $g='';
    while ($row=mysqli_fetch_assoc($res)){
        $c++;
        $g.=get_groupName($row['student_group_id']);
        if ($c!=$num)
            $g.= "-";
    }
    return $g;
}

//ตรวจสอบก่อนทำการ insert draw_money
function chk_samedata($sem,$t_id,$day1,$subject,$std_group,$time){
    global $conn;
    $sql="SELECT * FROM `draw_money` WHERE `sem`='$sem' 
        AND `t_id`='$t_id' AND `day1`='$day1' AND `subject`='$subject' 
        AND`std_group`='$std_group' AND`time`='$time'";
    // echo "chk_samedata=".$sql."<br>";
    $res=mysqli_query($conn,$sql);
    // $row=mysqli_fetch_assoc($res);
    // echo $row['id'];
    $num=mysqli_num_rows($res) ;
    // echo "num=".$num;
    if ($num>0){
        // echo "1"."<br>";
        return true;
    }else{
        return false;
    }
}

//ตรวจสอบจำนวนข้อมูลเดิม ก่อนทำการบันทึกใหม่
function count_draw_money($sem,$t_id){
    global $conn;
    $sql="SELECT * FROM `draw_money` WHERE `sem`='$sem' AND `t_id`='$t_id'";
    // echo $sql;
    $res=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($res) ;
    if ($num>0){
        return $num;
    }
}



//แปลงตัวเลขเป็นตัวอักษรเงินบาท
function Convert($amount_number){
    $amount_number = number_format($amount_number, 2, ".","");
    $pt = strpos($amount_number , ".");
    $number = $fraction = "";
    if ($pt === false) 
        $number = $amount_number;
    else
    {
        $number = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }
    
    $ret = "";
    $baht = ReadNumber ($number);
    if ($baht != "")
        $ret .= $baht . "บาท";
    
    $satang = ReadNumber($fraction);
    if ($satang != "")
        $ret .=  $satang . "สตางค์";
    else 
        $ret .= "ถ้วน";
    return $ret;
}

function ReadNumber($number){
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number > 1000000)
    {
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }
    
    $divider = 100000;
    $pos = 0;
    while($number > 0)
    {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : 
            ((($divider == 10) && ($d == 1)) ? "" :
            ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}

//  1  to  8.30
function get_time($id){
    global $conn;
    $sql="SELECT * FROM `time` WHERE `id`='$id' ";
    // echo $sql;
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    return $row['time'];
}

//  1-0102-00  to  08.30-0930
function get_time_dpr($dpr1){
    // global $conn;
    $t=explode("-",$dpr1);
    // print_r($t);
    $t1=get_time(del0(substr($t['1'],0,2)));
    $t2=get_time(del0(substr($t['1'],2,2))+1);
    return $t1."-".$t2;
    
}

function show_select_sem(){
    $sem=$_SESSION['sem'];
    ?>
    <label for="sem">ภาคเรียน:</label>
    <select class="form-control" id="sem" name="sem">
        <option value="1/2566" <?php if($sem=="1/2566")echo "selected"?>>1/2566</option>
        <option value="2/2566" <?php if($sem=="2/2566")echo "selected"?>>2/2566</option>
        <option value="3/2566" <?php if($sem=="3/2566")echo "selected"?>>S/2566</option>
        <option value="1/2565" <?php if($sem=="1/2565")echo "selected"?>>1/2565</option>
        <option value="2/2565" <?php if($sem=="2/2565")echo "selected"?>>2/2565</option>
        <option value="3/2565" <?php if($sem=="3/2565")echo "selected"?>>S/2565</option>
    </select>
    <?php
}