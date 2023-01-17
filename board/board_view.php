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
  <section>
    <div id="board_box">
      <h3 class="title">
        게시판 > 내용보기
      </h3>
      <?php
      $num = $page = "";
      if (!isset($_GET["num"])) {
        echo ("<script>
      alert('잘못된 접근입니다')
      history.go(-1);
      </script>");
      }
      $num  = $_GET["num"];
      // 메인페이지에서 링크로 들어와 페이지값이 없을 경우 첫페이지로가도록
      if (!isset($_GET["page"])) {
        $page = 1;
      } else {
        $page = $_GET["page"];
      }
      // 로그인 안한 상태라면
      if (!isset($_SESSION['userid'])) {
        $userid = null;
      } else {
        $userid = $_SESSION['userid'];
      }
      include "../db/db_connector.php";
      $sql = "select * from board where num=$num";
      $result = mysqli_query($con, $sql);

      $row = mysqli_fetch_array($result);
      $id           = $row["id"];
      $name         = $row["name"];
      $regist_day   = substr($row["regist_day"], 0, 10);
      $subject      = $row["subject"];
      $content      = $row["content"];
      $file_name    = $row["file_name"];
      $file_type    = $row["file_type"];
      $copied_file_name = $row["file_copied"];
      $hit          = $row["hit"];

      $content = str_replace(" ", "&nbsp;", $content);
      $content = str_replace("\n", "<br>", $content);

      $new_hit = $hit + 1;
      $sql = "update board set hit = $new_hit where num = $num";
      mysqli_query($con, $sql);

      //이미지 정보를 가져오기 위한 함수 width, height, type
      if (!empty($file_name)) {
        $image_info = getimagesize("../data/" . $copied_file_name);
        $image_width = $image_info[0];
        $image_height = $image_info[1];
        $image_type = $image_info[2];
        if ($image_height > 250) {
          if ($image_height == $image_width) {
            $image_width = $image_height = 250;
          } elseif ($image_width > $image_height) {
            $image_height = 250;
            $image_width = 400;
          } elseif ($image_width < $image_height) {
            $image_height = 250;
            $image_width = 160;
          }
        }
      }
      ?>
      <ul id="view_content">
        <li>
          <span class="col1">제목 : <b><?= $subject ?></b></span>
          <span class="col2"><?= $name ?> | <?= $regist_day ?></span>
        </li>
        <li>
          <?php
          if (strpos($file_type, "image") !== false) {
            echo "<img src='../data/$copied_file_name' width='$image_width' height='$image_height'><br>";
          } else if ($file_name) {
            $real_name = $copied_file_name;
            $file_path = "../data/" . $real_name;
            $file_size = filesize($file_path);

            // board_download.php 에 넘겨준것들 체크
            echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
                  <a href='board_download.php?real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
          }
          ?>
          <b><?= $content ?></b>
        </li>
      </ul>
      <!-- 덧글 -->
      <div id="reply">
        <?php
        $sql = "select * from `board_reply` where parent='$num' ";
        $reply_result = mysqli_query($con, $sql);
        $sql_count = "select count(*) from `board_reply` where parent='$num' ";
        $reply_count_result = mysqli_query($con, $sql_count);
        $count_row = mysqli_fetch_array($reply_count_result);
        $total_reply = intval($count_row[0]);
        ?>

        <h5>덧글 <?= $total_reply ?> 개</h5>
        <?php
        while ($reply_row = mysqli_fetch_array($reply_result)) {
          $reply_num = $reply_row['num'];
          $reply_id = $reply_row['id'];
          $reply_nick = $reply_row['nick'];
          $reply_date = substr($reply_row['regist_day'], 0, 10);
          $reply_content = $reply_row['content'];
          $reply_content = str_replace("\n", "<br>", $reply_content);
          $reply_content = str_replace(" ", "&nbsp;", $reply_content);
        ?>
          <div id="reply_title">
            <ul>
              <li><?= $reply_id . "&nbsp;&nbsp;" . $reply_date ?></li>
              <li id="mdi_del">
                <?php
                // 관리자모드이거나 해당댓글작성자라면 삭제 가능 하도록
                if ($userid == "admin" || $userid == $reply_id) {
                  echo '
                      <form style="display:inline" action="board_delete_server.php?page=' . $page . '&num=' . $num . '&mode=reply_delete" method="post">
                        <input type="hidden" name="page" value="' . $page . '">
                        <input type="hidden" name="hit" value="' . $hit . '">
                        <input type="hidden" name="mode" value="delete_reply">
                        <input type="hidden" name="num" value="' . $reply_num . '">
                        <input type="hidden" name="parent" value="' . $num . '">
                        <span>' . $reply_content . '</span>
                        <input type="submit" value="삭제">
                      </form>';
                } else {
                  echo '
                      <form style="display:inline" action="#" method="post">
                        <span>' . $reply_content . '</span>
                      </form>';
                }
                ?>
              </li>
            </ul>
          </div>
        <?php
        } //end of while
        mysqli_close($con);
        ?>
        <form name="reply_form" action="board_insert_server.php?mode=reply_insert" method="post">
          <input type="hidden" name="mode" value="insert_reply">
          <input type="hidden" name="parent" value="<?= $num ?>">
          <input type="hidden" name="hit" value="<?= $hit ?>">
          <input type="hidden" name="page" value="<?= $page ?>">
          <div id="reply_insert">
            <div id="reply_textarea"><textarea name="reply_content" placeholder="댓글을 입력하세요" rows="3" cols="108"></textarea></div>
            <div id="reply_button"><button>덧글입력</button>
            </div>
          </div> <!--end of reply_insert -->
        </form>
      </div> <!--end of reply  -->

      <ul class="buttons">
        <li><button onclick="location.href='board_list.php?page=<?= $page ?>'">목록</button></li>
        <?php
        // 부모글작성자라면 해당 게시물 삭제, 수정 버튼
        if ($userid == $id) {
          echo '  <li><button onclick="location.href=`board_modify_form.php?num=' . $num . '&page=' . $page . '`">수정</button></li>
                  <li><button onclick="location.href=`board_delete_server.php?num=' . $num . '&page=' . $page . '&mode=board_delete`">삭제</button></li>';
        }
        ?>
        <li><button onclick="location.href='board_form.php'">글쓰기</button></li>
      </ul>
    </div><!-- board_box -->
  </section>
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>