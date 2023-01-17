<?php
session_start();
$userid = $username = $userlevel = $userpoint = "";
if (isset($_SESSION["userid"])) {
  $userid = $_SESSION["userid"];
}
if (isset($_SESSION["username"])) {
  $username = $_SESSION["username"];
}
if (isset($_SESSION["userlevel"])) {
  $userlevel = $_SESSION["userlevel"];
}
if (isset($_SESSION["userpoint"])) {
  $userpoint = $_SESSION["userpoint"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400&family=Noto+Serif+KR:wght@300;400;500&family=Noto+Serif+TC:wght@700&display=swap" rel="stylesheet">
</head>

<body>
</body>

</html>
<div class="header_box">
  <div id="top">
    <ul id="top_menu">
      <?php
      if (!$userid) {
      ?>
        <li><a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/member/member_form.php">회원 가입</a></li>
        <li> | </li>
        <li><a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/member/login_form.php">로그인</a></li>
      <?php
      } else {
        $logged = $username . "(" . $userid . ")님 오늘도 방문해 주셔서 감사합니다";
      ?>
        <li><?= $logged ?></li>
        <li> | </li>
        <li><a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/member/logout_server.php?mode=logdout">로그아웃</a></li>
        <li> | </li>
        <li><a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/member/member_modify_form.php">정보수정</a>
        </li>
      <?php
      }
      if ($userlevel == 1) {
      ?>
        <li> | </li>
        <li><a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/admin/admin.php">관리자모드</a></li>
      <?php
      }
      ?>
    </ul>
  </div>
  <div id="menu_bar">
    <h3 id="logo">
      <a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/index.php">小 木 匠</a>
    </h3>
    <ul>
      <li><a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/about/introduce.php">소개</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/about/works.php">작품</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/imageboard/imageboard_list.php">전시안내</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/board/board_list.php">게시판</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/about/contact.php">연락</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/message/message_list.php?mode=rv">쪽지함</a></li>
    </ul>
  </div>
</div>