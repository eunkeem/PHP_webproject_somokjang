<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> 小 木 匠 </title>
  <link rel="stylesheet" type="text/css" href="../css/common.css">
  <link rel="stylesheet" type="text/css" href="../css/contact.css">

</head>

<body>
  <header><?php include "../common/header.php"; ?></header>
  <div id="contact">
    <div id="contact_box">
      <div>
        <h4>전화번호</h4><span>02&#45;2299&#45;9694<br></span>
      </div>
      <div>
        <h4>이메일</h4><span>E-mail:aaqu00@gmail.com</span>
      </div>
      <div>
        <h4>웹공간</h4><span>http://localhost/somokjang/index.co.kr</span>
      </div>
      <div>
        <h4>작업공간 위치</h4><span>서울시 성동구 왕십리로 315 한동타워 8층<br>315, Wangsimni-ro, Seongdong-gu, Seoul, Republic of Korea</span>
      </div>
      <div class="location">
        <!-- 카카오 지도 api사용  -->
        <div id="map" style="width:650px; height:400px;"></div>
        <!-- api키 사용 -->
        <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=	68e8af711c74c952741b25914a3cae6c"></script>
        <script>
          // 현재 위치
          let cur_location = new kakao.maps.LatLng(37.5610288807307, 127.03470402664523)
          var container = document.querySelector('#map');
          var options = {
            center: cur_location,
            level: 3
          };

          var map = new kakao.maps.Map(container, options);

          // 마커가 표시될 위치입니다 s
          var markerPosition = cur_location;

          // 마커를 생성합니다
          var marker = new kakao.maps.Marker({
            position: markerPosition
          });

          // 마커가 지도 위에 표시되도록 설정합니다
          marker.setMap(map);
        </script>

      </div>
    </div>
  </div>
  <footer>
    <?php include "../common/footer.php"; ?>
  </footer>
</body>

</html>