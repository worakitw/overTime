<?php 
session_start(); 
include 'header.php'; 
include 'connect.php';


if ($_POST['depart_id']){
  $_SESSION['depart_id']=$_POST['depart_id'];
}
if ($_POST['teacher_id']){
  $_SESSION['teacher_id']=$_POST['teacher_id'];
}

?>


<main role="main">

  <div class="container marketing">
  <br><br><br>
<!-- <?php echo $_SESSION['depart_id']; ?> -->
    <div class="row">
<!-- เลือกแผนกวิชา -->
      <div class="col-lg-6">
        <h4 class="card-title text-primary">เลือกแผนกวิชา</h4>
        <?php
        if ($_SESSION['depart_id']){
            ?>
            <div class="card bg-info text-white">
                <div class="card-body"><?php get_departName($_SESSION['depart_id'])?></div>
            </div>
            <?php
        }else{
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <!-- <label for="teacher_id">เลือกแผนกวิชา</label> -->
                    <select class="form-control form-control-sm select2" id="depart_id" name="depart_id">
                    <?php
                        $sql_d="select * from people_dep where people_depgroup_id=3";
                        $res_d=mysqli_query($conn,$sql_d);
                        while($row_d=mysqli_fetch_assoc($res_d)){
                        ?>    
                            <option value="<?php echo $row_d['people_dep_id']?>" 
                            <?php
                            if($_SESSION['depart_id']==$row_d['people_dep_id']) {echo "selected";}
                            ?>
                            > 
                            <?php echo $row_d['people_dep_name']?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" >Submit</button>
            </form>
            <?php
        }
        
        ?>
      </div><!-- /.col-lg-12 -->
<!-- เลือกครูผู้สอน -->
      <div class="col-lg-6">
        <h4 class="card-title text-primary">เลือกครูผู้สอน</h4>
        <form action="" method="post">
            <div class="form-group">
                <select class="form-control form-control-sm select2" id="teacher_id" name="teacher_id">
                <?php
                    $sql_t="SELECT p1.`people_id`,concat(p1.`people_name`,'  ',p1.`people_surname`) as name ";
                    $sql_t.=" FROM `people` p1";
                    $sql_t.=" INNER JOIN people_pro p2 ON p1.`people_id`=p2.`people_id` ";
                    $sql_t.=" WHERE p2.people_dep_id='".$_SESSION['depart_id']."'";
                    // var_dump($sql_t);exit();
                        $res_t=mysqli_query($conn,$sql_t);
                    while($row_t=mysqli_fetch_assoc($res_t)){
                    ?>    
                        <option value="<?php echo $row_t['people_id']?>" 
                        <?php
                          if($_SESSION['teacher_id']==$row_t['people_id']) {echo "selected";}
                        ?>
                        > 
                          <?php echo $row_t['name']?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" >Submit</button>
        </form>
        
        <?php
        echo $_SESSION['teacher_id'];
        ?>
        </div><!-- /.col-lg-12 -->
<!-- แสดงตาราง -->
        <div class="col-lg-12">
            <table width="80%" border="1" align="center">
                <tr align="center">
                <th>ว/ด/ป</th>
                <th>รหัสวิชา</th>
                <th>ชั้นเรียน</th>
                <th>เวลาที่สอน</th>
                <th>ชั่วโมงสอน</th>
                <th>หมายเหตุ</th>
                </tr>
                
                <?php
                $sql="SELECT * FROM `studing` WHERE `teacher_id`='".$_SESSION['teacher_id']."' 
                    and `subject_id` != '9999 9999' and `subject_id` != 'Home Room' ORDER by `dpr1`";
                // echo $sql;
                $res=mysqli_query($conn,$sql);
                $sum=0;     
                $c=0;       
                while($row=mysqli_fetch_assoc($res)){  
                    $c++;
                    $periad=substr($row['dpr1'],4,2)-substr($row['dpr1'],2,2);
                    if ($f_subject==$row['subject_id'] and $f_time== $row['dpr3']){
                        $c--;
                        ?> <script type="text/javascript"> 
                        document.getElementById("group<?php echo $c?>").innerHTML = "<?php get_groupName($f_student_group_id) .",". get_groupName($row['student_group_id'])?> "; 
                        </script> <?php
                        
                        continue;
                    }
                ?>
                <tr align="center">
                    <td><?php 
                        echo $f_day==$row['dpr2']?"":$row['dpr2'] ;
                            ?></td>
                    <td><?php echo $row['subject_id'] ?></td>
                    <td id='group<?php echo $c?>'><?php echo get_groupName($row['student_group_id']) ?></td>
                    <td><?php echo $row['dpr3'] ?></td>
                    <td><?php echo $periad ?></td>
                    <td></td>
                </tr>
                <?php
                    $f_day=$row['dpr2'];
                    $f_student_group_id=$row['student_group_id'];
                    $f_subject=$row['subject_id'];
                    $f_time= $row['dpr3'];
                    $sum+=$periad ;
                }
                
                ?>
                <tr>
                <td colspan="4" align="right">รวม &nbsp;&nbsp;&nbsp;</td>
                <td align="center"><?php echo $sum ?></td>
                </tr>
            </table><br>
        </div>  
        <div class="col-lg-12 " style="text-align:center;">
            <a href="print_week2.php" style="text-align: center;">print
            <button type="button" class="btn btn-primary" >print</button></a> 
        </div>   


    </div><!-- /.row -->
  </div><!-- /.container -->


  <!-- FOOTER -->
  <!-- <footer class="container">
    <p class="float-right"><a href="#">Back to top</a></p>
    <p>&copy; 2017-2018 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer> -->
</main>


<?php include 'footer.php'; 

function get_departName($id){
    global $conn;
    $sql="SELECT * FROM `people_dep` WHERE `people_dep_id`='".$id."'";
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    echo $row['people_dep_name'];
}
function get_groupName($id){
    global $conn;
    $sql="SELECT `student_group_short_name` FROM `student_group` WHERE `student_group_id`='".$id."'";
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    echo $row['student_group_short_name'];
}

?>
<script>


</script>
