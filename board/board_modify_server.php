<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
$num = $page = $subject = $content = "";

if (isset($_POST["num"]) && isset($_POST["page"]) && !empty($_POST["num"]) && !empty($_POST["page"])) {
  $num = $_POST["num"];
  $page = $_POST["page"];
} else {
  echo ("
  <script>
  alert('잘못된 접근입니다');
  history.go(-1);
  </script>
  ");
  exit();
}

// update
if (isset($_POST["subject"]) && isset($_POST["content"])) {
  $subject = mysqli_real_escape_string($con, $_POST["subject"]);
  $content = mysqli_real_escape_string($con, $_POST["content"]);
  $subject = htmlspecialchars($subject, ENT_QUOTES);
  $content = htmlspecialchars($content, ENT_QUOTES);

  // 기존파일 삭제 클릭
  if (isset($_POST['item'])) {
    $file_name = $_POST['item'];
    $sql_select = "select * from board where file_name = '$file_name'";
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
    $sql_update = "update board set subject='$subject', content ='$content', regist_day=NOW(), file_name='$upfile_name',";
    $sql_update .= " file_type = '$upfile_type', file_copied = '$copied_file_name'";
    $sql_update .= "where num = $num";
    $result = mysqli_query($con, $sql_update);

    mysqli_close($con);

    // update가 잘 됐는지 점검 조건문
    if ($result) {
      echo ("<script>
                alert('게시물이 성공적으로 수정 되었습니다.');
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
