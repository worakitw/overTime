<?php 
include 'header.php'; 
include 'connect.php';
include 'lib/function.php';

//======เปลี่ยนภาคเรียน==========
$_SESSION['sem']='2/2565';
//============================

if (substr($_SESSION['sem'],0,1) == 3){
  $sem="S/2565";
}else{
  $sem=$_SESSION['sem'];
}


?>
<style>
.card1 {
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  border-radius: 5px; /* 5px rounded corners */
  padding: 2px 16px;
}
</style>

<main role="main">
  <div class="container marketing">
    <br><br><br>
    <!-- Three columns of text below the carousel -->
    <?php
    // $sql="";
    // $res=mysqli_query($conn,$sql);

    ?>
    <div class="row">
      <div class="col-lg-12">
      <h3>ภาคเรียนที่ <?php echo $sem?> </h3>
        <?php
        $sql="SELECT * FROM `news` WHERE `sem`='".$sem."'";
        // echo $sql;
        $res=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($res)){
        ?>
        <div class="card1 ">
        <h4 class="card-title text-primary"><?php echo $row['title'] ?></h4>
        <div class="card-title text-info"><?php echo "ผู้ประกาศ : ".$row['username'] ." &nbsp;&nbsp; วันที่ : ".chDay($row['day']) ?> </div>
        <div class="card-body "><?php echo $row['message'] ?></div>
        </div>
        <?php
        }
        ?> 
      </div><!-- /.col-lg-12 -->
<!-- เพิ่มข่าว -->
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
