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
  <div id="board_box">
    <h3 id="write_title">게시판 > 수정하기</h3>
    <?php
    if (isset($_GET["num"]) && isset($_GET["page"])) {
      $num = $_GET["num"];
      $page = $_GET["page"];
    } else {
      echo ("<script>
      alert('잘못된 접근입니다');
      history.go(-1);
      </script>
      ");
      exit();
    }

    include "../db/db_connector.php";
    $sql_select = "select * from board where num=$num";
    $result = mysqli_query($con, $sql_select);
    $row = mysqli_fetch_array($result);
    $name       = $row["name"];
    $subject    = $row["subject"];
    $content    = $row["content"];
    $file_name  = $row["file_name"];
    ?>
    <form name="board_form" action="board_modify_server.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="num" value=<?= $num ?>>
      <input type="hidden" name="page" value=<?= $page ?>>
      <ul id="board_form">
        <li>
          <span class="col1">작성자 : </span>
          <span class="col2"><?= $name ?></span>
        </li>
        <li>
          <span class="col1">제목 : </span>
          <span class="col2"><input id="subject" name="subject" type="text" value="<?= $subject ?>"></span>
        </li>
        <li id="text_area">
          <span class="col1">내용 : </span>
          <span class="col2">
            <textarea name="content"><?= $content ?></textarea>
          </span>
        </li>
        <li>
          <span class="col1">기존파일삭제<input id="checkbox" type="checkbox" name="item" value="<?= $file_name ?>"></span>
          <span class="col2"><?= $file_name ?></span>
        </li>
        <li>
          <span class="col1">파일 변경</span>
          <span class="col2"><input name="upfile" type="file"></span>
        </li>
      </ul>
      <ul class="buttons">
        <li><button type="button" onclick="check_input()">수정하기</button></li>
        <li><button type="button" onclick="location.href='board_list.php'">목록</button></li>
      </ul>
    </form>
  </div>
  <footer>
  <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>