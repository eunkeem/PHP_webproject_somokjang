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
  <div id="exibition">
    <!-- onload="poster_slide_js()" -->
    <h4>&nbsp;최근전시</h4>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
    $list = array();
    $sql = "select * from image_board order by num desc LIMIT 1";
    $result = mysqli_query($con, $sql);
    $list[0] = mysqli_fetch_array($result);
    if (!empty($list[0]['file_name'])) {
      // 실재 이미지 사이즈 정보를 가져옴
      $file_copied = $list[0]['file_copied'];
      $num = $list[0]['num'];
      $subject = $list[0]['subject'];
    }
    ?>
    <div class="posterslideshow">
      <div class="posterslideshow_slide">
        <a href="./imageboard/imageboard_view.php?num=<?= $num ?>"><img src="./data/<?= $file_copied ?>" width="180" alt="<?= $subject ?>" /></a>
      </div>
    </div>
    <?php


    mysqli_close($con);
    ?>
  </div>
  <div id=" video">
    <iframe width="560" height="309" src="https://www.youtube.com/embed/HngHgFyTSRU?start=554" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
  </div>
</div>