<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Select2</title>
    <?php
    include 'header.php'; 
    ?>
	<!-- นำเข้า Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    
	<!-- นำเข้า Select2 CSS -->
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" /> -->

  </head>
  <body>

	<div class="container">
	
			<div class="col-md-4">

					<div class="form-group">
						<!-- แสดงตัวเลือก จังหวัด -->
						<select class="form-control select2-single" id="province">
							<option id="province_list"> -- Select --</option>

						</select>
					</div>
			
			</div>
			
						
			<div class="col-md-4">

					<div class="form-group">
						<!-- แสดงตัวเลือก อำเภอ -->
						<select class="form-control select2-single" id="amphur">
							<option id="amphur_list"> -- Select --</option>
						</select>
					</div>
			
			</div>
			
			<div class="col-md-4">
			
					<div class="form-group">
						<!-- แสดงตัวเลือก ตำบล -->
						<select class="form-control select2-single" id="district">
							<option> -- Select --</option>
						</select>
					</div>

			</div>

	</div>
	
	
    <!-- นำเข้า Javascript jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
	
	<script>
			
			$(function(){
				
				//เรียกใช้งาน Select2
				$(".select2-single").select2();
				
				//ดึงข้อมูล province จากไฟล์ get_data.php
				$.ajax({
					url:"get_data.php",
					dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
					data:{show_province:'show_province'}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
					success:function(data){
						
						//วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
						$.each(data, function( index, value ) {
							//แทรก Elements ใน id province  ด้วยคำสั่ง append
							  $("#province").append("<option value='"+ value.id +"'> " + value.name + "</option>");
						});
					}
				});
				
				
				//แสดงข้อมูล อำเภอ  โดยใช้คำสั่ง change จะทำงานกรณีมีการเปลี่ยนแปลงที่ #province
				$("#province").change(function(){

					//กำหนดให้ ตัวแปร province มีค่าเท่ากับ ค่าของ #province ที่กำลังถูกเลือกในขณะนั้น
					var province_id = $(this).val();
					
					$.ajax({
						url:"get_data.php",
						dataType: "json",//กำหนดให้มีรูปแบบเป็น Json
						data:{province_id:province_id},//ส่งค่าตัวแปร province_id เพื่อดึงข้อมูล อำเภอ ที่มี province_id เท่ากับค่าที่ส่งไป
						success:function(data){
							
							//กำหนดให้ข้อมูลใน #amphur เป็นค่าว่าง
							$("#amphur").text("");
							
							//วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data  
							$.each(data, function( index, value ) {
								
								//แทรก Elements ข้อมูลที่ได้  ใน id amphur  ด้วยคำสั่ง append
								  $("#amphur").append("<option value='"+ value.id +"'> " + value.name + "</option>");
							});
						}
					});

				});
				
				//แสดงข้อมูลตำบล โดยใช้คำสั่ง change จะทำงานกรณีมีการเปลี่ยนแปลงที่  #amphur
				$("#amphur").change(function(){
					
					//กำหนดให้ ตัวแปร amphur_id มีค่าเท่ากับ ค่าของ  #amphur ที่กำลังถูกเลือกในขณะนั้น
					var amphur_id = $(this).val();
					
					$.ajax({
						url:"get_data.php",
						dataType: "json",//กำหนดให้มีรูปแบบเป็น Json
						data:{amphur_id:amphur_id},//ส่งค่าตัวแปร amphur_id เพื่อดึงข้อมูล ตำบล ที่มี amphur_id เท่ากับค่าที่ส่งไป
						success:function(data){
							
							  //กำหนดให้ข้อมูลใน #district เป็นค่าว่าง
							  $("#district").text("");
							  
							//วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data  
							$.each(data, function( index, value ) {
								
							  //แทรก Elements ข้อมูลที่ได้  ใน id district  ด้วยคำสั่ง append
							  $("#district").append("<option value='" + value.id + "'> " + value.name + "</option>");
							  
							});
						}
					});
					
				});
				
				//คำสั่ง change จะทำงานกรณีมีการเปลี่ยนแปลงที่  #district 
				$("#district").change(function(){
					
					//นำข้อมูลรายการ จังหวัด ที่เลือก มาใส่ไว้ในตัวแปร province
					var province = $("#province option:selected").text();
					
					//นำข้อมูลรายการ อำเภอ ที่เลือก มาใส่ไว้ในตัวแปร amphur
					var amphur = $("#amphur option:selected").text();
					
					//นำข้อมูลรายการ ตำบล ที่เลือก มาใส่ไว้ในตัวแปร district
					var district = $("#district option:selected").text();
					
					//ใช้คำสั่ง alert แสดงข้อมูลที่ได้
					alert("คุณได้เลือก :  จังหวัด : " + province + " อำเภอ : "+ amphur + "  ตำบล : " + district );
					
				});
				
				
			});
			
	</script>
	
	
  </body>
</html>