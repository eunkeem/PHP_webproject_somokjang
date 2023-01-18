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
      document.board_form.submit();
    }
  </script>
</head>

<body>
  <header><?php include "../common/header.php"; ?></header>
  <section>
    <div id="board_box">
      <h3 id="write_title">
        이미지게시판 > 수정하기
      </h3>
      <?php
      if (!$userid) {
        echo ("<script>
				alert('로그인 후 이용해주세요!');
				history.go(-1);
				</script>
			");
        exit;
      }

      include("../db/db_connector.php");
      if (isset($_POST["mode"]) && $_POST["mode"] === "modify") {
        $num = $_POST["num"];
        $page = $_POST["page"];

        $sql = "select * from image_board where num=$num";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        $writer = $row["id"];
        // 세션값이 없거나 해당 게시물 작성자가 아니거나 관리자면 수정권한 없음
        if (!isset($userid) || ($userid !== $writer && $userlevel !== '1')) {
          echo "<script>alert('수정권한이 없습니다');
            history.go(-1);
            </script>";
          exit;
        }
        $name = $row["name"];
        $subject = $row["subject"];
        $exibition_date = $row["exibition_date"];
        $location = $row["location"];
        $file_name = $row["file_name"];
        $content = $row["content"];
        // var_dump($subject);
        // exit; 
        if (empty($file_name)) {
          $file_name = "없음";
        }
      }

      ?>
      <form name="board_form" method="post" action="imageboard_dml.php?mode=modify" enctype="multipart/form-data">
        <input type="hidden" name="mode" value="modify">
        <input type="hidden" name="num" value=<?= $num ?>>
        <input type="hidden" name="page" value=<?= $page ?>>
        <ul id="board_form">
          <li>
            <span class="col1">제목 : </span>
            <span class="col2"><input name="subject" type="text" value="<?= $subject ?>"></span>
          </li>
          <li>
            <span class="col1">전시기간 : </span>
            <span class="col2"><input name="exibition_date" type="text" value="<?= $exibition_date ?>"></span>
          </li>
          <li>
            <span class="col1">전시위치 : </span>
            <span class="col2"><input name="location" type="text" value="<?= $location ?>"></span>
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
          <li><button type="button" onclick="check_input()">수정완료</button></li>
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