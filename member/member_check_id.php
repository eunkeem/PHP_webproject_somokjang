<?php
include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
$message = $id = "";
$id = $_GET["id"];
if (isset($id)) {
  $id = mysqli_real_escape_string($con, $id);

  if (empty($id)) {
    $message = "<li>아이디를 입력해 주세요</li>";
  } else {
    $sql_same = "select * from members where id = '$id'";
    $record_set = mysqli_query($con, $sql_same);

    if (mysqli_num_rows($record_set) == 1) {
      $message = "<li>아이디가 이미 존재합니다</li>";
    } else {
      $message = "<li>{$id} 아이디는 사용 가능합니다</li>";
    }
    mysqli_close($con);
  }
} else {
  $message = "<li>아이디를 입력해 주세요</li>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <style>
    h3 {
      padding-left: 5px;
      border-left: solid 5px #edbf07;
    }

    #close {
      margin: 20px 0 0 80px;
      cursor: pointer;
    }

    li {
      list-style-type: none;
    }
  </style>
</head>

<body>
  <h3>아이디 중복체크</h3>
  <p>
    <?php echo $message ?>
  </p>
  <input type="button" class="btn" onclick="javascript:self.close()" value="닫기">
</body>

</html>