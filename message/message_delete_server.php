<?php
include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
$num = $mode = "";

if (isset($_GET["num"]) && isset($_GET["mode"])) {
  $num = $_GET["num"];
  $mode = $_GET["mode"];

  $sql_delete = "delete from message where num = '$num'";
  $result = mysqli_query($con, $sql_delete);
  mysqli_close($con);

  if ($result) {
    if ($mode == "send") {
      echo ("<script>
          alert('쪽지를 성공적으로 삭제했습니다');
          location.href = 'message_list.php?mode=send';
      </script>");
    } else {
      echo ("<script>
          alert('쪽지를 성공적으로 삭제했습니다');
          location.href = 'message_list.php?mode=rv';
      </script>");
    }
    exit();
  } else {
    echo ("<script>
          alert('쪽지 삭제에 실패했습니다');
          history.go(-1);
          </script>
        ");
    exit();
  }
} else {
  echo ("<script>
  alert('비정상적인 접근입니다.')
  location.href = 'http://{$_SERVER['HTTP_HOST']}/somokjang/index.php';
  </script>");
  exit();
}
