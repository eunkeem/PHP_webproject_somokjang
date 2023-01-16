<?php
include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
$send_id = $rv_id = $subject = $content = "";

// var_dump($_GET["mode"]);
// exit();

if (!isset($_GET["mode"])) {
  echo ("<script>
  alert('잘못된 접근입니다');
  history.go(-1);
  </script>
");
} else {
  $mode = $_GET["mode"];
}


switch ($mode) {
  case "firstmesssage":
    if (isset($_POST["send_id"]) && isset($_POST["rv_id"]) && isset($_POST["subject"]) && isset($_POST["content"])) {
      $send_id = mysqli_real_escape_string($con, $_POST["send_id"]);
      $rv_id = mysqli_real_escape_string($con, $_POST["rv_id"]);
      $subject = mysqli_real_escape_string($con, $_POST["subject"]);
      $content = mysqli_real_escape_string($con, $_POST["content"]);
      // 참고(https://www.w3schools.com/Php/php_form_validation.asp)
      // 엔티티 코드로 변환(trim, stripslashes 기능은 뺄것)
      // ENT_QUOTES : ''(홑따옴표)와 ""(곁따옴표) 둘 다 변환
      $subject = htmlspecialchars($subject, ENT_QUOTES);
      $content = htmlspecialchars($content, ENT_QUOTES);

      if (empty($rv_id)) {
        header("location: message_form.php?error=받는분 아이디를 입력해 주세요");
      } elseif (empty($subject)) {
        header("location: message_form.php?error=제목을 입력해 주세요");
      } elseif (empty($content)) {
        header("location: message_form.php?error=내용을 입력해 주세요");
      } else {
        $sql_same = "select * from members where id = '$rv_id'";
        $record_set = mysqli_query($con, $sql_same);

        if (mysqli_num_rows($record_set) === 1) {
          // 입력
          $sql_insert = "insert into message (send_id, rv_id, subject, content, regist_day) ";
          $sql_insert .= "values ('$send_id','$rv_id','$subject','$content', NOW()); ";
          // print_r($sql_insert);
          $result = mysqli_query($con, $sql_insert);
          mysqli_close($con);
          if ($result) {
            header("location: message_list.php?mode=send");
            exit();
          } else {
            header("location: message_form.php?error=전송과정에 문제가 생겼습니다<br>관리자에게 문의하세요");
            exit();
          }
        } else {
          header("location: message_form.php?error=받는 분 아이디: {$rv_id} 를 찾을 수 없습니다");
        }
      }
    } else {
      header("location: message_form.php");
    }
    break;

  case "reponse":
    if (isset($_POST["send_id"]) && isset($_POST["rv_id"]) && isset($_POST["subject"]) && isset($_POST["content"])) {
      $send_id = mysqli_real_escape_string($con, $_POST["send_id"]);
      $rv_id = mysqli_real_escape_string($con, $_POST["rv_id"]);
      $subject = mysqli_real_escape_string($con, $_POST["subject"]);
      $content = mysqli_real_escape_string($con, $_POST["content"]);
      // 참고(https://www.w3schools.com/Php/php_form_validation.asp)
      // 엔티티 코드로 변환(trim, stripslashes 기능은 뺄것)
      // ENT_QUOTES : ''(홑따옴표)와 ""(곁따옴표) 둘 다 변환
      $subject = htmlspecialchars($subject, ENT_QUOTES);
      $content = htmlspecialchars($content, ENT_QUOTES);

     if (empty($subject)) {
        header("location: message_reponse_form.php?error=제목을 입력해 주세요");
      } elseif (empty($content)) {
        header("location: message_reponse_form.php?error=내용을 입력해 주세요");
      } else {
          // 입력
          $sql_insert = "insert into message (send_id, rv_id, subject, content, regist_day) ";
          $sql_insert .= "values ('$send_id','$rv_id','$subject','$content', NOW()); ";
          // print_r($sql_insert);
          $result = mysqli_query($con, $sql_insert);
          mysqli_close($con);
          if ($result) {
            header("location: message_list.php?mode=rv");
            exit();
          } else {
            header("location: message_reponse_form.php?error=전송과정에 문제가 생겼습니다<br>관리자에게 문의하세요");
            exit();
          }
       
      }
    } else {
      header("location: message_reponse_form.php");
    }
    break;
}
