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
?>
<!-- นำเข้า Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap3.min.css">
    
    <!-- นำเข้า Select2 CSS -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" /> -->
 
 

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
      if (isset($_POST['add_leave'])){
          $sem=$_POST['sem'];
          $day=$_POST['leave_day'];
          $name=$_POST['leave_name'];
          $t_id=$_SESSION['teacher_id'];
          $sql ="insert into teacher_leave value('','$sem','$t_id','$day','$name')";
          if (mysqli_query($conn, $sql)) {
              //echo "New record created successfully";
          } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
      }
      if(isset($_GET['act'])){
          $id=$_GET['id'];
          $sql="delete from teacher_leave where id='$id'";
          if (mysqli_query($conn, $sql)) {
              // echo "Record deleted successfully";
          } else {
              echo "Error deleting record: " . mysqli_error($conn);
          }
      }
    ?>
    <div class="row">

      <div class="col-lg-4 "><!-- left -->
        <h4 class="card-title text-primary">บันทึกรายการลา</h4>
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
          <form action="" method="post">
            <div class="form-group">
                <?php 
                  show_select_sem();
                ?>
            </div>
            <div class="form-group">
                <label for="leave_day">เลือกวันที่ :</label>
                <input type="date" class="form-control" name="leave_day" id="leave_day">
            </div>
            <div class="form-group">
                <label for="leave_name">รายการหยุด :</label>
                <select name="leave_name" class="form-control" id="leave_name" >
                  <!-- <option value="">--เลือกรายการ--</option> -->
                  <option value="ลากิจ">ลากิจ</option>
                  <option value="ลาป่วย">ลาป่วย</option>
                  <option value="ไปราชการ">ไปราชการ</option>
                  <option value="พักรักษาตัว">พักรักษาตัว</option>
                  <option value="เกษียณอายุราชการ">เกษียณอายุราชการ</option>
                  <option value="ลาออก">ลาออก</option>
                  <option value="ย้ายสถานศึกษา">ย้ายสถานศึกษา</option>
                </select>
            </div>
            <div class="text-center">
              <button type="submit" name="add_leave" class="btn btn-info "> บันทึก </button>
              &nbsp;&nbsp;&nbsp;
              <button name="clear" class="btn btn-warning"> เลือกครูใหม่ </button>
              
            </div>

              
          </form>
          <br> 
          


            
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
      <h3>ภาคเรียน <?php echo $sem ?></h3>
        <?php
        $teacher_id=$_SESSION['teacher_id'];
        $sql="select * from teacher_leave where sem='$sem' and teacher_id='$teacher_id' order by day";
        // echo $sql;
        $result = mysqli_query($conn, $sql);
        ?>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>ที่</th>
                    <th>วันที่</th>
                    <th>รายการ</th>
                    <th>ลบรายการ</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $c=0;
            while($row = mysqli_fetch_assoc($result)) {
                $c++;
            ?>
                <tr>
                    <td><?php echo $c ?></td>
                    <td><?php echo chDay($row['day']) ?></td>
                    <td><?php echo $row['leave_name'] ?></td>
                    <td><a href="leave.php?act=del&id=<?php echo $row['id'] ?>"><img src="img/delete.png" alt="" width=20></a></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
      </div><!-- /.col-lg-12 -->
   
    </div><!-- /.row -->
  </div><!-- /.container -->



</main>



<?php include 'footer.php'; ?>

    
<script>
  $(document).ready(function() {
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



  });
</script>
