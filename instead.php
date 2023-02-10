<?php 
session_start(); 
include 'header.php'; 
include 'connect.php';
include 'lib/function.php';

if(isset($_POST['select_teacher'])){
  $_SESSION["depart_id"]=$_POST['depart_id'];
  $_SESSION['teacher_id']=$_POST['teacher_id'];
  $_SESSION["depart_id2"]=$_POST['depart_id2'];
  $_SESSION['teacher_id2']=$_POST['teacher_id2'];
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
      if (isset($_POST['add_instead'])){
          // print_r($_POST);
          $sem=$_POST['sem'];
          $day=$_POST['instead_day'];
          $t_id=$_SESSION['teacher_id'];
          $subj_id=$_POST['subject_id'];
          $std_group=$_POST['group_id'];
          // $dpr=explode(',',$_POST['dpr1']) ;

          $dpr1=$_POST['day_id1']."-".ins0($_POST['time_id1']).ins0($_POST['time_id2']-1)."-0"; //วัน คาบ ห้อง 3-0102-0
          $dpr3=$_POST['time_id1']."-".$_POST['time_id2']; //เวลา
          $dpr4=$_POST['time_id2']-$_POST['time_id1'] ;//จำนวนคาบ
          $comment="แทน".get_teacherName2($_SESSION['teacher_id2']);

          $sql ="insert into instead value('','$sem','$day','$t_id','$subj_id','$std_group','$dpr1','$dpr3','$dpr4','$comment')";
          if (mysqli_query($conn, $sql)) {
              //echo "New record created successfully";
          } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
      }
      if(isset($_GET['act'])){
          $id=$_GET['id'];
          $sql="delete from instead where id='$id'";
          if (mysqli_query($conn, $sql)) {
              // echo "Record deleted successfully";
          } else {
              echo "Error deleting record: " . mysqli_error($conn);
          }
      }
    ?>
    <div class="row">

      <div class="col-lg-4 "><!-- left -->
        <h4 class="card-title text-primary">บันทึกรายการสอนแทน</h4>
        <?php
        if (isset($_SESSION['teacher_id'])){
          // echo $_SESSION['teacher_id'];

          ?>
          <!-- <div class="card bg-primary text-white">
            <div class="card-body"> <?php echo get_departName($_SESSION['depart_id']) ?></div>
          </div> -->
          <div class="card bg-primary text-white">
            <div class="card-body">ครูผู้สอน : <?php echo get_teacherName($_SESSION['teacher_id']) ?></div>
          </div>
          <br>
          <div class="card bg-success text-white">
            <div class="card-body">สอนแทนครู : <?php echo get_teacherName($_SESSION['teacher_id2']) ?></div>
          </div>
          <br>
          <form action="" method="post">
            <div class="form-group">
                <?php 
                  show_select_sem();
                ?>
            </div>
            <div class="form-group">
                <label for="instead_day">เลือกวันที่ :</label>
                <input type="date" class="form-control" name="instead_day" id="instead_day">
            </div>
            <div class="form-group">
                <label for="subject_id">วิชา :</label>
                <select class="form-control form-control-sm select2-single" id="subject_id" name="subject_id">
                  <option value="">-- กรุณาเลือกเลือกวิชา --</option>
                </select>
            </div>
            <div class="form-group">
                <label for="group_id">กลุ่มการเรียน :</label>
                <select class="form-control form-control-sm select2-single" id="group_id" name="group_id">
                  <option value="">-- กรุณาเลือกเลือกกลุ่มการเรียน --</option>
                </select>
            </div>
            <div class="form-group">
                  <label for="day_id1">วัน :</label>
                  <select class="form-control form-control-sm select2-single" id="day_id1" name="day_id1">
                    <option value="">-- เลือกวัน --</option>
                    <option value="1">วันจันทร์</option>
                    <option value="2">วันอังคาร</option>
                    <option value="3">วันพุธ</option>
                    <option value="4">วันพฤหัสบดี</option>
                    <option value="5">วันศุกร์</option>
                    <option value="6">วันเสาร์</option>
                    <option value="7">วันอาทิตย์</option>
                  </select>
              </div>
              <div class="form-group">
                  <label for="time_id1">เวลาเริ่มต้น :</label>
                  <select class="form-control  select2-single" id="time_id1" name="time_id1">
                    <option value="">-- เลือกเวลา --</option>
                  </select>
              </div>
            
              <div class="form-group">
                  <label for="time_id2">เวลาสิ้นสุด :</label>
                  <select class="form-control form-control-sm select2-single" id="time_id2" name="time_id2">
                    <option value="">-- เลือกเวลา --</option>
                  </select>
              </div>
            
            
            <div class="text-center">
              <button type="submit" name="add_instead" class="btn btn-info "> บันทึก </button>
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
            <div>
              <label class="bg-info"> &nbsp;&nbsp;&nbsp; สอนแทนครู &nbsp;&nbsp;&nbsp; </label>
            </div>
            <div class="form-group">
              <label for="depart_id2">เลือกแผนกวิชาที่สอนแทน</label>
              <select class="form-control form-control-sm select2-single" id="depart_id2" name="depart_id2">
                <option value="">-- กรุณาเลือกเลือกแผนกวิชา --</option>
              </select>
            </div>
            <div class="form-group">
              <label for="teacher2" >เลือกครูผู้สอนที่สอนแทน</label>
              <select class="form-control select2-single" id="teacher2" name="teacher_id2">
                <option id="teacher_list"> -- กรุณาเลือกเลือกครูผู้สอน -- </option>
              </select>
            </div>
          <button type="submit" name="select_teacher" class="btn btn-primary" >Submit</button>


        </form>
        <?php
        }
        ?>
      </div><!-- /.col-left -->

      <div class="col-lg-8">
      <h3>ภาคเรียน <?php echo $sem ?></h3>
        <?php
        $teacher_id=$_SESSION['teacher_id'];
        $sql="select * from instead where sem='$sem' and teacher_id='$teacher_id' order by day";
        //echo $sql;
        $result = mysqli_query($conn, $sql);
        ?>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>ที่</th>
                    <th>วันที่</th>
                    <th>วิชา</th>
                    <th>กลุ่ม</th>
                    <th>วัน/คาบ/ห้อง</th>
                    <th>จำนวนคาบ</th>
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
                    <td><?php echo $row['subj_id'] ?></td>
                    <td><?php echo $row['std_group'] ?></td>
                    <td><?php echo $row['day_p_r'] ?></td>
                    <td><?php echo $row['period'] ?></td>
                    <td><a href="instead.php?act=del&id=<?php echo $row['id'] ?>"><img src="img/delete.png" alt="" width=20></a></td>
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
      data:{show_time:'show_time'}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
      success:function(data){
        
        //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
        $.each(data, function( index, value ) {
          //แทรก Elements ใน id province  ด้วยคำสั่ง append
            $("#time_id1").append("<option value='"+ value.id +"'> คาบที่ " +value.id +": เวลา "+ value.name + " น.</option>");
            $("#time_id2").append("<option value='"+ value.id +"'> คาบที่ " +(value.id-1) + ": เวลา "+ value.name + " น.</option>");
        });
      }
    });

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

    $.ajax({
      url:"ajax/get_data.php",
      dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
      data:{show_depart2:'show_depart2'}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
      success:function(data){
        
        //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
        $.each(data, function( index, value ) {
          //แทรก Elements ใน id province  ด้วยคำสั่ง append
            $("#depart_id2").append("<option value='"+ value.id +"'> " + value.name + "</option>");
        });
      }
    });


    $("#depart_id2").change(function(){
					
					//กำหนดให้ ตัวแปร amphur_id มีค่าเท่ากับ ค่าของ  #amphur ที่กำลังถูกเลือกในขณะนั้น
					var depart_id = $(this).val();
					
					$.ajax({
						url:"ajax/get_data.php",
						dataType: "json",//กำหนดให้มีรูปแบบเป็น Json
						data:{depart_id:depart_id},//ส่งค่าตัวแปร amphur_id เพื่อดึงข้อมูล ตำบล ที่มี amphur_id เท่ากับค่าที่ส่งไป
						success:function(data){
							
							  //กำหนดให้ข้อมูลใน #district เป็นค่าว่าง
							  $("#teacher2").text("");
							  
							//วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data  
							$.each(data, function( index, value ) {
								
							  //แทรก Elements ข้อมูลที่ได้  ใน id teacher  ด้วยคำสั่ง append
							  $("#teacher2").append("<option value='" + value.id + "'> " + value.name + "</option>");
							  
							});
						}
					});	
		});

    var teacher_id="<?php echo $_SESSION['teacher_id2']?>" 
    $.ajax({
      url:"ajax/get_data.php",
      dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
      data:{show_subject:teacher_id}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
      success:function(data){
        
        //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
        $.each(data, function( index, value ) {
          //แทรก Elements ใน id province  ด้วยคำสั่ง append
            $("#subject_id").append("<option value='"+ value.id +"'> " + value.name + "</option>");
        });
      }
    });

    //เลือกวิชา แสดงชื่อกลุ่ม
    $("#subject_id").change(function(){
      var subject_id = $(this).val();
      $.ajax({
        url:"ajax/get_data.php",
        dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
        data:{show_group:subject_id}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
        success:function(data){
          
          //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
          $.each(data, function( index, value ) {
            //แทรก Elements ใน id province  ด้วยคำสั่ง append
              $("#group_id").append("<option value='"+ value.id +"'> " + value.name + "</option>");
          });
        }
      });
    
      // $.ajax({
      //   url:"ajax/get_data.php",
      //   dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
      //   data:{show_dpr1:subject_id}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
      //   success:function(data){
          
      //     //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
      //     $.each(data, function( index, value ) {
      //       //แทรก Elements ใน id province  ด้วยคำสั่ง append
      //         $("#dpr1").append("<option value='"+ value.id +"'> " + value.name + "</option>");
      //     });
      //   }
      // });
    });


    //=====date value today========
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;       
    $("#instead_day").attr("value", today);
    //==============================

  });//close ready
</script>
