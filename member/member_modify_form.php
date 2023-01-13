<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>PHP프로그래밍 입문</title>
  <link rel="stylesheet" type="text/css" href="../css/common.css">
  <link rel="stylesheet" type="text/css" href="../css/member.css">
  <script src="../js/member.js"></script>

</head>

<body>
  <header><?php include "../common/header.php"; ?></header>
  <div class="register">
    <form name="member_modify_form" action="./memebr_modify_server.php" method="post">
      <h2>회원정보수정</h2>
      <label for="">아이디</label>
      <?php
      if (isset($_SESSION['userid'])) {
        $userid = $_SESSION['userid'];
        echo "<input class='input_id' type='text' placeholder='아이디' name='id' value={$userid}>";
      } else {
        echo "<input class='input_id' type='text' placeholder='아이디' name='id'>";
      }
      ?>
      <label for="">비밀번호</label>
      <input type="password" placeholder="비밀번호" name="password">

      <label for="">비밀번호확인</label>
      <input type="password" placeholder="비밀번호확인" name="password_check">

      <label for="">이메일</label>
      <?php
      if (isset($_GET['email'])) {
        $email = $_GET['email'];
        echo "<input type='text' placeholder='aaa@google.com' name='email' value={$email}>";
      } else {
        echo "<input type='text' placeholder='aaa@google.com' name='email'>";
      }
      ?>

      <div>
        <input type="button" class="btn" onclick="modify_check_input()" value="저장">
        <input type="button" class="btn" onclick="reset_form()" value="삭제">
      </div>
    </form>
  </div>
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>

</body>

</html>