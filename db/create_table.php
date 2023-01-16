<?php
function create_table($con, $table_name)
{
  //  table 체크
  $flag = false;
  $sql = "show tables from somokjang";
  $result = mysqli_query($con, $sql) or  die("테이블 보여주기 실패" . mysqli_error($con));
  while ($row = mysqli_fetch_array($result)) {
    if ($row[0] == "$table_name") {
      $flag = true;
      break;
    }
  }

  // 원하는 테이블이 없다면
  // 워크벤치에서 테이블 우클릭 send to sql editor > create statement 클릭
  // 생성된 sql 문 복사에서 가져온다. 마지막줄 utf-8뒤로 지움
  if ($flag == false) {
    switch ($table_name) {
      case 'members':
        $sql = "CREATE TABLE `members` (
        `num` int(11) NOT NULL AUTO_INCREMENT,
        `id` char(15) NOT NULL,
        `pass` varchar(255) NOT NULL,
        `name` char(10) NOT NULL,
        `email` char(80) DEFAULT NULL,
        `regist_day` char(20) DEFAULT NULL,
        `level` int(11) DEFAULT NULL,
        `point` int(11) DEFAULT NULL,
        PRIMARY KEY (`num`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        break;

      case 'board':
        $sql = "CREATE TABLE `board` (
        `num` int(11) NOT NULL AUTO_INCREMENT,
        `id` char(15) NOT NULL,
        `name` char(10) NOT NULL,
        `subject` char(200) NOT NULL,
        `content` text NOT NULL,
        `regist_day` char(20) NOT NULL,
        `hit` int(11) NOT NULL,
        `file_name` char(40) DEFAULT NULL,
        `file_type` char(40) DEFAULT NULL,
        `file_copied` char(40) DEFAULT NULL,
        PRIMARY KEY (`num`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        break;

      case 'board_reply':
        $sql = "CREATE TABLE `board_reply` (
            `num` int(11) NOT NULL AUTO_INCREMENT,
            `parent` int(11) NOT NULL, 
            `id` char(15) NOT NULL,
            `name` char(10) NOT NULL,
            `nick` char(10) NOT NULL,
            `content` text NOT NULL,
            `regist_day` char(20) DEFAULT NULL,
            PRIMARY KEY (`num`),
            KEY `regist_day` (`regist_day`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        break;

      case 'exibition':
        $sql = "CREATE TABLE `exibition` (
              `num` int(11) NOT NULL AUTO_INCREMENT,
              `subject` char(10) NOT NULL,
              `content` text NOT NULL,
              `date` char(20) DEFAULT NULL,
              `location` char(20) DEFAULT NULL,
              PRIMARY KEY (`num`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        break;

        case 'message':
          $sql = "CREATE TABLE `message` (
            `num` int(11) NOT NULL AUTO_INCREMENT,
            `send_id` char(20) NOT NULL,
            `rv_id` char(20) NOT NULL,
            `subject` char(200) NOT NULL,
            `content` text NOT NULL,
            `regist_day` char(20) DEFAULT NULL,
            PRIMARY KEY (`num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;

        case 'image_board':
          $sql = "CREATE TABLE `image_board` (
              `num` int NOT NULL AUTO_INCREMENT,
              `id` char(15) NOT NULL,
              `name` char(10) NOT NULL,
              `subject` char(200) NOT NULL,
              `content` text NOT NULL,
              `regist_day` char(20) NOT NULL,
              `hit` int NOT NULL, 
              `file_name` char(40) NOT NULL,
              `file_type` char(40) NOT NULL,
              `file_copied` char(40) NOT NULL,
              PRIMARY KEY (`num`),
              KEY `id` (`id`) 
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;

        case 'image_board_reply':
          $sql = "CREATE TABLE `image_board_reply` (
              `num` int(11) NOT NULL AUTO_INCREMENT,
              `parent` int(11) NOT NULL,
              `id` char(15) NOT NULL,
              `name` char(10) NOT NULL,
              `nick` char(10) NOT NULL,
              `content` text NOT NULL,
              `regist_day` char(20) DEFAULT NULL,
              PRIMARY KEY (`num`),
              KEY `regist_day` (`regist_day`)
            ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;";
          break;

      default:
        echo "<script>alert('해당테이블을 찾을수 없습니다.')</script>";
        break;
    }

    // $sql = "show databases sample";
    $result = mysqli_query($con, $sql) or die("데이터베이스 생성 실패" . mysqli_error($con));
    if ($result == true) {
      echo "<script>alert('{$table_name} 테이블이 생성되었습니다.')</script>";
    } else {
      echo "<script>alert('{$table_name} 테이블이 생성실패.')</script>";
    }
  }
}
