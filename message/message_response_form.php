<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> 小 木 匠 </title>
  <link rel="stylesheet" type="text/css" href="../css/common.css">
  <link rel="stylesheet" type="text/css" href="../css/message.css">
  <script>
    function check_input() {
      if (!document.message_form.subject.value) {
        alert("제목을 입력하세요!");
        document.message_form.subject.focus();
        return;
      }
      if (!document.message_form.content.value) {
        alert("내용을 입력하세요!");
        document.message_form.content.focus();
        return;
      }
      document.message_form.submit();
    }
  </script>
</head>

<body>
  <header><?php include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/common/header.php"; ?></header>
  <div id="message_box">
    <h3 id="write_title">답장 보내기</h3>
    <?php
    if (isset($_GET['error'])) {
      echo "<li class = 'error'>{$_GET['error']}</li>";
    }
    if (isset($_GET['success'])) {
      echo "<li class = 'success'>{$_GET['success']}</li>";
    }

    $num = "";
    if (!isset($_GET["num"]) || !$userid) {
      echo ("<script>
            alert('잘못된 접근입니다')
            location.href = 'http://{$_SERVER['HTTP_HOST']}/somokjang/index.php';
            </script>");
    } else {
      $num  = $_GET["num"];
    }
    include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
    $sql = "select * from message where num=$num";
    $result = mysqli_query($con, $sql);

    $row = mysqli_fetch_array($result);
    $send_id = $row["send_id"];
    $rv_id = $row["rv_id"];
    $regist_day = $row["regist_day"];
    $subject = $row["subject"];
    $content = $row["content"];

    $subject = "RE: " . $subject;

    $content = ">" . $content;
    $content = str_replace("\n", "\n>", $content);
    $content = "\n\n\n --------------------------------------------------\n" . $content;

    $result2 = mysqli_query($con, "select name from members where id = '$send_id'");
    $record = mysqli_fetch_array($result2);
    $send_name = $record["name"];
    ?>
    <form name="message_form" method="post" action="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/message/message_insert_server.php?mode=reponse">
      <input type="hidden" name="rv_id" value="<?= $send_id ?>">
      <input type="hidden" name="send_id" value="<?= $userid ?>">
      <div id="write_msg">
        <ul>
          <li>
            <span class="col1">보내는 사람 : </span>
            <span class="col2"><?= $userid ?></span>
          </li>
          <li>
            <span class="col1">수신 아이디 : </span>
            <span class="col2"><?= $send_id ?></span>
          </li>
          <li>
            <span class="col1">제목 : </span>
            <span class="col2"><input name="subject" type="text" value="<?= $subject ?>"></span>
          </li>
          <li id="text_area">
            <span class="col1">내용 : </span>
            <span class="col2">
              <textarea name="content"><?= $content ?></textarea>
            </span>
          </li>
        </ul>
        <button type="button" onclick="check_input()">보내기</button>
      </div>
    </form>
  </div>
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>