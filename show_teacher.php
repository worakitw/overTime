<?php 
include 'header.php'; 
// include_once 'connect.php';
include 'lib/function.php';

if(isset($_POST['select_teacher'])){
  $_SESSION["depart_id"]=$_POST['depart_id'];
  $_SESSION['teacher_id']=$_POST['teacher_id'];
  $_SESSION['position']=$_POST['position'];

  
}
if (isset($_SESSION['teacher_id'])){
    $t_id=$_SESSION['teacher_id'];
}

$sem=$_SESSION['sem'];

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

        <div class="col-md-6">
                
            <!-- เลือกแผนกวิชา/ครู -->
            <form action="" method="post">
                <div class="form-group">
                    <label for="depart_id">เลือกแผนกวิชา</label>
                    <select class="form-control form-control-sm select2-single" id="depart_id" name="depart_id">
                        <option value="">-- กรุณาเลือกเลือกแผนกวิชา --</option>
                    </select>
                </div>
                <!-- <div class="form-group">
                    <label for="teacher" >เลือกครูผู้สอน</label>
                    <select class="form-control select2-single" id="teacher" name="teacher_id">
                        <option id="teacher_list"> -- กรุณาเลือกเลือกครูผู้สอน -- </option>
                    </select>
                </div> -->
                <button name="ok" class="btn btn-warning"> แสดงข้อมูล </button>
                
                
            </form>
            <?php
            if (isset($_POST['ok'])){
                $depart_id=$_POST['depart_id'];
                $sql="SELECT DISTINCT p1.`people_id`,
                    concat(p1.`people_name`,' ',p1.`people_surname`) as name ,
                    p3.people_stagov_name
                    FROM `people` p1 
                    INNER JOIN people_pro p2 ON p1.`people_id`=p2.`people_id` 
                    INNER JOIN people_stagov p3 ON p2.people_stagov_id=p3.people_stagov_id
                    WHERE p2.people_dep_id='$depart_id' 
                    and `people_exit`=0 
                    order by p2.people_stagov_id";

                $result=mysqli_query($conn,$sql);
                //$row=mysqli_fetch_array($result);

                ?>
                <h2><?php echo get_departName($depart_id) ?></h2>
                <table  class="table">
                    <tr id="teacher">
                        <th>ที่</th>
                        <th>id</th>
                        <th>name</th>
                        <th>ตำแหน่ง</th>
                    </tr>
                <?php
                $c=0;
                while ($row=mysqli_fetch_array($result)){
                    $c++;
                    ?>
                    <tr>
                        <td class="l"><?php echo $c ?></td>
                        <td class="l"><?php echo $row['people_id']; ?></td>
                        <td class="l"><?php echo $row['name']; ?></td>
                        <td class="l"><?php echo $row['people_stagov_name']; ?></td>
                    </tr>
                    <?php
                }
                
            }


            ?>

            
                
            </table>
           
        </div><!-- /.col-left -->

      <div class="col-lg-6">
        
      </div><!-- /.col-lg-12 -->
   
    </div><!-- /.row -->
  </div><!-- /.container -->



</main>



<?php include 'footer.php'; ?>

    
<script>
$(document).ready(function() {
    // alert("aaa");
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

    // $("#depart_id").change(function(){
					
    //     //กำหนดให้ ตัวแปร amphur_id มีค่าเท่ากับ ค่าของ  #amphur ที่กำลังถูกเลือกในขณะนั้น
    //     var depart_id = $(this).val();
        
    //     $.ajax({
    //         url:"ajax/get_data.php",
    //         dataType: "json",//กำหนดให้มีรูปแบบเป็น Json
    //         data:{depart_id:depart_id},//ส่งค่าตัวแปร amphur_id เพื่อดึงข้อมูล ตำบล ที่มี amphur_id เท่ากับค่าที่ส่งไป
    //         success:function(data){
                
    //             //กำหนดให้ข้อมูลใน #district เป็นค่าว่าง
    //             $("#teacher").text("");
    //             var c=0;
    //             //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data  
    //             $.each(data, function( index, value ) {
    //                 c++;
    //                 //แทรก Elements ข้อมูลที่ได้  ใน id teacher  ด้วยคำสั่ง append
    //                 $("#teacher").append("<tr><td>"+c+"</td><td>"+ value.id +"</td><td>" + value.name + "</tr>");
                    
    //             });
    //         }
    //     });				
    // });



    


    

    


});
</script>

<?php

