<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> 小 木 匠 </title>
  <link rel="stylesheet" type="text/css" href="../css/common.css">
  <link rel="stylesheet" type="text/css" href="../css/board.css">
  <script>
    function check_input() {
      if (!document.board_form.subject.value) {
        alert("제목을 입력하세요");
        document.board_form.subject.value.focus();
        return;
      }
      if (!document.board_form.content.value) {
        alert("내용을 입력하세요");
        document.board_form.content.value.focus();
        return;
      }
      document.board_form.submit();
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
    exit();
  }
  ?>
  <div id="board_box">
    <h3 id="write_title">게시판 > 글쓰기</h3>
    <!-- enctype="multipart/form-data 의 기능 : 자료파일 첨부가 가능함 -->
    <form name="board_form" action="./board_insert_server.php?mode=board_insert" method="post" enctype="multipart/form-data">
      <ul id="board_form">
        <li>
          <span class="col1">작성자 : </span>
          <span class="col2"><?= $username ?></span>
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
        <li>
          <span class="col1">첨부 파일 </span>
          <span class="col2"><input name="upfile" type="file"></span>
        </li>
      </ul>
      <ul class="buttons">
        <li><button type="button" onclick="check_input()">저장</button></li>
        <li><button type="button" onclick="location.href='board_list.php'">목록</button></li>
      </ul>
    </form>
  </div>
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>