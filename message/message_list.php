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
  <div id="message_box">
    <h3>
      <?php
      if (isset($_GET["page"]) || !empty($_GET["page"])) {
        $page = $_GET["page"];
      } else {
        $page = 1;
      }
      if (!isset($_GET["mode"]) || empty($_GET["mode"])) {
        echo ("<script>
        alert('잘못된 접근입니다')
        location.href = 'http://{$_SERVER['HTTP_HOST']}/somokjang/index.php';
        </script>");
      } else {
        $mode = $_GET["mode"];
      }
      if ($mode == "send") {
        echo "송신 쪽지함 > 목록보기";
      } else {
        echo "수신 쪽지함 > 목록보기";
      }

      $scale = 4; //한 페이지당 보여줄 쪽지수
      $start = ($page - 1) * $scale; // 각 페이지의 첫번째 레코드 = (현재페이지-1) * 페이지당 레코드 수

      ?>
    </h3>
    <ul id="message">
      <li>
        <span class="col1">번호</span>
        <span class="col2">제목</span>
        <span class="col3">
          <?php
          if ($mode == "send") {
            echo "받는이";
          } else {
            echo "보낸이";
          }
          ?>
        </span>
        <span class="col4">등록일</span>
      </li>
      <?php
      include "../db/db_connector.php";
      // 3.전체페이지를 구한다
      if ($mode == "send") {
        $sql = "select count(*) from message where send_id='$userid' order by num desc";
      } else {
        $sql = "select count(*) from message where rv_id='$userid' order by num desc";
      }
      $result = mysqli_query($con, $sql);
      $row = mysqli_fetch_array($result); // 전체 글 수
      $total_record = intval($row[0]);
      $total_page = ceil($total_record / $scale); // 전체레코드 나누기 페이지당레코드 값을 올림 해서 전체페이지 구함

      // 4. 보려고 하는 페이지의 시작~끝 위치의 레코드셋을 가져온다.
      // mysql 의 [ limit 시작레코드넘버, 갯수 ]를 이용해서 해당 페이지의 레코드만 가져오는 쿼리문 작성.
      // 테이블의 레코드를 전부 가져오는것 보다 속도면에서 좋다.
      if ($mode == "send") {
        $sql_select = "select * from message where send_id='$userid' order by num desc limit $start, $scale";
      } else {
        $sql_select = "select * from message where rv_id='$userid' order by num desc limit $start, $scale";
      }
      $result = mysqli_query($con, $sql_select);

      // 5. 보여줄 레코드의 넘버
      $number = $total_record - $start;
      // 6. 해당페이지의 가져올 레코드수를 출력해준다.
      while ($row = mysqli_fetch_array($result)) {
        $num = $row["num"];
        $subject = $row["subject"];
        $regist_day = substr($row["regist_day"], 0, 10);

        if ($mode == "send") {
          $msg_id = $row["rv_id"];
        } else {
          $msg_id = $row["send_id"];
        }

        $result2 = mysqli_query($con, "select name from members where id='$msg_id'");
        $record = mysqli_fetch_array($result2);
        $msg_name = $record["name"];
      ?>
        <li>
          <span class="col1"><?= $number ?></span>
          <span class="col2"><a href="message_view.php?mode=<?= $mode ?>&num=<?= $num ?>"><?= $subject ?></a></span>
          <span class="col3"><?= $msg_name ?>(<?= $msg_id ?>)</span>
          <span class="col4"><?= $regist_day ?></span>
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
      include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/common/get_paging.php";
      $url = "message_box.php?mode=" . $mode . "&page=1";
      echo get_paging1(10, $page, $total_page, $url);
      // echo get_paging2($page, $total_page, $url);
      ?>
    </ul> <!-- page_num -->
    <ul class="buttons">
      <li><button onclick="location.href='message_list.php?&mode=rv'">수신 쪽지함</button></li>
      <li><button onclick="location.href='message_list.php?&mode=send'">송신 쪽지함</button></li>
      <li><button onclick="location.href='message_form.php'">쪽지 보내기</button></li>
    </ul>
  </div><!-- message_box -->
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>