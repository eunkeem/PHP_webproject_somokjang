<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> 小 木 匠 </title>
  <link rel="stylesheet" type="text/css" href="../css/common.css">
  <link rel="stylesheet" type="text/css" href="../css/member.css">
  <script src="../js/member.js"></script>
</head>

<body>
  <header><?php include "../common/header.php"; ?></header>
  <div class="register">
    <form name="member_form" action="./member_insert_server.php" method="post">
      <h2>회원가입</h2>
      <?php
      if (isset($_GET['error'])) {
        echo "<p class = 'error'>{$_GET['error']}</p>";
      }
      if (isset($_GET['success'])) {
        echo "<p class = 'success'>{$_GET['success']}</p>";
      }
      ?>
      <label for="">아이디</label>
      <div class="input_id_box">
        <?php
        if (isset($_GET['id'])) {
          $id = $_GET['id'];
          echo "<input class='input_id' type='text' placeholder='아이디' name='id' value={$id}>";
        } else {
          echo "<input class='input_id' type='text' placeholder='아이디' name='id'>";
        }
        ?>
        <input type="button" class="btn" onclick="check_id()" value="중복확인">
      </div>
      <label for="">비밀번호</label>
      <input type="password" placeholder="비밀번호" name="password">
      <label for="">비밀번호확인</label>
      <input type="password" placeholder="비밀번호확인" name="password_check">
      <label for="">이름</label>
      <?php
      if (isset($_GET['name'])) {
        $name = $_GET['name'];
        echo "<input type='text' placeholder='이름' name='name' value={$name}>";
      } else {
        echo "<input type='text' placeholder='이름' name='name'>";
      }
      ?>

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
        <input type="button" class="btn" onclick="check_input()" value="저장">
        <input type="button" class="btn" onclick="reset_form()" value="삭제">
      </div>
    </form>
  </div>
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>