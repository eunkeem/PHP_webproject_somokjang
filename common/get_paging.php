<?php
/**  여러 페이지가 나오는 게시판에 페이지 숫자 출력하는 두가지 함수*/

// $write_page : 보여줄 페이지 숫자 예)1~10 씩 끊어서
// $current_page : 현재페이지
// $total_page : 전체페이지
// $url : 'message_box.php?mode=$mode&page=$new_page'
function get_paging1($write_page, $current_page, $total_page, $url)
{
  // URL 변형 예) 'message_box.php?mode=$mode&page=123' → 'message_box.php?mode=$mode&page='
  $url = preg_replace('/page=[0-9]/', '', $url) . 'page=';

  // 0. 페이징 시작
  $str = '';

  // 1. 2페이지부터 '처음(<<)' 가기 표시
  ($current_page > 1) ? ($str .= '<a href="' . $url . '1" ><<</a>' . PHP_EOL) : ''; // 'PHP_EOL' = \n

  // 2. 시작 페이지와 끝 페이지를 정한다.(= 정하기만 한다.)
  $start_page = (((int)(($current_page - 1) / $write_page)) * $write_page) + 1;
  $end_page = $start_page + $write_page - 1;
  if ($end_page >= $total_page) $end_page = $total_page;

  // 3. 11페이지부터 '이전(<)' 가기 표시
  if ($start_page > 1) $str .= '<a href="' . $url . ($start_page - 1) . '"><</a>' . PHP_EOL;

  // 4. (총 페이지가 2페이지 이상일 경우부터) 시작 페이지와 끝 페이지를 등록한다.(= 페이지를 만드는 구문에 직접 추가한다.)
  if ($total_page > 1) {
    for ($k = $start_page; $k <= $end_page; $k++) {
      if ($current_page != $k)
        $str .= '<a href="' . $url . $k . '" class="">' . $k . '</a>' . PHP_EOL;
      else
        $str .= '<span style="color:blue">' . $k . '</span>' . PHP_EOL;
    }
  }

  // 5. 총 페이지가 마지막 페이지보다 클 경우, '다음(>)' 가기 표시
  // 예) 20페이지에서 다음을 누르면 21페이지로 이동
  if ($total_page > $end_page) $str .= '<a href="' . $url . ($end_page + 1) . '">></a>' . PHP_EOL;

  // 6. 현재 페이지가 총 페이지보다 작을 경우, '마지막(>>)' 가기 표시
  if ($current_page < $total_page) {
    $str .= '<a href="' . $url . $total_page . '" >>></a>' . PHP_EOL;
  }

  // 7. 페이지 등록
  if ($str)
    return "<li><span>{$str}</span></li>";
  else
    return "";
}

function get_paging2($current_page, $total_page, $url)
{
  // URL 변형
  // 예) 'message_box.php?mode=$mode&page=123' → 'message_box.php?mode=$mode&page='
  $url = preg_replace('/&page=[0-9]/', '', $url) . '&amp;page=';
  // 0. 페이징 시작
  $str = '';

  //  ◀ 이전
  if ($total_page >= 2 && $current_page >= 2) {
    $new_page = $current_page - 1;
    $str .= '<a href="' . $url . $new_page . '" >' . PHP_EOL;
    echo "<li>" . $str . "◀ 이전</a> </li>";
  } else {
    echo "<li>&nbsp;</li>";
  }

  // 페이지넘버
  for ($i = 1; $i <= $total_page; $i++) {
    if ($current_page == $i) {
      echo "<li><b style = 'color: blue;'>" . $i . " </b></li>";
    } else {
      $str .= '<a href="' . $url . $i . '" >' . PHP_EOL;
      echo "<li>" . $str . $i . "</a> <li>";
    }
  }

   //  다음 ▶
   if ($total_page >= 2 && $current_page != $total_page) {
    $new_page = $current_page + 1;
    $str .= '<a href="' . $url . $new_page . '" >' . PHP_EOL;
    echo "<li>" . $str . "다음 ▶</a> </li>";
  } else {
    echo "<li>&nbsp;</li>";
  }
}