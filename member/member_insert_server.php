<?php
include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
$id = $password = $name = $email = "";

if (isset($_POST["id"]) && isset($_POST["password"]) && isset($_POST["name"]) && isset($_POST["email"])) {
  $id = mysqli_real_escape_string($con, $_POST["id"]);
  $password = mysqli_real_escape_string($con, $_POST["password"]);
  $password_check = mysqli_real_escape_string($con, $_POST["password_check"]);
  $name = mysqli_real_escape_string($con, $_POST["name"]);
  $email = mysqli_real_escape_string($con, $_POST["email"]);

  $user_info = "id={$id}&name={$name}&email={$email}";
  if (empty($id)) {
    header("location: member_form.php?error=아이디를 입력해 주세요&$user_info");
  } elseif (empty($password)) {
    header("location: member_form.php?error=비밀번호를 입력해 주세요");
  } elseif (empty($password_check)) {
    header("location: member_form.php?error=비밀번호확인을 입력해 주세요");
  } elseif (empty($name)) {
    header("location: member_form.php?error=이름을 입력해 주세요&$user_info");
  } elseif (empty($email)) {
    header("location: member_form.php?error=이메일을 입력해 주세요&$user_info");
  } elseif ($password !== $password_check) {
    header("location: member_form.php?error=비밀번호가 일치하지 않습니다.");
  } else {
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql_same = "select * from members where id = '$id' or email = '$email'";
    $record_set = mysqli_query($con, $sql_same);

    if (mysqli_num_rows($record_set) > 0) {
      header("location: member_form.php?error=아이디와 이메일이 존재합니다&$user_info");
      exit();
    } else {
      $sql_insert = "insert into members (id, pass, name, email, regist_day, level, point) ";
      $sql_insert .= "values ('$id', '$password', '$name', '$email', now(), 9, 0)";
      $result = mysqli_query($con, $sql_insert);
      mysqli_close($con);
      if ($result) {
        echo ("<script>
        alert('축하드립니다\\n회원정보를 성공적으로 수정했습니다')
        location.href = '..//index.php';
    </script>");
        // header("location: ../index.php?success=성공적으로 가입 되었습니다.");
        exit();
      } else {
        header("location: member_form.php?error=회원가입 실패했습니다.&$user_info");
        exit();
      }
    }
  }
} else {
  header("location: member_form.php?error=다시입력해주세요");
  exit();
}
