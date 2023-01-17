<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> 小 木 匠 </title>
  <link rel="stylesheet" type="text/css" href="../css/common.css">
  <link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>

<body>
  <header>
    <header><?php include "../common/header.php"; ?></header>
    <?php
    $userlevel = "";
    if (isset($_SESSION["userlevel"])) {
      $userlevel = $_SESSION["userlevel"];
      if ($userlevel != 1) {
        echo ("<script>
            alert('관리자가 아닙니다! 회원정보 수정은 관리자만 가능합니다!');
            history.go(-1)
           </script>
           ");
        exit();
      }
    }
    ?>
  </header>
  <section>
    <div id="admin_box">
      <h3 id="member_title">관리자 모드 > 회원 관리</h3>
      <ul id="member_list">
        <li>
          <span class="col1">번호</span>
          <span class="col2">아이디</span>
          <span class="col3">이름</span>
          <span class="col4">레벨</span>
          <span class="col5">포인트</span>
          <span class="col6">가입일</span>
          <span class="col7">수정</span>
          <span class="col8">삭제</span>
        </li>
        <?php
        include "../db/db_connector.php";
        $sql_select = "select * from members order by num desc";
        $result = mysqli_query($con, $sql_select);
        $total_record = mysqli_num_rows($result);
        $number = $total_record; //전체회원 수 

        while ($row = mysqli_fetch_array($result)) {
          $num = $row["num"];
          $id = $row["id"];
          $name = $row["name"];
          $level = $row["level"];
          $point = $row["point"];
          $regist_day = $row["regist_day"];
        ?>
          <li>
            <form method="post" action="admin_management_server.php?mode=update">
              <input type="hidden" name="num" value="<?= $num ?>">
              <span class="col1"><?= $number ?></span>
              <span class="col2"><?= $id ?></span>
              <span class="col3"><?= $name ?></span>
              <span class="col4"><input type="text" name="level" value="<?= $level ?>"></span>
              <span class="col5"><input type="text" name="point" value="<?= $point ?>"></span>
              <span class="col6"><?= $regist_day ?></span>
              <span class="col7"><button type="submit">수정</button></span>
              <span class="col8"><button type="button" onclick="location.href = 'admin_management_server.php?mode=delete&num=<?= $num ?>'">삭제</button></span>
            </form>
          </li>
        <?php
          $number--;
        }
        ?>
      </ul><!-- member_list -->
      <h3 id="member_title">관리자 모드 > 게시판 관리</h3>
      <ul id="board_list">
        <li class="title">
          <span class="col1">선택</span>
          <span class="col2">번호</span>
          <span class="col3">이름</span>
          <span class="col4">제목</span>
          <span class="col5">첨부파일명</span>
          <span class="col6">작성일</span>
        </li>
        <form action="admin_management_server.php?mode=board_delete" method="post">
          <?php
          $sql_select = "select * from board order by num desc";
          $result = mysqli_query($con, $sql_select);
          $total_record = mysqli_num_rows($result);
          $number = $total_record;

          while ($row = mysqli_fetch_array($result)) {
            $num = $row["num"];
            $name = $row["name"];
            $subject = $row["subject"];
            $file_name = $row["file_name"];
            $regist_day = $row["regist_day"];
            $regist_day  = substr($regist_day, 0, 10);
          ?>
            <li>
              <span class="col1"><input type="checkbox" name="item[]" value="<?= $num ?>"></span>
              <span class="col2"><?= $number ?></span>
              <span class="col3"><?= $name ?></span>
              <span class="col4"><?= $subject ?></span>
              <span class="col5"><?= $file_name ?></span>
              <span class="col6"><?= $regist_day ?></span>
            </li>
          <?php
            $number--;
          }
          mysqli_close($con);
          ?>
          <button type="submit">선택된 글 삭제</button>
        </form>
      </ul><!-- board_list -->
    </div><!-- admin_box -->
  </section>
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>