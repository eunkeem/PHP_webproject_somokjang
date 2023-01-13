<?php
session_start();
$userid = $username = $subject = $content = "";
$upfile_name = $upfile_tmp_name = $upfile_type = $upfile_size = $upfile_error = "";
$file = $file_ext = $new_file_name = $copy_file_name = $uploaded_file = "";

if (!isset($_SESSION["userid"]) || empty($_SESSION["userid"]) || !isset($_SESSION["username"]) || empty($_SESSION["username"])) {
  echo ("
  <script>
  alert('게시판 글쓰기는 로그인 후 이용 가능합니다 \n 로그인 페이지로 이동합니다');
  location.href = 'http://{$_SERVER['HTTP_HOST']}/source20230105/login/login.php';
  </script>
  ");
  exit();
} else {
  $userid = $_SESSION["userid"];
  $username = $_SESSION["username"];
}

include "../db/db_connector.php";
$mode = $_GET["mode"];

switch ($mode) {
  case "board_insert":
    if (isset($_POST["subject"]) && isset($_POST["content"])) {
      $subject = mysqli_real_escape_string($con, $_POST["subject"]);
      $content = mysqli_real_escape_string($con, $_POST["content"]);
      // 참고(https://www.w3schools.com/Php/php_form_validation.asp)
      // 엔티티 코드로 변환(trim, stripslashes 기능은 뺄것)
      // ENT_QUOTES : ''(홑따옴표)와 ""(곁따옴표) 둘 다 변환
      $subject = htmlspecialchars($subject, ENT_QUOTES);
      $content = htmlspecialchars($content, ENT_QUOTES);

      $upload_dir = '../data/';

      // form에서 input type을 file로 지정하면 $_FILES로 넘어옴
      // $_FILES 안에는 upfile이라는 array(5)가 있음
      $upfile_name     = $_FILES["upfile"]["name"];
      $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
      $upfile_type     = $_FILES["upfile"]["type"];
      $upfile_size     = $_FILES["upfile"]["size"];
      // 에러가 없으면 0 -> false
      $upfile_error    = $_FILES["upfile"]["error"];

      // !0 -> true
      if ($upfile_name && !$upfile_error) {
        $file = explode(".", $upfile_name);
        $file_name = $file[0];
        $file_ext = $file[1];
        //2023_01_10_08_10_10flower.png ->중복되지 않는 파일명
        $copied_file_name = date("Y_m_d_H_i_s") . "." . $file_ext;
        $uploaded_file = $upload_dir . $copied_file_name;

        // 용량제한이 걸릴 경우 php.ini 를 열어서 upload_max_file 용량을 바꾸고 저장하고 서버껐다 켠다.
        if ($upfile_size > 1000000) {
          echo ("<scipt>
                  alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다<br>파일크기를 확인해 주세요');
                  history.go(-1)      
                  </scipt>");
          exit();
        }
        //"C:\xampp\tmp\phpBFFC.tmp" -> ../data/2023_01_10_08_10_10flower.png
        // 임시로 저장돼있던 파일을 중복되지 않는 이름으로 지정한 디렉토리에 이동.
        if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
          echo ("<script>
                  alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다');
                  history.go(-1)
                </script>");
          exit();
        }
      } //첨부파일 조건문

      // 2023_01_10_08_10_10flower.png 로 저장 나중에 디렉토리 앞에 적어줘야 함
      $sql_insert = "insert into board(id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied)";
      $sql_insert .= "values('$userid','$username','$subject','$content',NOW(),0,'$upfile_name','$upfile_type','$copied_file_name')";
      $result = mysqli_query($con, $sql_insert);

      // 유저 포인트 올리기(members 테이블)
      $point_up = 100;

      $sql_select = "select point from members where id = '$userid'";
      $result = mysqli_query($con, $sql_select);
      $row = mysqli_fetch_array($result);

      $new_point = $row["point"] + $point_up;
      $sql_update = "update members set point = $new_point where id = '$userid'";
      mysqli_query($con, $sql_update);

      mysqli_close($con);

      // insert가 잘 됐는지 점검 조건문
      if ($result) {
        echo ("<script>
                alert('게시물이 성공적으로 업로드 되었습니다.');
                location.href = 'board_list.php';
              </script>");
        exit();
      } else {
        echo ("<script>
                alert('게시물 업로드 실패했습니다 <br> 서버 관리자에게 문의하세요');
                location.href = 'board_list.php';
              </script>");
        exit();
      }
    } else {
      echo ("<scipt>
              alert('입력값을 가져오지 못했습니다. 확인해 주세요');
              history.go(-1)      
            </scipt>");
      exit();
    }
    break;

  case "reply_insert":
    if (empty($_POST["reply_content"])) {
      echo "<script>alert('내용입력요망!');history.go(-1);</script>";
      exit;
    }
    //"덧글을 다는사람은 로그인을 해야한다." 말한것이다.
    $q_userid = mysqli_real_escape_string($con, $userid);
    $sql = "select * from members where id = '$q_userid'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
      die('Error: ' . mysqli_error($con));
    }
    $rowcount = mysqli_num_rows($result);

    if (!$rowcount) {
      echo "<script>alert('없는 아이디!!');history.go(-1);</script>";
      exit;
    } else {
      $content = mysqli_real_escape_string($con, $_POST["reply_content"]);
      $page = mysqli_real_escape_string($con, $_POST["page"]);
      $parent = mysqli_real_escape_string($con, $_POST["parent"]);
      $hit = mysqli_real_escape_string($con, $_POST["hit"]);
      $q_usernick = isset($_SESSION['usernick']) ? mysqli_real_escape_string($con, $_SESSION['usernick']) : null;
      $q_username = mysqli_real_escape_string($con, $_SESSION['username']);
      $q_content = mysqli_real_escape_string($con, $content);
      $q_parent = mysqli_real_escape_string($con, $parent);
      $regist_day = date("Y-m-d (H:i)");
      $sql = "INSERT INTO `board_reply` VALUES (null,'$q_parent','$q_userid','$q_username', '$q_usernick','$q_content','$regist_day')";
      $result = mysqli_query($con, $sql);
      if (!$result) {
        die('Error: ' . mysqli_error($con));
      }
      mysqli_close($con);
      echo "
              <script>
                location.href='./board_view.php?num=$parent&page=$page&hit=$hit';
              </script>
              ";
    } //end of if rowcount
    break;
}
