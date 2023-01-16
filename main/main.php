<div id="main_content">
  <div id="announce">
    <h4>&nbsp;공지사항</h4>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
    $sql = "select * from board where id = 'admin' order by num desc limit 5";
    $result = mysqli_query($con, $sql);
    if (!$result) {
      echo "아직 공지사항이 없습니다.";
    } else {
      while ($row = mysqli_fetch_array($result)) {
    ?>
        <ul>
          <li>
            <span><a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/board/board_view.php?num=<?= $row['num'] ?>"><?= $row["subject"] ?></a></span>
            <span><?= substr($row["regist_day"], 0, 10) ?></span>
          </li>
        </ul>
    <?php
      }
    }
    ?>
  </div>
  <div id="announce">
    <h4>&nbsp;전시</h4>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
    $sql = "select * from image_board limit 3";
    $result = mysqli_query($con, $sql);
    if (!$result) {
      echo "아직 기획된 전시가 없습니다.";
    } else {
      while ($row = mysqli_fetch_array($result)) {
        $num = $row["num"];
        $subject = $row["subject"];
        $file_name = $row["file_name"];
        $file_type = $row["file_type"];
        $file_copied = $row["file_copied"];
        $content = str_replace(" ", "&nbsp;", $content);
        $content = str_replace("\n", "<br>", $content);

        $file_copied = $row['file_copied'];
        $file_type = $row['file_type'];
        //이미지 정보를 가져오기 위한 함수 width, height, type
        if (!empty($file_name)) {
          $image_info = getimagesize("../data/" . $file_copied);
          $image_width = $image_info[0];
          $image_height = $image_info[1];
        }

    ?>
        <div class="posterslideshow">
          <div class="posterslideshow_slide">
            <a href="../imageboard/imageboard_view.php?num="><img src="../data/<?= $file_copied ?>" width="210" alt="<?= $subject ?>" /></a>
          </div>
        </div>
    <?php
      }
    }
    ?>
  </div>
  <div id=" video">
    <iframe width="560" height="315" src="https://www.youtube.com/embed/HngHgFyTSRU?start=554" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
  </div>
</div>