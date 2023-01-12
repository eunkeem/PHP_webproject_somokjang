<div id="main_content">
  <div id="announce">
    <h4>&nbsp;공지사항</h4>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
    $sql = "select * from board order by num desc limit 5";
    $result = mysqli_query($con, $sql);
    if (!$result) {
      echo "아직 공지사항이 없습니다.";
    } else {
      while ($row = mysqli_fetch_array($result)) {
    ?>
        <ul>
          <li>
            <span><?= $row["subject"] ?></span>
            <span><?= substr($row["regist_day"], 0, 10) ?></span>
          </li>
        </ul>
    <?php
      }
    }
    ?>
  </div>
  <div id="video">
    <iframe width="560" height="315" src="https://www.youtube.com/embed/HngHgFyTSRU?start=554" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
  </div>
</div>