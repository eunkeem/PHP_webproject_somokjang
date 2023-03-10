<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/create_statement.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> 小 木 匠 </title>
  <!-- slideshow -->
  <link rel="stylesheet" href="./css/slideshow.css" />
  <script src="./js/slideshow.js" defer></script>
  <script src="https://kit.fontawesome.com/9ea4e4b901.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400&family=Noto+Serif+KR:wght@300;400;500&family=Noto+Serif+TC:wght@700&display=swap" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/css/main.css">
  <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST']; ?>/somokjang/css/common.css">

</head>

<body>
  <header>
    <?php include "./common/header.php"; ?>
  </header>
  <section>
    <?php include "./main/slideshow.php"; ?>
  </section>
  <section>
    <?php include "./main/main.php"; ?>
  </section>
  <footer>
    <?php include "./common/footer.php"; ?>
  </footer>
</body>

</html>