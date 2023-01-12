<?php
$con = mysqli_connect("localhost", "root", "123456");
if (!$con) {
  die("database connect fail" . mysqli_connect_errno());
}

//  'sample'이라는 데이터베이스가 있는지 확인
$database_flag = false; 
$sql = "show databases";
$result = mysqli_query($con, $sql) or  die("데이타베이스 보여주기 실패". mysqli_error($con)); 
while($row = mysqli_fetch_array($result)){
  if($row["Database"] == "somokjang"){
    $database_flag = true;
    break; 
  }
}
// 'sample'이라는 데이터베이스가 있는지 확인 - 없다면
if($database_flag == false){
  $sql = "create database somokjang";
  $result = mysqli_query($con, $sql) or  die("데이타베이스 생성 실패". mysqli_error($con));   
  if($result == true){
    echo "<script>alert('somokjang 데이타베이스가 생성되었습니다.')</script>";
  }
}
// 데이타베이스 선택
$dbcon = mysqli_select_db($con, "somokjang") or  die("데이타베이스 선택 실패". mysqli_error($con)); 
if($dbcon == false){
  echo "<script>alert('somokjang 데이타베이스 선택이 실패했습니다.')</script>";
}