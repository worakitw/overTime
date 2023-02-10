<?php 
session_start(); 
include 'header.php'; 
include 'connect.php';
include 'lib/function.php';


$sem=$_SESSION['sem'];

?>


<main role="main">
  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">
        <!-- <br><br><br> -->
        <!-- Three columns of text below the carousel -->
        <div class="row">
            <div class="col-lg-6">
                <h3>ภาคเรียนที่ <?php echo $sem?> </h3>
            </div>
            <div class="col-lg-6">
                <form action="#" method="post">
                    <button type="submit" class="btn btn-primary" name="addnews" value="1">เพิ่มข่าว</button>
                </form>
            </div>
            <?php

            if (isset($_POST['add1'])){
                $username=$_POST['username'];
                $title=$_POST['title'];
                $message=$_POST['message'];
                $day=date("Y-m-d");
                $sql="INSERT INTO `news` VALUES ('','$sem','$username','$day','$title','$message')" ;
                if (mysqli_query($conn, $sql)) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }

            }
            if ($_POST['addnews']){
            ?>
                <div class="col-lg-12">
                    <h3 class="bg-info text-white">เพิ่มข่าว</h3>
                    <form action="#" method='post'>
                        <div class="form-group">
                            <label for="title"><b>หัวข้อข่าว</b></label>
                            <input type="text" class="form-control" placeholder="Enter หัวข้อข่าว" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="message"><b>ข้อความประกาศ</b></label>
                            <input type="text" class="form-control" placeholder="Enter ข้อความประกาศ" name="message" required>
                        </div>
                        <div class="form-group">
                            <label for="username"><b>ชื่อผู้ประกาศ</b></label>
                            <input type="text" class="form-control" placeholder="Enter ชื่อผู้ประกาศ" name="username" required>
                        </div>
                        <button type="submit" name="add1" class="btn btn-primary">บันทึก</button>
                    </form>
                    <hr style="border-top: 1px solid red;">
                </div>
            <?php
            }
            if (isset($_GET['id'])){
                $id=$_GET['id'] ;
                $sql="DELETE FROM `news` WHERE `news`.`id` ='$id' ";
                if (mysqli_query($conn, $sql)) {
                    // echo "Record deleted successfully";
                  } else {
                    echo "Error deleting record: " . mysqli_error($conn);
                  }
            }
            ?>


            <div class="col-lg-12">
                <h3 class="bg-success text-white" >แสดงข้อมูลข่าว</h3>
                <?php
                $sql="SELECT * FROM `news` WHERE `sem`='$sem'";
                $res=mysqli_query($conn,$sql);
                while($row=mysqli_fetch_assoc($res)){
                ?>
                <div class="card1 ">
                    <h4 class="card-title text-primary"><?php echo $row['title'] ?></h4>
                    <div class="card-title text-info"><?php echo "ผู้ประกาศ : ".$row['username'] ." &nbsp;&nbsp; วันที่ : ".chDay($row['day']) ?> </div>
                    <div class="card-body "><?php echo $row['message'] ?></div>
                    <a href="insert_news.php?id=<?php echo $row['id'] ?>"><img src="./img/delete.png" alt="" width="30px"> ลบข่าว</a>
                </div>
                <hr style="border-top: 1px solid green;">
                <?php
                }
                ?>   
            </div><!-- /.col-lg-12 -->

            <div class="col-lg-6">
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
