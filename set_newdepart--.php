<?php
session_start();
session_destroy();
header( "location: select_teacher.php" );