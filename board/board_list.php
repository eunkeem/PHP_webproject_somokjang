<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> 小 木 匠 </title>
  <link rel="stylesheet" type="text/css" href="../css/common.css">
  <link rel="stylesheet" type="text/css" href="../css/board.css">
</head>

<body>
  <header><?php include "../common/header.php"; ?></header>
  <div id="board_box">
    <h3>게시판 > 목록보기</h3>
    <ul id="board_list">
      <li>
        <span class="col1">번호</span>
        <span class="col2">제목</span>
        <span class="col3">작성자</span>
        <span class="col4">첨부</span>
        <span class="col5">등록일</span>
        <span class="col6">조회</span>
      </li>
      <?php
      include "../db/db_connector.php";
      $page = $num = "";
      $id = $name = $subject = $regist_day = $hit = "";

      if (isset($_GET["page"]) && !empty($_GET["page"])) {
        $page = $_GET["page"];
      } else {
        $page = 1;
      }
      $scale = 7; //한 페이지당 보여줄 쪽지수
      $start = ($page - 1) * $scale; // 각 페이지의 첫번째 레코드 = (현재페이지-1) * 페이지당 레코드 수
      // 3.전체페이지를 구한다
      $sql = "select count(*) from board order by num desc";
      $result = mysqli_query($con, $sql);
      $row = mysqli_fetch_array($result); // 전체 글 수
      $total_record = intval($row[0]);
      $total_page = ceil($total_record / $scale); // 전체레코드 나누기 페이지당레코드 값을 올림 해서 전체페이지 구함

      // 4. 보려고 하는 페이지의 시작~끝 위치의 레코드셋을 가져온다.
      // mysql 의 [ limit 시작레코드넘버, 갯수 ]를 이용해서 해당 페이지의 레코드만 가져오는 쿼리문 작성.
      // 테이블의 레코드를 전부 가져오는것 보다 속도면에서 좋다.
      $sql_select = "select * from board order by num desc limit $start, $scale";
      $result = mysqli_query($con, $sql_select);
      // 5. 보여줄 레코드의 넘버
      $number = $total_record - $start;
      // 6. 해당페이지의 가져올 레코드수를 출력해준다.
      while ($row = mysqli_fetch_array($result)) {
        $num = $row["num"];
        $id = $row["id"];
        $name = $row["name"];
        $subject = $row["subject"];
        $regist_day = substr($row["regist_day"], 0, 10);
        $hit = $row["hit"];
        if ($row["file_name"]) {
          $file_image = "<img src='./img/file.gif'>";
        } else {
          $file_image = " ";
        }
      ?>
        <li id="notice_list">
          <span class="col1"><?= $number ?></span>
          <span class="col2"><a href="board_view.php?num=<?= $num ?>&page=<?= $page ?>"><?= $subject ?></a></span>
          <span class="col3"><?= $name ?></span>
          <span class="col4"><?= $file_image ?></span>
          <span class="col5"><?= $regist_day ?></span>
          <span class="col6"><?= $hit ?></span>
        </li>
      <?php
        $number--;
      }
      while ($row = mysqli_fetch_array($result)) {
        $num = $row["num"];
        $id = $row["id"];
        $name = $row["name"];
        $subject = $row["subject"];
        $regist_day = substr($row["regist_day"], 0, 10);
        $hit = $row["hit"];
        if ($row["file_name"]) {
          $file_image = "<img src='./img/file.gif'>";
        } else {
          $file_image = " ";
        }
      ?>
        <li>
          <span class="col1"><?= $number ?></span>
          <span class="col2"><a href="board_view.php?num=<?= $num ?>&page=<?= $page ?>"><?= $subject ?></a></span>
          <span class="col3"><?= $name ?></span>
          <span class="col4"><?= $file_image ?></span>
          <span class="col5"><?= $regist_day ?></span>
          <span class="col6"><?= $hit ?></span>
        </li>
      <?php
        $number--;
      }
      mysqli_close($con);
      ?>
    </ul>
    <!-- 페이지를 출력한다. 함수 두가지 dbconnector 에서 골라 사용-->
    <ul id="page_num">
      <?php
      include "../common/get_paging.php";
      $url = "board_list.php?&page=1";
      echo get_paging1(10, $page, $total_page, $url);
      // echo get_paging2($page, $total_page, $url);
      ?>
    </ul> <!-- page_num -->
    <ul class="buttons">
      <li>
        <?php
        if ($userid) {
        ?>
          <button onclick="location.href='board_form.php'">글쓰기</button>
        <?php
        } else {
        ?>
          <a href="javascript:alert('로그인 후 이용해 주세요!')"><button>글쓰기</button></a>
        <?php
        }
        ?>
      </li>
    </ul>
  </div><!-- board_box -->
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>