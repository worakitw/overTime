<?php 
session_start(); 
include 'header.php'; 
include 'connect.php';
include 'lib/function.php';

$sem=$_SESSION['sem'];
?>


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
  
    <!-- Three columns of text below the carousel -->
    <?php
    if (isset($_POST['add_day'])){
        $week_no=$_POST['week_no'];
        $day_start=$_POST['day_start'];
        $day_stop=$_POST['day_stop'];
        $sql ="insert into day_week value('','$sem','$week_no','$day_start','$day_stop')";
        if (mysqli_query($conn, $sql)) {
           // echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    if(isset($_GET['act'])){
        $id=$_GET['id'];
        $sql="delete from day_week where id='$id'";
        if (mysqli_query($conn, $sql)) {
           // echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }
    ?>
    
    <div class="row">
<!-- เลือกวันที่ -->
      <div class="col-lg-4">
        <h2>เพิ่มข้อมูล วันที่/สัปดาห์</h2>
        <form action="" method="post">
            <div class="form-group">
                <?php 
                  show_select_sem();
                ?>
            </div>
            <div class="form-group">
                <label for="week_no">สัปดาห์ที่ :</label>
                <input type="text" class="form-control" id="week_no" name="week_no">
            </div>
            <div class="form-group">
                <label for="day_start">วันที่เริ่มต้นสัปดาห์ :</label>
                <input type="date" class="form-control" id="day_start" name="day_start">
            </div>
            <div class="form-group">
                <label for="day_stop">วันที่สิ้นสุดสัปดาห์ :</label>
                <input type="date" class="form-control" id="day_stop" name="day_stop">
            </div>
            <button type="submit" name="add_day" class="btn btn-primary">เพิ่มข้อมูล</button>
            
        </form>
        
        
      </div><!-- /.col-lg-12 -->
<!-- แสดงวันที่ -->
      <div class="col-lg-8">
        <?php
        if (substr($sem,0,1) == 3){
          $_sem="S/2564";
        }else{
          $_sem=$sem;
        }
        ?>
        <h3>ภาคเรียน <?php echo $_sem ?></h3>
        <?php
        
        $sql="select * from day_week where sem='$sem' order by week_no";
        $result = mysqli_query($conn, $sql);
        ?>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>สัปดาห์ที่</th>
                    <th>วันที่เริ่มต้นสัปดาห์</th>
                    <th>วันที่สิ้นสุดสัปดาห์</th>
                    <th>ลบรายการ</th>
                </tr>
            </thead>

            <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row['week_no'] ?></td>
                    <td><?php echo chDay($row['day_start']) ?></td>
                    <td><?php echo chDay($row['day_stop']) ?></td>
                    <td><a href="overtime_day.php?act=del&id=<?php echo $row['id'] ?>"><img src="img/delete.png" alt="" width=20></a></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        
        
        
      </div><!-- /.col-lg-12 -->
   
    </div><!-- /.row -->
  </div><!-- /.container -->


  <!-- FOOTER -->
  <!-- <footer class="container">
    <p class="float-right"><a href="#">Back to top</a></p>
    <p>&copy; 2017-2018 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer> -->
</main>


<?php include 'footer.php'; ?>
