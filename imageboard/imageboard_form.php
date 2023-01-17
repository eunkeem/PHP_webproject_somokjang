<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title> 小 木 匠 </title>
  <link rel="stylesheet" type="text/css" href="../css/common.css">
  <link rel="stylesheet" type="text/css" href="../css/board.css">
  <script>
    function check_input() {
      if (!document.board_form.subject.value) {
        alert("제목을 입력하세요!");
        document.board_form.subject.focus();
        return;
      }
      if (!document.board_form.content.value) {
        alert("내용을 입력하세요!");
        document.board_form.content.focus();
        return;
      }
      if (!document.board_form.exibition_date.value) {
        alert("전시기간을 입력하세요!");
        document.board_form.content.focus();
        return;
      }
      if (!document.board_form.location.value) {
        alert("위치를 입력하세요!");
        document.board_form.content.focus();
        return;
      }
      document.board_form.submit();
    }
  </script>
</head>

<body>
  <header><?php include "../common/header.php"; ?></header>
  <section>
    <div id="board_box">
      <h3 id="board_title">
        전시안내 > 작성하기
      </h3>
      <form name="board_form" method="post" action="imageboard_dml.php" enctype="multipart/form-data">
        <input type="hidden" name="mode" value="insert">
        <ul id="board_form">
          <li>
            <span class="col1">이름 : </span>
            <span class="col2"><?= $username ?></span>
          </li>
          <li>
            <span class="col1">제목 : </span>
            <span class="col2"><input name="subject" type="text"></span>
          </li>
          <li>
            <span class="col1">기간 : </span>
            <span class="col2"><input name="exibition_date" type="text"></span>
          </li>
          <li>
            <span class="col1">위치 : </span>
            <span class="col2"><input name="location" type="text"></span>
          </li>
          <li id="text_area">
            <span class="col1">내용 : </span>
            <span class="col2">
              <textarea name="content"></textarea>
            </span>
          </li>
          <li>
            <span class="col1"> 첨부 파일</span>
            <span class="col2"><input type="file" name="upfile"></span>
          </li>
        </ul>
        <ul class="buttons">
          <li><button type="button" onclick="check_input()">저장</button></li>
          <li><button type="button" onclick="location.href='imageboard_list.php'">목록</button></li>
        </ul>
      </form>
    </div> <!-- board_box -->
  </section>
  <footer>
  <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>