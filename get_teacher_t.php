<?php
session_start(); 
include '../connect.php';
// header('Content-Type: application/json; charset=utf-8');

if(isset($_GET['depart_id'])){
    $depart_id = $_GET['depart_id'];
    echo "<script>alert($depart_id)</script>" ;
    $sql_t="SELECT p1.`people_id`,concat(p1.`people_name`,'  ',p1.`people_surname`) as name ";
    $sql_t.=" FROM `people` p1";
    $sql_t.=" INNER JOIN people_pro p2 ON p1.`people_id`=p2.`people_id` ";
    $sql_t.=" WHERE p2.people_dep_id='".$depart_id."'";
    // echo $sql_t;exit();
    $res=mysqli_query($conn,$sql_t);
    // echo mysqli_num_rows($res);
    if (mysqli_num_rows($res) > 0) {
        while($row=mysqli_fetch_assoc($res)){
            $json_result[] = [
                'id'=>$row['people_id'],
                'name'=>$row['name'],
            ];
        }
    }
    // echo $json_result;
    echo json_encode($json_result);

}