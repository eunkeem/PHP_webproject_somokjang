<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
$id = $password = "";

if (isset($_POST["id"]) && isset($_POST["password"])) {
  $id = mysqli_real_escape_string($con, $_POST["id"]);
  $password = mysqli_real_escape_string($con, $_POST["password"]);

  $user_info = "id={$id}";
  if (empty($id)) {
    header("location: login_form.php?error=아이디를 입력해 주세요&$user_info");
  } elseif (empty($password)) {
    header("location: login_form.php?error=비밀번호를 입력해 주세요&$user_info");
  } else {
    $sql_same = "select * from members where id = '$id' ";
    $record_set = mysqli_query($con, $sql_same);

    if (mysqli_num_rows($record_set) === 1) {
      $row = mysqli_fetch_assoc($record_set);
      $hash_value = $row["pass"];

      if (password_verify($password, $hash_value)) {
        $_SESSION["userid"] = $row["id"];
        $_SESSION["username"] = $row["name"];
        $_SESSION["userlevel"] = $row["level"];
        $_SESSION["userpoint"] = $row["point"];
        mysqli_close($con);
        header("location: http://" . $_SERVER['HTTP_HOST'] . "/somokjang/index.php");
        exit();
      } else {
        echo ("<script>
              alert('비밀번호가 일치하지 않습니다')
              location.href = './login_form.php?&$user_info';
            </script>");
        exit();
      }
    } else {
      echo ("<script>
              alert('아이디가 존재하지 않습니다')
              location.href = './login_form.php?&$user_info';
            </script>");
      exit();
    }
  }
} else {
  echo ("<script>
              alert('빈칸을 모두 채워주세요')
              location.href = './login_form.php?&$user_info';
            </script>");
  exit();
  exit();
}
