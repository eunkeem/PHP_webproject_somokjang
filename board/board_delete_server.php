<?php
include "../db/db_connector.php";
$num = $page = "";

if (!isset($_GET["num"]) || !isset($_GET["page"])|| !isset($_GET["mode"])) {
  echo ("<script>
  alert('비정상적인 접근입니다.')
  location.href = 'http://{$_SERVER['HTTP_HOST']}/somokjang/index.php';
  </script>");
  exit();
}
$num = $_GET["num"];
$page = $_GET["page"];

$mode = $_GET["mode"];

switch ($mode) {
  case "board_delete":
    $sql_select = "select * from board where num = $num";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    $copied_name = $row["file_copied"];

    // 기존 파일이 있다면 삭제 
    if ($copied_name) {
      $file_path = "../data/" . $copied_name;
      unlink($file_path);
    }

    $sql_delete = "delete from board where num = '$num'";
    $result_board = mysqli_query($con, $sql_delete);
    $sql_delete = "delete from board_reply where parent = '$num'";
    $result_reply = mysqli_query($con, $sql_delete);
    mysqli_close($con);

    if ($result) {
      echo ("<script>
            alert('게시물을 성공적으로 삭제했습니다');
            location.href = 'board_list.php?page=$page';
            </script>");
      exit();
    } else {
      echo ("<script>
            alert('게시물 삭제에 실패했습니다');
            history.go(-1);
            </script>
          ");
      exit();
    }
    break;

  case "reply_delete":
    $page = mysqli_real_escape_string($con, $_POST["page"]);
    $hit = mysqli_real_escape_string($con, $_POST["hit"]);
    $num = mysqli_real_escape_string($con, $_POST["num"]);
    $parent = mysqli_real_escape_string($con, $_POST["parent"]);
    $q_num = mysqli_real_escape_string($con, $num);

    $sql = "DELETE FROM `board_reply` WHERE num=$q_num";
    $result = mysqli_query($con, $sql);
    if (!$result) {
      die('Error: ' . mysqli_error($con));
    }
    mysqli_close($con);
    echo "
        <script>
          location.href='./board_view.php?num=$parent&page=$page&hit=$hit';</script>";

    break;
}
