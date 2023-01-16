<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title> 小 木 匠 </title>
  <link rel="stylesheet" type="text/css" href="../css/common.css">
  <link rel="stylesheet" type="text/css" href="../css/board.css">
</head>

<body>
  <header><?php include "../common/header.php"; ?></header>
  <section>
    <div id="board_box">
      <h3>
        전시안내 > 상세보기
      </h3>
      <ul id="board_list2">
        <?php
        // if (!$userid) {
        //   echo ("<script>
        //   alert('로그인 후 이용해주세요!');
        //   history.go(-1);
        // </script>
        // ");
        //   exit;
        // }
        include "../db/db_connector.php";

        // 메인페이지에서 링크로 들어와 페이지값이 없을 경우 첫페이지로가도록
        if (!isset($_GET["page"])) {
          $page = 1;
        } else {
          $page = $_GET["page"];
        }
        $num = $_GET["num"];

        $sql = "select * from image_board where num=$num";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        if (!$row) {
          echo ("<script>
          alert('아직 기획된 전시가 없습니다');
          history.go(-1);
        </script>
        ");
          exit;
        }

        $id = $row["id"];
        $name = $row["name"];
        $regist_day = substr($row["regist_day"], 0, 10);
        $subject = $row["subject"];
        $content = $row["content"];
        $file_name = $row["file_name"];
        $file_type = $row["file_type"];
        $file_copied = $row["file_copied"];
        $hit = $row["hit"];
        $content = str_replace(" ", "&nbsp;", $content);
        $content = str_replace("\n", "<br>", $content);

        // $hit 추가 설정: 이미지 게시판 몇명이 클릭했는지 점검
        if ($userid !== $id) {
          $new_hit = $hit + 1;
          $sql = "update image_board set hit=$new_hit where num=$num";
          mysqli_query($con, $sql);
        }

        $file_name = $row['file_name'];
        $file_copied = $row['file_copied'];
        $file_type = $row['file_type'];
        //이미지 정보를 가져오기 위한 함수 width, height, type
        if (!empty($file_name)) {
          $image_info = getimagesize("../data/" . $file_copied);
          $image_width = $image_info[0];
          $image_height = $image_info[1];
          $image_type = $image_info[2];

          $image_height = 400;
          $image_width = 281;
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
              echo "<img src='../data/$file_copied' width='$image_width'><br>";
            } else if ($file_name) {
              $real_name = $file_copied;
              $file_path = "../data/" . $real_name;
              $file_size = filesize($file_path);  //파일사이즈를 구해주는 함수
            }
            ?>
            <?= $content ?>
          </li>
        </ul>
        <!--덧글내용시작  -->
        <div id="reply">
          <?php
          $sql = "select * from `image_board_reply` where parent='$num' ";
          $reply_result = mysqli_query($con, $sql);
          $sql_count = "select count(*) from `image_board_reply` where parent='$num' ";
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
                      <form style="display:inline" action="imageboard_dml.php" method="post">
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
            <!-- reply_title -->
          <?php
          } //end of while
          mysqli_close($con);
          ?>
          <form name="ripple_form" action="imageboard_dml.php" method="post">
            <input type="hidden" name="mode" value="insert_reply">
            <input type="hidden" name="parent" value="<?= $num ?>">
            <input type="hidden" name="hit" value="<?= $hit ?>">
            <input type="hidden" name="page" value="<?= $page ?>">
            <div id="ripple_insert">
              <div id="ripple_textarea">
                <textarea name="ripple_content" rows="3" cols="80"></textarea>
              </div>
              <div id="ripple_button">
                <button>덧글입력</button>
              </div>
            </div>
            <!--end of ripple_insert -->
          </form>
        </div>
        <!--end of ripple2  -->



        <ul class="buttons">
          <li>
            <button onclick="location.href='imageboard_list.php?page=<?= $page ?>'">목록</button>
          </li>
          <?php
          if ($userlevel == 1) {
          ?>
            <li>
              <form action="imageboard_modify_form.php" method="post">
                <button>수정</button>
                <input type="hidden" name="num" value=<?= $num ?>>
                <input type="hidden" name="page" value=<?= $page ?>>
                <input type="hidden" name="mode" value="modify">
              </form>
            </li>
            <li>
              <form action="imageboard_dml.php?mode=delete" method="post">
                <button>삭제</button>
                <input type="hidden" name="num" value=<?= $num ?>>
                <input type="hidden" name="page" value=<?= $page ?>>
                <input type="hidden" name="mode" value="delete">
              </form>
            </li>
            <li>
              <button onclick="location.href='imageboard_form.php'">글쓰기</button>
            </li>
          <?php
          }
          ?>
        </ul>
    </div> <!-- board_box -->
  </section>
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>