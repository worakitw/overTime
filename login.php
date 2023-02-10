<?php 
session_start(); 
include 'header.php'; 
include 'connect.php';
include 'lib/function.php';
?>


<main role="main">
  <!-- Wrap the rest of the page in another container to center all the content. -->

  <div class="container ">
    <?php
    if (isset($_POST['login'])){
      $user=$_POST['username'];
      $pass=$_POST['password'];

      $sql="SELECT * FROM `user` WHERE `username`='".$user."' AND `password`='".$pass."' ";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user']=$row['user'];
        $_SESSION['status']=$row['status'];
        header( "location: index.php" );
      }


    }
    ?>
    <!-- card login -->
    <div class="card " style="width:400px;margin:0 auto;">
      <div class="card bg-primary ">
        <div class="card-body text-center">
          <h2 class="bg-info text-white">LOGIN</h2>
          <img src="./img/key.png" class="mx-auto d-block" width="40%">
          <form action="" method="post">
            <div class="form-group">
              <label for="Username">Username:</label>
              <input type="Username" class="form-control" id="Username" placeholder="Enter Username" name="username">
            </div>
            <div class="form-group">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
            </div>
            
            <button type="submit" name="login" class="btn btn-primary">Submit</button>
          </form>
          
        </div>
      </div>
    </div>


    <div class="row">
<!-- เลือกแผนกวิชา -->
      <div class="col-lg-6">

      
        
      </div><!-- /.col-lg-12 -->
<!-- เลือกครูผู้สอน -->
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
