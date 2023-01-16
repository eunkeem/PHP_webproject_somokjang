<?php
session_start();
$userlevel = $num = $level = $point = $num_item = "";
$result_set = [];

if (!isset($_SESSION["userlevel"]) || empty($_SESSION["userlevel"])) {
  echo ("<script>
  alert('비정상적인 접근입니다.')
  location.href = 'http://{$_SERVER['HTTP_HOST']}/somokjang/index.php';
  </script>");
  exit();
} else {
  $userlevel = $_SESSION["userlevel"];
  
  if ($userlevel != 1) {
    echo ("<script>
    alert('관리자가 아닙니다! 회원정보 수정은 관리자만 가능합니다!');
    history.go(-1)
    </script>
    ");
    exit();
  }
}

include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
$mode = $_GET["mode"];

// var_dump($mode);
// exit();
switch ($mode) {
  case "update":
          if (isset($_POST["num"]) && isset($_POST["level"]) && isset($_POST["point"])) {
            $num = mysqli_real_escape_string($con, $_POST["num"]);
            $level = mysqli_real_escape_string($con, $_POST["level"]);
            $point = mysqli_real_escape_string($con, $_POST["point"]);

            $sql_same = "select * from members where num = $num ";
            $record_set = mysqli_query($con, $sql_same);

            if (mysqli_num_rows($record_set) === 1) {
              $sql_update = "update members set level  =$level, point  =$point where num = $num ";
              $result = mysqli_query($con, $sql_update);
              mysqli_close($con);
              if ($result) {
                echo ("<script>
                        alert('회원정보를 성공적으로 수정했습니다')
                        location.href = 'admin.php';
                    </script>");
                exit();
              } else {
                echo ("<script>
                        alert('회원정보 수정에 실패했습니다')
                        location.href = 'admin.php';
                    </script>");
                exit();
              }
              exit();
            } else {
              echo ("<script>
                      alert('회원정보 검색에 실패했습니다')
                      location.href = 'admin.php';
                  </script>");
              exit();
            }
          }
          break;

  case "delete":
          if (isset($_GET["num"])) {
            $num = mysqli_real_escape_string($con, $_GET["num"]);

            $sql_same = "select * from members where num = $num ";
            $record_set = mysqli_query($con, $sql_same);

            if (mysqli_num_rows($record_set) === 1) {
              $sql_delete = "delete from members where num = $num ";
              $result = mysqli_query($con, $sql_delete);
              mysqli_close($con);
              if ($result) {
                echo ("<script>
                          alert('회원정보를 성공적으로 삭제했습니다')
                          location.href = 'admin.php';
                      </script>");
                exit();
              } else {
                echo ("<script>
                          alert('회원정보 삭제에 실패했습니다')
                          location.href = 'admin.php';
                      </script>");
                exit();
              }
              exit();
            } else {
              echo ("<script>
                        alert('회원정보 검색에 실패했습니다')
                        location.href = 'admin.php';
                    </script>");
              exit();
            }
          }
          break;

  case "board_delete":
          if (isset($_POST["item"])) {
            $num_item = count($_POST["item"]);
          } else {
            echo "<script>
                      alert('삭제할 게시글을 선택해 주세요');
                      history.go(-1);
                    </script>";
            exit();
          }

          for ($i = 0; $i < $num_item; $i++) {
            $num = mysqli_real_escape_string($con, $_POST["item"][$i]);

            $sql_same = "select * from board where num = $num ";
            $result = mysqli_query($con, $sql_same);
            $row = mysqli_fetch_array($result);

            $copied_name = $row["file_copied"];

            if ($copied_name) {
              $file_path = "../data/" . $copied_name;
              unlink($file_path);
            }
            $sql_delete_board = "delete from board where num = $num";
            $result = mysqli_query($con, $sql_delete_board);
            array_push($result_set, $result);
            // array_push() 는 array를 스택으로 취급하고, array 끝에 전달되어진 변수를 집어 넣는다
            // array의 길이는 집어넣은 변수의 수만큼 증가한다. 
            // 여러개의 게시물을 삭제한 경우 쿼리문을 여러번 실행했기 때문에 그 결과를 배열로 확인

            $sql_delete_reply = "delete from board where parent = $num";
            $result = mysqli_query($con, $sql_delete_board);
            mysqli_close($con);

          }

          foreach ($result_set as $value) {
            if ($value !== true) {
              echo ("<script>
                          alert('게시물 삭제에 실패했습니다')
                          location.href = 'admin.php';
                      </script>");
              exit();
            }
          }
          echo ("<script>
            alert('게시물을 성공적으로 삭제했습니다')
            location.href = 'admin.php';
            </script>");
          exit();
          break;
}
