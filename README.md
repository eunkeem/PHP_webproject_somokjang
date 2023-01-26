# somokjang (personal project)
</br></br>
## Summary
>한국전통가구 작가의 웹사이트를 HTML, CSS, PHP, MySQL을 이용해 제작</br>
구현 기능 : 회원가입, 로그인, 관리자 모드, 메시지, 일반 게시판, 이미지 게시판, 회원정보 수정, 게시물 수정, 트리거를 이용한 삭제데이터 백업</br>


>Produced a website for Korean traditional furniture craftsmen using HTML, CSS, PHP and MySQL.</br>
Implementation functions: member registration, login, administrator mode, message, general bulletin board, image bulletin board, member information modification, post modification, backup of deleted data using triggers

</br></br>
## Development Environment
|구분|내용|
|---|------------------|
|OS|Windows 10 Home|
|Language|PHP 8.2.0 |
|Editor|Visual Studiio Code 1.74.2 |
|DBMS|MySQL Workbench 8.0.17 |
|Server|Apache 2.4.54|
|Github|https://github.com/eunkeem/PHP_webproject_somokjang|

</br></br>
## Develop Period
2023.01.12 ~ 2023.01.18

</br></br>
## Show the function
|Display|Description|
|---|---|
|![xampp](https://user-images.githubusercontent.com/115531855/213119900-596178ad-de1c-4e52-aae0-a27b9127eb9a.JPG)| ⁕ xampp를 이용해 로컬서버구축</br> ⁕ apache 가상호스트|
|![Data modeling](https://user-images.githubusercontent.com/115531855/213090495-7c23dc09-c31a-45c8-a809-74d0836390fc.PNG)| ⁕ index 페이지가 로드되면 <br/>해당 데이터베이스가 있는지 확인하고 없다면 생성, 선택 <br/>테이블도 마찬가지<br/>  ⁕ 회원삭제시 데이터가 백업 되도록 트리거 생성 <br/> ⁕ 비밀번호 hash값 넣기위해 varchar(255)|
|![Main page](https://user-images.githubusercontent.com/115531855/213092569-2c100b6c-1162-4e48-86f6-99dfbc15b83a.jpeg) | ⁕헤더에 메뉴 바</br>⁕슬라이드쇼 : 자바스크립트를 사용</br> ⁕ 공지사항, 전시소개 포스터 : 관리자가 작성한 게시물만 디비에서 로드, </br> 클릭시 해당 게시물 상세페이지로 이동</br> ⁕ 유튜브 재생 링크 |
|![Member register](https://user-images.githubusercontent.com/115531855/213094265-a7229669-5e80-4856-9a3b-2fc2dfaf02df.jpeg)| ⁕아이디 중복 체크</br> ⁕ 이메일 유효성 검사 javascript test()함수이용</br>⁕ password_hash로 비밀번호 암호화 입력 </br> ⁕ mysqli_real_escape_string 로 입력값 방어 |
|![Admin mode](https://user-images.githubusercontent.com/115531855/213098223-ddacb6ca-c665-4eea-b7ea-4f2239ce0e39.jpeg)| ⁕ 데이터베이스에서 회원정보 수정, 삭제</br> ⁕ 삭제시 트리거</br> / 작성했던 게시물, 메시지도 삭제 </br> ⁕ 게시물 삭제 첨부파일 있다면 unlink()로 삭제 |
|![Image board](https://user-images.githubusercontent.com/115531855/213099243-d275b31f-f207-4a33-a37f-20c30f199639.jpeg)| ⁕ 관리자만 작성가능</br> ⁕	Form 태그 속성에 enctype="multipart/form-data</br> ⁕ input 태그 속성에 type=file로 설정 $_FILES값을 읽어옴 </br> ⁕ 날짜시간으로 파일명 별도의 디렉토리에 move_uploaded_file|
|![Image board_detail page](https://user-images.githubusercontent.com/115531855/213099821-eccc0d86-81de-47aa-802a-2a5abafe5834.jpeg)| ⁕ 조회수 증가</br> ⁕댓글(댓글작성자와 게시물 작성자만 삭제버튼) |
|![Board](https://user-images.githubusercontent.com/115531855/213100317-5a938163-8599-4617-8582-bf796c1ee0fa.jpeg)| ⁕ 로그인한 사용자만 작성가능 </br> ⁕ 페이지당 게시물 개수 제한 </br> 페이지생성 |
|![Board](https://user-images.githubusercontent.com/115531855/213101904-f6e3978c-cbbc-4c01-9533-cbdff573b17f.jpeg)| ⁕ 해당게시물 작성자만 가능</br> ⁕ 기존첨부파일 삭제가능|
|![Introduce](https://user-images.githubusercontent.com/115531855/213102562-70394bf1-6e7c-43f1-b7f9-f581f08829b5.jpeg)| ⁕ 작가 소개 페이지 |
|![Contact](https://user-images.githubusercontent.com/115531855/213102627-38772638-daa0-4f5c-a87f-cf910059840c.jpeg)| ⁕ 연락페이지 </br> ⁕ 카카오맵이용|
|![Works](https://user-images.githubusercontent.com/115531855/213102995-764de0b2-0eeb-4929-89a1-0ff1e15ca031.jpeg)| ⁕ 작품소개페이지</br> ⁕ javascript이용해서 모달창 이미지확대|

</br></br>
## Reference
|참고포털|웹페이지 주소|
|---|---|
|1.w3schoos|https://www.w3schools.com/|
|2.국가문화유산포털|https://www.heritage.go.kr/main/?v=1674025368760|
|3.문화유산채널|http://www.k-heritage.tv/main/heritage|
|4.성동구문화관광|https://www.sd.go.kr/tour/contents.do?key=1986|
|5.전북중앙|http://www.jjn.co.kr/news/articleView.html?idxno=911545|
|6.뮤지엄뉴스|https://museumnews.kr/134exmiri/|
