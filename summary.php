<?php 
include 'header.php'; 
include 'connect.php';
include 'lib/function.php';

$sem=$_SESSION['sem'];
if(isset($_POST['select_teacher'])){
  $_SESSION["depart_id"]=$_POST['depart_id'];
  $_SESSION['teacher_id']=$_POST['teacher_id'];
  $_SESSION['position']=$_POST['position'];
}
$count_input=0;
?>
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
        width:100%;
        text-align: center
    }
    .center {
      margin: 0;
      position: absolute;
      left: 50%;
      -ms-transform: translate(-50%, -50%);
      /* transform: translate(0, 40); */
    }
    hr {
      width:80%;
      border: 2px solid green;
      border-radius: 5px;
    }
    .right{
      text-align: right;
    }
    .big{
      font-size: 16px;
      font-weight: bold;
    }
   


 </style>

<main role="main">
  <!-- <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
        <div class="container">
          <div class="carousel-caption text-left">
            <h1>Example headline.</h1>
            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
        <div class="container">
          <div class="carousel-caption">
            <h1>Another example headline.</h1>
            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
        <div class="container">
          <div class="carousel-caption text-right">
            <h1>One more for good measure.</h1>
            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div> -->


  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

  <div class="container marketing">
    <!-- <br><br><br> -->
    <!-- Three columns of text below the carousel -->
    <div class="row">
      <div class="col-lg-12">
        <h4 class="card-title text-primary">สรุปการสอนรายสัปดาห์</h4>
      </div>
       
            
      <?php
      if(isset($_POST['new_teacher'])){
        // echo "newteacher";
        unset($_SESSION["depart_id"]);
        unset($_SESSION['teacher_id']);
        unset($_SESSION['position']);
      }
      //===========แสดง 2.2 เลือกสัปดาห์แล้ว แสดงตาราง====================
      if(isset($_POST['show_subject'])){
        // print_r($_SESSION);
        ?>
         <div class="row col-lg-12">
          <div class="col-lg-6">
            <div class="card bg-secondary text-white">
                <div class="card-body"> <?php echo get_departName($_SESSION['depart_id']) ?></div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card bg-info text-white">
                <div class="card-body">ครูผู้สอน <?php echo get_teacherName($_SESSION['teacher_id']) ?>
                &nbsp;&nbsp;&nbsp;&nbsp; ตำแหน่ง <?php echo $_SESSION['position'] ?></div>
            </div>
          </div>
        </div> 
        <div class="col-lg-12 text-center"> 
          <h3></h3>
          <form action="" method="post">
                  <button class="btn btn-warning" type="submit" name="new_teacher">เลือกครูผู้สอนใหม่</button>
          </form>
        </div>

        <hr>

        <!-- <div >
          <div class="card bg-primary text-white">
                <div class="card-body"> <?php echo get_departName($_SESSION['depart_id']) ?></div>
          </div>
          <div class="card bg-primary text-white">
              <div class="card-body">ครูผู้สอน <?php echo get_teacherName($_SESSION['teacher_id']) ?>
              </div>
          </div>
          <form action="" method="post">
                  <button type="submit" name="new_teacher">เลือกครูผู้สอนใหม่</button>
          </form>
        </div> -->
            <br> 
        <div class="col-lg-12 text-center">
          <br>
          <form action="print_summary.php" name='period' method="post" target="_blank">
            <table  cellpadding="0" cellspacing="0">
              <tr align="center">
                <th>สป.ที่</th>
                <th>ระยะเวลาที่สอน</th>
                <th>รหัสวิชา</th>
                <th>ชื่อวิชา</th>
                <th width="40px">รวม<br>ชม.<br>ในเวลา</th>
                <th width="40px">รวม<br>ชม.<br>นอกเวลา</th>
              </tr>
                
              
              
              <?php
              // print_r($_POST);
              // echo "show_subject";
              $t_id=$_SESSION['teacher_id'] ;
              
              $sql="SELECT  d.`subject`,s.subject_name 
              -- ,sum(d.period)
                FROM `draw_money` d
                LEFT JOIN studing s on d.`subject`=s.subject_id and d.`t_id`=s.teacher_id
                WHERE `t_id`='$t_id' 
                AND `sem`='$sem' 
                group by d.`subject` 
                order by `subject`";
              // echo $sql;
              $result = mysqli_query($conn, $sql);
              $c=0;
              $d=1;
              $numOfRow=mysqli_num_rows ( $result );
              
              while($row = mysqli_fetch_assoc($result)) {
                $c++;
                $start=explode(":",$_POST['start_week']);
                $end=explode(":",$_POST['end_week']);
                

                if ($c==1){
                 
                  $subject.="('".$row['subject']."',";
                  ?>
                  <tr>
                    <td><?php echo $start[0]." - ".$end[0] ?></td>
                    <td><?php echo chDay4($start[1])." - ".chDay4($end[2]) ?></td>
                    <input type="hidden" name="d_start" value="<?php echo $start[1] ?>">
                    <input type="hidden" name="d_end" value="<?php echo $end[2] ?>">
                    <input type="hidden" name="w_start" value="<?php echo $start[0] ?>">
                    <input type="hidden" name="w_end" value="<?php echo $end[0] ?>">
                  <?php
                }else{
                  // echo $c."---".$numOfRow."<br>";
                  if ($c==$numOfRow){
                    $subject.="'".$row['subject']."')";
                  }
                  else{
                    $subject.="'".$row['subject']."',";
                  }
                  
                  ?>
                  <tr>
                    <td></td>
                    <td></td>
                  <?php
                }
                ?>
                    <td><?php echo $row['subject']?></td>
                    <td align="left">&nbsp;&nbsp;&nbsp;<?php echo $row['subject_name']?></td>
                    <td><input id="<?php echo $d++ ?>" onkeydown="return nextbox(event, '<?php echo ($d) ?>');" class="inputs" type="text" name="<?php echo $row['subject'].':in'?>" ></td>
                    <td><input id="<?php echo $d++ ?>" onkeydown="return nextbox(event, '<?php echo ($d) ?>');" class="inputs" type="text" name="<?php echo $row['subject'].':out'?>" ></td>
                <?php
                
              }
              //  echo $sem,"-",$t_id,"-",$start[1],"-",$end[2];
              // echo($subject);
              $data=get_instead2($sem,$t_id,$start[1],$end[2],$subject);
              if (is_array($data)){
                // print_r($data);
                foreach ($data as $k=>$v){
                  // print_r($v);
                    ?>
                    <tr>
                      <td></td>
                      <td></td>
                      <td><?php echo $v['subj_id']?></td>
                      <td align="left">&nbsp;&nbsp;&nbsp;<?php echo $v['subject_name']?></td>
                      <td><input id="<?php echo $d++ ?>" onkeydown="return nextbox(event, '<?php echo  ($d) ?>');" class="inputs" type="text" name="<?php echo $v['subj_id'].':in'?>" ></td>
                      <td><input id="<?php echo $d++ ?>" onkeydown="return nextbox(event, '<?php echo ($d) ?>');" class="inputs" type="text" name="<?php echo $v['subj_id'].':out'?>" ></td>
                    </tr>
                    <?php
                } 
              }
              $count_input=$d-1;
              ?>
              <tr>
                <td colspan="4" align="right">รวมจำนวนคาบที่สอน &nbsp; </td>
                <td><input id="sum_in" name="sum:in" ></td>
                <td><input id="sum_out" name="sum:out" ></td>
              </tr>
              <tr>
                <td colspan="6" style="background-color:gray">&nbsp;</td>

              </tr>
              <tr>
                <td colspan="4" class="right big">&nbsp;คาบเบิกระดับ ปวช.</td>
                <td colspan="2" class="big"><input type="text" name="sum_ch" id="sum_ch" require></td>
              </tr>
              <tr>
              <td colspan="4" class="right big">&nbsp;คาบเบิกระดับ ปวส. </td>
              <td colspan="2" class="big"><input type="text" name="sum_s" id="sum_s"  require></td>
              </tr>
            </table>
            
            <br>
            
            <br>
            <button class="btn btn-info" type="submit"> preview </button>
            <h2></h2>

            
            
          </form>

        </div>  
        <?php
        

      }
      //===========แสดง 2.1 เลือกครูแล้ว เลือกสัปดาห์ที่เบิก====================
      else if (isset($_SESSION['teacher_id']) && $_SESSION['depart_id'] != '' && $_SESSION['position'] != '' ){
          // echo $_SESSION['teacher_id'];

          ?> 
        <div class="col-lg-6">
          <div class="card bg-primary text-white">
                <div class="card-body"> <?php echo get_departName($_SESSION['depart_id']) ?></div>
            </div>
            <div class="card bg-primary text-white">
                <div class="card-body">ครูผู้สอน <?php echo get_teacherName($_SESSION['teacher_id']) ?>
                ตำแหน่ง <?php echo $_SESSION['position'] ?>
                </div>
            </div>
            <form action="" method="post">
                   <button type="submit" name="new_teacher">เลือกครูผู้สอนใหม่</button>
            </form>
            <br> 
            <!-- เลือกสัปดาห์ที่ต้องการสรุป -->
            <form action="" method="post">
              <div class="form-group">
                <label for="start_week">เลือกสัปดาห์เริ่มต้น :</label>
                <select class="form-control form-control-sm select2-single" id="start_week" name="start_week" >
                    <option value="">-- กรุณาเลือกสัปดาห์ --</option>
                    <?php
                    // if (isset($_SESSION['week_day'])){
                    //     $week_day=explode(":",$_SESSION['week_day']);
                        
                    //     $name="สป.ที่ ".$week_day[0]." - เริ่ม ".chDay($week_day[1])." - ถึง ".chDay($week_day[2]);
                    //     // echo "<option value='".$_SESSION['week_day']."' selected>".$name."</option>";
                    // }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="end_week">ถึงสัปดาห์สุดท้าย :</label>
                <select class="form-control form-control-sm select2-single" id="end_week" name="end_week" >
                    <option value="">-- กรุณาเลือกสัปดาห์ --</option>
                    <?php
                    // if (isset($_SESSION['week_day'])){
                    //     $week_day=explode(":",$_SESSION['week_day']);
                        
                    //     $name="สป.ที่ ".$week_day[0]." - เริ่ม ".chDay($week_day[1])." - ถึง ".chDay($week_day[2]);
                    //     // echo "<option value='".$_SESSION['week_day']."' selected>".$name."</option>";
                    // }
                    ?>
                </select>
              </div>
              <button type="submit" name="show_subject">แสดงรายวิชา</button>
            </form>
          </div>
      <?php
      }
      
      //============แสดงครั้งแรก เลือกครู=================
      else{
      ?> 
        <!-- เลือกครูผู้สอน -->
        <div class="col-lg-6">
          <form action="" method="post" >
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
            <div class="form-group">
              <label for="position" >เลือกตำแหน่ง</label>
              <select class="form-control select2-single" id="position" name="position" require>
                  <option value=''> -- กรุณาเลือกเลือกตำแหน่ง -- </option>
                  <option value="ครูผู้ช่วย">ครูผู้ช่วย</option>
                  <option value="ครู">ครู</option>
                  <option value="ครูชำนาญการ">ครูชำนาญการ</option>
                  <option value="ครูชำนาญการพิเศษ">ครูชำนาญการพิเศษ</option>
                  <option value="พนักงานราชการ (ครู)">พนักงานราชการ (ครู)</option>
                  <option value="ครูพิเศษสอน">ครูพิเศษสอน</option>
              </select>
            </div>
            <button type="submit" name="select_teacher" class="btn btn-primary" >Submit</button>
          </form>
          
          
        </div><!-- /.col-lg-12 -->
        <?php
      }
      ?>
   
    </div><!-- /.row -->
  </div><!-- /.container -->


  <!-- FOOTER -->
  <!-- <footer class="container">
    <p class="float-right"><a href="#">Back to top</a></p>
    <p>&copy; 2017-2018 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer> -->
</main>


<?php include 'footer.php'; ?>
<?php
function get_instead2($sem,$t_id,$day1,$day2,$subject){
  global $conn;
  
  $sql="SELECT DISTINCT i.`subj_id`,s.subject_name
      FROM `instead` i
      LEFT JOIN studing s ON i.`subj_id`=s.subject_id and s.student_group_id=i.`std_group`
      WHERE `sem`='$sem' AND i.`teacher_id` ='$t_id' AND `day` between '$day1' and '$day2' 
      and i.`subj_id` not in $subject";
  // echo $sql. "<br>";exit();
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

?>
<script>
$(document).ready(function(){
  // alert ("aaaaa");
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
          $("#end_week").append("<option value='"+ value.id +"'> " + value.name + "</option>");
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

  

  // $('#a1').keypress(function(){
  //   var sum=$('#a1').value
  //   $('#sum_in').value="sum" ;
  // })
    $('#sum_in').click(function(){
      sum_in=0;
      sum_out=0;
      for(i=1;i<=<?php echo $count_input?>;i++){
        
        if(i%2==1){
          sum_in=sum_in+Number($('#'+i).val())
        }else{
          sum_out=sum_out+Number($('#'+i).val())
        } 
      }
      $('#sum_in').val(sum_in) ;
      $('#sum_out').val(sum_out) ;
      // sum_in=Number($('#1').val())+ Number($('#2').val());
      // alert (sum_in+" - "+sum_out);
    })

    $('#sum_s').click(function(){
      sum_s= $('#sum_out').val() - $('#sum_ch').val();
      $('#sum_s').val(sum_s) ;
      // sum_in=Number($('#1').val())+ Number($('#2').val());
      // alert (sum_in+" - "+sum_out);
    })

    $('#sum_s').focus(function(){
      sum_s= $('#sum_out').val() - $('#sum_ch').val();
      $('#sum_s').val(sum_s) ;
      // sum_in=Number($('#1').val())+ Number($('#2').val());
      // alert (sum_in+" - "+sum_out);
    })

 
});

document.getElementById('1').focus();
var sum_in=0 ,sum_out=0 ;
function nextbox(e, id) {
  // alert (id);
  // อ่าน keycode (cross browser)
    var keycode = e.which || e.keyCode;
    // ตรวจสอบ keycode (13 คือ กด enter)
    if (keycode == 13) {
        var last_id=<?php echo $count_input ?>;
        // alert (last_id);
        if (id != (last_id+1)){
          // ย้ายโฟกัสไปยัง input ที่ id
          document.getElementById(id).focus();
        }else{
          for(i=1;i<=<?php echo $count_input?>;i++){
            if(i%2==1){
              sum_in=sum_in+Number($('#'+i).val())
            }else{
              sum_out=sum_out+Number($('#'+i).val())
            } 
          }
          $('#sum_ch').focus();
        }
        $('#sum_in').val(sum_in) ;
        $('#sum_out').val(sum_out) ;
        
        
        // if ((id-1)%2==1){
        //   sum_in = sum_in+Number(document.getElementById(id-1).value) ;
        // }else{
        //   sum_out = sum_out+Number(document.getElementById(id-1).value) ;
        // }
        
        
        // sum2 =(document.getElementById(id-1).value) ;
        // alert (id); alert(sum2);
        // document.getElementById('sum_in').value = sum_in;
        // document.getElementById('sum_out').value = sum_out;
        // return false เพื่อยกเลิกการ submit form
        return false;
    }
   

}

</script>
