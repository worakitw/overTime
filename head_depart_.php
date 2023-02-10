<?php 
session_start(); 
include 'header.php'; 
include 'connect.php';
include 'lib/function.php';
?>

<main role="main">

    <div class="container marketing">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="card-title text-primary">เลือกหัวหน้าแผนกวิชา</h4>
            </div>
            <div class="col-lg-4 ">
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
            </div>
            

        </div><!-- row -->
    </div><!-- container marketing -->
    
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
