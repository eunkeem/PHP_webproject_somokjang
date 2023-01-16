<?php
include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
session_start();

if (!isset($_SESSION["userid"]) || empty($_SESSION["userid"]) || !isset($_SESSION["username"]) || empty($_SESSION["username"])) {
  echo ("
  <script>
  alert('이미지게시판 글쓰기는 로그인 후 이용해 주세요!');
  history.go(-1)
  </script>
");
  exit;
} else {
  $userid = $_SESSION["userid"];
  $username = $_SESSION["username"];
}


if (isset($_POST["mode"]) && $_POST["mode"] === "delete") {
  $num = $_POST["num"];
  $page = $_POST["page"];
  $sql = "select * from image_board where num = $num";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);
  $writer = $row["id"];


  $copied_name = $row["file_copied"];

  if ($copied_name) {
    $file_path = "../data/" . $copied_name;
    unlink($file_path);
  }

  $sql = "delete from image_board where num = $num";
  mysqli_query($con, $sql);

  // 게시물 삭제시 댓글도 삭제 
  $sql = "delete from image_board_reply where parent = $num";
  mysqli_query($con, $sql);

  mysqli_close($con);
  echo "
        <script>
            location.href = 'imageboard_list.php?page=$page';
        </script>
        ";
} else if (isset($_POST["mode"]) && $_POST["mode"] === "insert") {
  $subject = $_POST["subject"];
  $content = $_POST["content"];
  $subject = htmlspecialchars($subject, ENT_QUOTES);
  $content = htmlspecialchars($content, ENT_QUOTES);
  $regist_day = date("Y-m-d (H:i)");
  $upload_dir = "../data/";

  $upfile_name = $_FILES["upfile"]["name"];
  $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
  $upfile_type = $_FILES["upfile"]["type"];
  $upfile_size = $_FILES["upfile"]["size"];
  $upfile_error = $_FILES["upfile"]["error"];

  if ($upfile_name && !$upfile_error) { // 업로드가 잘되었는지 판단
    $file = explode(".", $upfile_name);
    $file_name = $file[0]; //(memo)
    $file_ext = $file[1]; //(sql)

    // $new_file_name = date("Y_m_d_H_i_s");
    // $new_file_name = $new_file_name . "_" . $file_name;
    // $copied_file_name = $new_file_name . "." . $file_ext;
    // $uploaded_file = $upload_dir . $copied_file_name;
    $copied_file_name = date("Y_m_d_H_i_s") . "." . $file_ext;
    $uploaded_file = $upload_dir . $copied_file_name;
    if ($upfile_size > 1000000) {
      echo ("
            <script>
            alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
            history.go(-1)
            </script>
				  ");
      exit;
    }

    if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
      echo ("
            <script>
            alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
            history.go(-1)
            </script>
  				");
      exit;
    }
  } else {
    $upfile_name = "";
    $upfile_type = "";
    $copied_file_name = "";
  }

  $sql = "insert into image_board (id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied) ";
  $sql .= "values('$userid', '$username', '$subject', '$content', '$regist_day', 0, ";
  $sql .= "'$upfile_name', '$upfile_type', '$copied_file_name')";
  mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행

  // 포인트 부여하기
  $point_up = 100;

  $sql = "select point from members where id='$userid'";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);
  $new_point = $row["point"] + $point_up;

  $sql = "update members set point=$new_point where id='$userid'";
  mysqli_query($con, $sql);
  mysqli_close($con);

  header("location: imageboard_list.php");
  exit();
} else if (isset($_POST["mode"]) && $_POST["mode"] === "modify") {
  $num = $_POST["num"];
  $page = $_POST["page"];
  $subject = mysqli_real_escape_string($con, $_POST["subject"]);
  $content = mysqli_real_escape_string($con, $_POST["content"]);
  $subject = htmlspecialchars($subject, ENT_QUOTES);
  $content = htmlspecialchars($content, ENT_QUOTES);
  // 기존파일 삭제 클릭
  if (isset($_POST['item'])) {
    $file_name = $_POST['item'];
    $sql_select = "select * from image_board where file_name = '$file_name'";
    $result = mysqli_query($con, $sql_select);
    $row = mysqli_fetch_array($result);

    $copied_name = $row["file_copied"];
    // 기존 파일이 있다면 삭제 
    if ($copied_name) {
      $file_path = "../data/" . $copied_name;
      unlink($file_path);
    }

    // 새로운 첨부파일 업로드
    $upload_dir = '../data/';
    $upfile_name     = $_FILES["upfile"]["name"];
    $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
    $upfile_type     = $_FILES["upfile"]["type"];
    $upfile_size     = $_FILES["upfile"]["size"];
    $upfile_error    = $_FILES["upfile"]["error"];

    if ($upfile_name && !$upfile_error) {
      $file = explode(".", $upfile_name);
      $file_name = $file[0];
      $file_ext = $file[1];
      $copied_file_name = date("Y_m_d_H_i_s") . "." . $file_ext;
      $uploaded_file = $upload_dir . $copied_file_name;

      if ($upfile_size > 1000000) {
        echo ("<scipt>
                  alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다<br>파일크기를 확인해 주세요');
                  history.go(-1)      
                  </scipt>");
        exit();
      }
      if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
        echo ("<script>
                  alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다');
                  history.go(-1);
                </script>");
        exit();
      }
    } //기존파일삭제클릭



    // update 쿼리
    $sql_update = "update image_board set subject='$subject', content ='$content', regist_day=NOW(), file_name='$upfile_name',";
    $sql_update .= " file_type = '$upfile_type', file_copied = '$copied_file_name'";
    $sql_update .= "where num = $num";
    $result = mysqli_query($con, $sql_update);

    mysqli_close($con);

    // update가 잘 됐는지 점검 조건문
    if ($result) {
      echo ("<script>
                alert('게시물이 성공적으로 수정 되었습니다.');
                location.href = 'imageboard_list.php';
              </script>");
      exit();
    } else {
      echo ("<script>
                alert('게시물 업로드 실패했습니다 <br> 서버 관리자에게 문의하세요');
                location.href = 'imageboard_list.php';
              </script>");
      exit();
    }
  }
  // 첨부파일 변경 없이 update
  $sql_update = "update board set subject='$subject', content ='$content', regist_day=NOW() ";
  $sql_update .= "where num = $num";
  $result = mysqli_query($con, $sql_update);

  mysqli_close($con);

  // update가 잘 됐는지 점검 조건문
  if ($result) {
    echo ("<script>
            alert('게시물이 성공적으로 수정 되었습니다.');
            location.href = 'imageboard_list.php';
          </script>");
    exit();
  } else {
    echo ("<script>
            alert('게시물 업로드 실패했습니다 <br> 서버 관리자에게 문의하세요');
            location.href = 'imageboard_list.php';
          </script>");
    exit();
  }
} else if (isset($_POST["mode"]) && $_POST["mode"] == "insert_reply") {
  if (empty($_POST["ripple_content"])) {
    echo "<script>alert('내용입력요망!');
            history.go(-1);
            </script>";
    exit;
  }

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
    $content = mysqli_real_escape_string($con, $_POST["ripple_content"]);
    $page = mysqli_real_escape_string($con, $_POST["page"]);
    $parent = mysqli_real_escape_string($con, $_POST["parent"]);
    $hit = mysqli_real_escape_string($con, $_POST["hit"]);
    $q_usernick = isset($_SESSION['usernick']) ? mysqli_real_escape_string($con, $_SESSION['usernick']) : null;
    $q_username = mysqli_real_escape_string($con, $_SESSION['username']);
    $q_content = mysqli_real_escape_string($con, $content);
    $q_parent = mysqli_real_escape_string($con, $parent);
    $regist_day = date("Y-m-d (H:i)");

    $sql = "INSERT INTO `image_board_reply` VALUES (null,'$q_parent','$q_userid','$q_username', '$q_usernick','$q_content','$regist_day')";
    $result = mysqli_query($con, $sql);
    if (!$result) {
      die('Error: ' . mysqli_error($con));
    }
    mysqli_close($con);
    echo "
            <script>
              location.href='./imageboard_view.php?num=$parent&page=$page&hit=$hit';
            </script>
            ";
  } //end of if rowcount
} else if (isset($_POST["mode"]) && $_POST["mode"] == "delete_reply") {
  $page = mysqli_real_escape_string($con, $_POST["page"]);
  $hit = mysqli_real_escape_string($con, $_POST["hit"]);
  $num = mysqli_real_escape_string($con, $_POST["num"]);
  $parent = mysqli_real_escape_string($con, $_POST["parent"]);
  $q_num = mysqli_real_escape_string($con, $num);

  $sql = "DELETE FROM `image_board_reply` WHERE num=$q_num";
  $result = mysqli_query($con, $sql);
  if (!$result) {
    die('Error: ' . mysqli_error($con));
  }
  mysqli_close($con);
  echo "
        <script>
          location.href='./imageboard_view.php?num=$parent&page=$page&hit=$hit';</script>";
}
