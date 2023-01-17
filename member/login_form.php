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
    <form name="login_form" action="./login_server.php" method="post">
      <h2>로그인</h2>
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
      </div>
      <label for="">비밀번호</label>
      <input type="password" placeholder="비밀번호" name="password">
      <div>
        <input type="button" class="btn" onclick="login_check_input()" value="로그인">
      </div>
    </form>
  </div>
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>