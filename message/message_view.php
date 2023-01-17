<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> 小 木 匠 </title>
  <link rel="stylesheet" type="text/css" href="../css/common.css">
  <link rel="stylesheet" type="text/css" href="../css/message.css">
</head>

<body>
  <header><?php include "../common/header.php"; ?></header>
  <div id="board_box">
    <h3>
      <?php
      $mode = $num = "";
      if (!isset($_GET["mode"]) || !isset($_GET["num"])) {
        echo ("<script>
        alert('잘못된 접근입니다')
        location.href = 'http://{$_SERVER['HTTP_HOST']}/somokjang/index.php';
        </script>");
      } else {
        $mode = $_GET["mode"];
        $num  = $_GET["num"];
      }

      include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
      $sql = "select * from message where num=$num";
      $result = mysqli_query($con, $sql);

      $row = mysqli_fetch_array($result);
      $send_id = $row["send_id"];
      $rv_id = $row["rv_id"];
      $regist_day = substr($row["regist_day"], 0, 10);
      $subject = $row["subject"];
      $content = $row["content"];

      $content = str_replace(" ", "&nbsp;", $content);
      $content = str_replace("\n", "<br>", $content);

      if ($mode == "send") {
        $result2 = mysqli_query($con, "select name from members where id='$rv_id'");
      } else {
        $result2 = mysqli_query($con, "select name from members where id='$send_id'");
      }

      $record = mysqli_fetch_array($result2);
      $msg_name = $record["name"];

      if ($mode == "send") {
        echo "송신 쪽지함 > 내용보기";
      } else {
        echo "수신 쪽지함 > 내용보기";
      }
      mysqli_close($con);
      ?>
    </h3>
    <ul id="board_list">
      <li>
        <span class="col1"></span>
        <span class="col2">제목 : <b><?= $subject ?></b></span>
        <span class="col3"></span>
        <span class="col4"><?= $msg_name ?> | <?= $regist_day ?></span>
      </li>
      <li id="message_content"><?= $content ?></li>
    </ul>
    <ul class="buttons">
      <li><button onclick="location.href='message_list.php?mode=rv'">수신 쪽지함</button></li>
      <li><button onclick="location.href='message_list.php?mode=send'">송신 쪽지함</button></li>
      <?php
      if ($mode !== "send") {
      ?>
        <li><button onclick="location.href='message_response_form.php?num=<?= $num ?>'">답변 쪽지</button></li>
      <?php
      }
      ?>
      <li><button onclick="location.href='message_delete_server.php?num=<?= $num ?>&mode=<?= $mode ?>'">삭제</button></li>
    </ul>
  </div><!-- message_box -->
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>