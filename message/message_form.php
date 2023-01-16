<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> 小 木 匠 </title>
  <link rel="stylesheet" type="text/css" href="../css/common.css">
  <link rel="stylesheet" type="text/css" href="../css/message.css">
  <script>
    function check_input() {
      if (!document.message_form.rv_id.value) {
        alert("수신 아이디를 입력하세요!");
        document.message_form.rv_id.focus();
        return;
      }
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
  <header><?php include "../common/header.php"; ?></header>
  <?php
  if (!isset($userid) || empty($userid)) {
    echo ("<script>
				alert('로그인 후 이용해주세요!');
				history.go(-1);
				</script>
			");
    exit;
  }
  ?>
  <div id="message_box">
    <h3 id="write_title">쪽지 보내기</h3>
    <div class="top_buttons">
      <ul>
        <?php
        if (isset($_GET['error'])) {
          echo "<li class = 'error'>{$_GET['error']}</li>";
        }
        if (isset($_GET['success'])) {
          echo "<li class = 'success'>{$_GET['success']}</li>";
        }
        ?>
        <li><span><a href="message_list.php?mode=rv">수신 쪽지함 </a></span></li>
        <li><span><a href="message_list.php?mode=send">송신 쪽지함</a></span></li>
      </ul>
    </div>
    <form name="message_form" action="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/message/message_insert_server.php?&mode=firstmesssage" method="post">
      <div id="write_msg">
        <ul>
          <li>
            <span class="col1">보내는 사람 : </span>
            <span class="col2"><input name="send_id" type="text" value="<?= $userid ?>" readonly></span>
          </li>
          <li>
            <span class="col1">수신 아이디 : </span>
            <span class="col2"><input name="rv_id" type="text"></span>
          </li>
          <li>
            <span class="col1">제목 : </span>
            <span class="col2"><input name="subject" type="text"></span>
          </li>
          <li id="text_area">
            <span class="col1">내용 : </span>
            <span class="col2">
              <textarea name="content"></textarea>
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