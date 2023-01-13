<?php
include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
session_start();
$id = $password = $email = "";

if (isset($_POST["id"]) && isset($_POST["password"]) && isset($_POST["email"])) {
  $id = mysqli_real_escape_string($con, $_POST["id"]);
  $password = mysqli_real_escape_string($con, $_POST["password"]);
  $password_check = mysqli_real_escape_string($con, $_POST["password_check"]);
  $email = mysqli_real_escape_string($con, $_POST["email"]);

  $user_info = "id={$id}&email={$email}";
  if (empty($id)) {
    header("location: member_modify_form.php?error=아이디를 입력해 주세요&$user_info");
  } elseif (empty($password)) {
    header("location: member_modify_form.php?error=비밀번호를 입력해 주세요$user_info");
  } elseif (empty($password_check)) {
    header("location: member_modify_form.php?error=비밀번호확인을 입력해 주세요$user_info");
  } elseif (empty($email)) {
    header("location: member_modify_form.php?error=이메일을 입력해 주세요&$user_info");
  } elseif ($password !== $password_check) {
    header("location: member_modify_form.php?error=비밀번호가 일치하지 않습니다.");
  } else {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql_same = "select * from members where id = '$id' ";
    $record_set = mysqli_query($con, $sql_same);

    if (mysqli_num_rows($record_set) === 1) {
      $sql_update = "update members set pass='$password', email='$email' where id ='$id' ";
      $result = mysqli_query($con, $sql_update);
      mysqli_close($con);
      if ($result) {
        // header("location: ../index.php");
        echo ("<script>
                alert('회원정보를 성공적으로 수정했습니다')
                location.href = '../index.php';
              </script>");
      } else {
        echo ("<script>
        alert('회원정보 수정에 오류가 발생했습니다 \\n 서버 관리자에게 문의하세요')
        location.href = './member_modify_form.php';
      </script>");
      }
      exit();
    } else {
      echo ("<script>
      alert('회원정보 검색에 실패했습니다 \\n 서버 관리자에게 문의하세요')
      location.href = './member_modify_form.php';
    </script>");
    exit();
    }
  }
} else {
  echo ("<script>
      alert('빈칸을 모두  채워주세요')
      location.href = './member_modify_form.php';
    </script>");
    exit();
}
