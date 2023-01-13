<?php
session_start();
if (!isset($_SESSION["userid"]) || empty($_SESSION["userid"])) {
  echo ("<script>
            alert('비정상적인 접근입니다.')
            location.href = 'http://{$_SERVER['HTTP_HOST']}/somokjang/index.php';
        </script>");
  exit();
}
unset($_SESSION["userid"]);
unset($_SESSION["username"]);
unset($_SESSION["userlevel"]); 
unset($_SESSION["userpoint"]);

header("location: http://{$_SERVER['HTTP_HOST']}/somokjang/index.php");

