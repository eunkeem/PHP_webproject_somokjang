<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> 小 木 匠 </title>
  <link rel="stylesheet" type="text/css" href="../css/common.css">
  <link rel="stylesheet" type="text/css" href="../css/imgboard.css">

</head>

<body>
  <header><?php include "../common/header.php"; ?></header>
  <div class="works">
    <h3>
      전시안내 > 목록보기
    </h3>
    <ul class="works_box">
      <?php
      include "../db/db_connector.php";

      if (isset($_GET["page"])) {
        $page = $_GET["page"];
      } else {
        $page = 1;
      }

      $sql = "select count(*) from image_board order by num desc";
      $result = mysqli_query($con, $sql);
      $row    = mysqli_fetch_array($result);
      $total_record = intval($row[0]); // 전체 글 수
      if ($total_record == 0) {
        if ($userlevel == 1) {
          header("location: http://{$_SERVER['HTTP_HOST']}/somokjang/imageboard/imageboard_form.php");
        }
        echo ("<script>
          alert('아직 기획된 전시가 없습니다');
          history.go(-1);
        </script>
        ");
        exit;
      }

      $scale = 3;
      $total_page = ceil($total_record / $scale);

      // 표시할 페이지($page)에 따라 $start 계산  
      $start = ($page - 1) * $scale;
      $number = $total_record - $start;

      //현재페이지 레코드 결과값을 저장하기 위해서 배열선언
      $list = array();

      $sql = "select * from image_board order by num desc LIMIT $start, $scale";
      $result = mysqli_query($con, $sql);
      $i = 0;
      while ($row = mysqli_fetch_array($result)) {
        // $list[0]["num"] ~$list[0]["file_copied"]
        // $list[1]["num"] ~$list[1]["file_copied"]
        // $list[2]["num"] ~$list[2]["file_copied"]이차원 배열
        $list[$i] = $row;
        //번호순서
        $list_num = $total_record - ($page - 1) * $scale;
        $list[$i]['no'] = $list_num - $i;
        $i++;
      }

      for ($i = 0; $i < count($list); $i++) {
        $file_image = (!empty($list[$i]['file_name'])) ? "<img src='../img/no-image.png'>" : " ";
        $date = substr($list[$i]['regist_day'], 0, 10);
        // 이미지 파일명이 있다면 if문 진행
        if (!empty($list[$i]['file_name'])) {
          // 실재 이미지 사이즈 정보를 가져옴
          $image_info = getimagesize("../data/" . $list[$i]['file_copied']);
          $image_width = 224;
          $image_height = 320;
          $image_type = $image_info[2];
          $file_copied = $list[$i]['file_copied'];
        }
      ?>
        <li>
          <div class="img_container">
            <a href="imageboard_view.php?num=<?= $list[$i]['num'] ?>&page=<?= $page ?>">
              <?php
              // file_type에 'image' 문자열이 포함돼 있으면 if문 실행
              if (strpos($list[$i]['file_type'], "image") !== false) {
                echo "<img src='../data/$file_copied' width='$image_width' height='$image_height'><br>";
              } else {
                // x 표시 gif 파일 하나 넣어두고 불러올 것
                echo "<img src='../img/no-image.png' width=200 height=200><br>";
              }
              ?></a>
          </div>

          <table>
            <tr>
              <th>제목</th>
              <td><em> <?= $list[$i]['subject'] ?></em>&nbsp;&nbsp;등록일 : <em><?= $date ?> </em></td>
            </tr>
            <tr>
              <th>전시기간</th>
              <td><em> <?= $list[$i]['exibition_date'] ?> </em></td>
            </tr>
            <tr>
              <th>전시위치</th>
              <td><em> <?= $list[$i]['location'] ?> </em></td>
            </tr>
          </table>
        </li>
      <?php
      } //end of for
      mysqli_close($con);
      ?>
    </ul>
    <ul id="page_num">
      <?php
      include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/common/get_paging.php";
      $url = "imageboard_list.php?page=1";
      echo get_paging1(3, $page, $total_page, $url);
      ?>
    </ul> <!-- page -->
    <ul class="buttons">
      <li>
        <?php
        if ($userlevel == 1) {
        ?>
          <button onclick="location.href='imageboard_form.php'">글쓰기</button>
        <?php
        }
        ?>
      </li>
    </ul>
  </div>
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>

</body>

</html>