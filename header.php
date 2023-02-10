<?php 
session_start(); 
header('Content-Type: text/html; charset=UTF-8');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico"> -->

    <title>เบิกค่าสอนพิเศษ</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/bootstrap3.min.css">

    </head>
  <body>
<header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
        <a class="navbar-brand" href="index.php">เบิกค่าสอนพิเศษ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <?php
            if(isset($_SESSION['status'])){

            ?>
              <li class="nav-item active">
                <a class="nav-link" href="insert_news.php">ประกาศข่าว<span class="sr-only">(current)</span></a>
              </li>
              <!-- <li class="nav-item active">
                <a class="nav-link" href="head_depart.php">กำหนดหัวหน้าแผนก<span class="sr-only">(current)</span></a>
              </li> -->  

              <li class="nav-item active">
                <a class="nav-link" href="overtime_day.php">กำหนดวันที่เบิก<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="holiday.php">กำหนดวันหยุด<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="leave.php">รายการลา<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="instead.php">รายการสอนแทน<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="compensate.php">รายการสอนชดเชย<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="teacher_piority.php">ลำดับครู<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="subject_week5.php">พิมพ์ใบเบิกประจำสัปดาห์<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="summary.php">พิมพ์สรุปใบเบิกรายบุคคล<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="summary_depart.php">พิมพ์สรุปใบเบิกรายแผนก<span class="sr-only">(current)</span></a>
              </li>
            <?php
            }else{
              
            ?>  
              <li class="nav-item active">
                <a class="nav-link" href="subject_week5.php">พิมพ์ใบเบิกประจำสัปดาห์<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="summary.php">พิมพ์สรุปใบเบิกรายบุคคล<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="summary_depart.php" target="_blank">พิมพ์สรุปใบเบิกรายแผนก<span class="sr-only">(current)</span></a>
              </li>
            <?php
            }
            ?>  
            


             <!-- <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Disabled</a>
            </li>  -->
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
          </ul>
          <?php
          if (isset($_SESSION['status'])){
          ?>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
          </ul>
          <?php
          }
          ?>
        </div>
      </nav>
    </header>