<?php 
include 'header.php'; 
// include_once 'connect.php';
include 'lib/function.php';

if (isset($_POST['depart_id'])){
    $depart_id=$_POST['depart_id'];
    $_SESSION['depart_id']=$depart_id;
}else{
    $depart_id=$_SESSION['depart_id'];
}

if (isset($_POST['save'])){
    // print_r($_POST);
    save_teacher($_POST);
}

if (isset($_POST['edit'])){
    // print_r($_POST);
    edit_teacher($_POST);
}
?>
<style>
    input {
        width: 10%;
        text-align:center;
    }
</style>
<div class="container marketing">
    <div class="row">
        <div class="col-lg-4 "><!-- left -->
            <!-- เลือกแผนกวิชา/ครู -->
            <form action="" method="post">
                <div class="form-group">
                    <label for="depart_id">เลือกแผนกวิชา</label>
                    <select class="form-control form-control-sm select2-single" id="depart_id" name="depart_id">
                        <option value="">-- กรุณาเลือกเลือกแผนกวิชา --</option>
                    </select>
                </div>
                <button type="submit" name="select_teacher" class="btn btn-primary" >Submit</button>
            </form>
        </div>
        <div class="col-lg-8 ">
            <?php
            $sql="SELECT pe.people_id,concat(`people_name`,'  ', `people_surname`) as name , tp.`piority` FROM `people` pe
            left JOIN `teacher_piority` tp on tp.`teacher_id`=pe.`people_id`
            WHERE pe.`people_id` in (SELECT `people_id` FROM `people_pro` WHERE `people_dep_id`='$depart_id')
            order by tp.`piority` ASC";
            // echo $sql;
            $res=mysqli_query($conn,$sql);
            if (mysqli_num_rows($res) > 0) {
                ?>
                <h2>เรียงลำดับจากน้อยไปมาก</h2>
                <table class="table">
                    <tr>
                        <th>ชื่อ</th>
                        <th>ลำดับ</th>
                    </tr>
                <form action="" method="post">
                <?php
                $c=0;
                while($row = mysqli_fetch_assoc($res)) {
                    ?>
                    <tr>
                        <td><input type="hidden" name="tacher_id[<?php echo $c?>]" value="<?php echo $row['people_id'] ?>">
                            <?php echo $row['name'] ?></td>
                        <td><input type="text" name="pio[<?php echo $c?>]" value="<?php echo $row['piority']?>"></td>
                    </tr>
                    <?php
                    $c++;    
                }
                ?>
                <tr>
                    <td colspan=2>
                        <button type="submit" name="edit">บันทึก</button>
                    </td>
                </tr>
                    
                </form>
                </table>
                <?php

            }
            // ครั้งแรกไม่มีข้อมูล
            else{
                $sql="SELECT people_id,concat(`people_name`,'  ', `people_surname`) as name FROM `people` WHERE `people_id` in (SELECT `people_id` FROM `people_pro` WHERE `people_dep_id`='$depart_id')";
                $res=mysqli_query($conn,$sql);
                
                ?>
                <h2>เรียงลำดับจากน้อยไปมาก</h2>
                <table class="table">
                    <tr>
                        <th>ชื่อ</th>
                        <th>ลำดับ</th>
                    </tr>
                <form action="" method="post">
                <?php
                $c=0;
                while($row = mysqli_fetch_assoc($res)) {
                    ?>
                    <tr>
                        <td><input type="hidden" name="tacher_id[<?php echo $c?>]" value="<?php echo $row['people_id'] ?>">
                            <?php echo $row['name'] ?></td>
                        <td><input type="text" name="pio[<?php echo $c?>]"></td>
                    </tr>
                    <?php
                    $c++;    
                }
                ?>
                <tr>
                    <td colspan=2>
                        <button type="submit" name="save">บันทึก</button>
                    </td>
                </tr>
                    
                </form>
                </table>
                <?php

            }
            ?>

        </div>

    </div>
    
</div>


<?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {
        // alert("aaa");
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
    });
</script>

<?php
function save_teacher($data){
    global $conn;
    if (is_array($data)){
        // print_r($data);
        for($i=0;$i<count($data['tacher_id']);$i++){
            $t_id= $data['tacher_id'][$i];
            $pio=$data['pio'][$i];
            $sql = "INSERT INTO `teacher_piority` 
            VALUES ('$t_id','$pio')";
            // echo $sql;
            if (mysqli_query($conn, $sql)) {
                echo "insert success <br>".$t_id;
            }
        }
    }
    
}
function edit_teacher($data){
    global $conn;
    if (is_array($data)){
        // echo "<pre>";
        // print_r($data);
        for($i=0;$i<count($data['tacher_id']);$i++){
            $t_id= $data['tacher_id'][$i];
            $pio=$data['pio'][$i];
            $chk=checkNewTeacher($t_id);
            // echo $chk."<br>";
            if ($chk==""){
                $sql1 = "INSERT INTO `teacher_piority` 
                VALUES ('$t_id','$pio')";
                // echo $sql;
                if (mysqli_query($conn, $sql1)) {
                    // echo "insert new teacher success <br>".$t_id;
                }
            }
            $sql = "UPDATE `teacher_piority` SET `piority`='$pio' WHERE `teacher_id`='$t_id'";
            // echo $sql;
            if (mysqli_query($conn, $sql)) {
                // echo "update success <br>".$t_id;
            }
        }
    }
    
}

function checkNewTeacher($t_id){
    global $conn;
    $sql="SELECT * FROM `teacher_piority` WHERE `teacher_id`='$t_id'";
    $res=mysqli_query($conn,$sql);
    // echo $sql."<br>";
    if (mysqli_num_rows($res)>0){
        return true;
    }
    else{
        return false;
    }
}
            