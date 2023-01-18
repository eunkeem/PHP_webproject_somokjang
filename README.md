# somokjang (personal project)

Summary
-------------
*한국전통가구 작가의 웹사이트를 HTML, CSS, PHP, MySQL을 이용해 제작</br>
*구현 기능 : 회원가입, 로그인, 관리자 모드, 메시지, 일반 게시판, 이미지 게시판, 회원정보 수정, 게시물 수정, 트리거를 이용한 삭제데이터 백업</br>
*Produced a website for Korean traditional furniture craftsmen using HTML, CSS, PHP and MySQL.</br>
*Implementation functions: member registration, login, administrator mode, message, general bulletin board, image bulletin board, member information modification, post modification, backup of deleted data using triggers


Development Environment
-------------
|구분|내용|
|---|------------------|
|OS|Windows 10 Home|
|Language|PHP 8.2.0 |
|Editor|Visual Studiio Code 1.74.2 |
|DBMS|MySQL Workbench 8.0.17 |
|Server|Apache 2.4.54|
|Github|https://github.com/eunkeem/somokjang|


Development Environment
-------------
2023.01.12 ~ 2023.01.18


Show the function
-------------
|Display|Description|
|---|---|
|![Data modeling](https://user-images.githubusercontent.com/115531855/213090495-7c23dc09-c31a-45c8-a809-74d0836390fc.PNG)| ⁕ index 페이지가 로드되면 <br/>해당 데이터베이스가 있는지 확인하고 없다면 생성, 선택 <br/>테이블도 마찬가지<br/> *회원삭제시 데이터가 백업 되도록 트리거 생성 <br/> 비밀번호 hash값 넣기위해 varchar(255)|
|![Main page](https://user-images.githubusercontent.com/115531855/213092569-2c100b6c-1162-4e48-86f6-99dfbc15b83a.jpeg) | *헤더에 메뉴 바</br>*슬라이드쇼 : 자바스크립트를 사용</br>*공지사항, 전시소개 포스터 : 관리자가 작성한 게시물만 디비에서 로드, </br> 클릭시 해당 게시물 상세페이지로 이동</br>*유튜브 재생 링크 |
|![Member register](https://user-images.githubusercontent.com/115531855/213094265-a7229669-5e80-4856-9a3b-2fc2dfaf02df.jpeg)| *아이디 중복 체크</br>*이메일 유효성 검사 javascript test()함수이용</br>* password_hash로 비밀번호 암호화 입력|
|![java_deletedata](https://user-images.githubusercontent.com/115531855/196696161-36981e08-ed5d-46ac-9d73-1724200c998f.JPG)| ⁕ delete data of DB |
|![deleteTable](https://user-images.githubusercontent.com/115531855/196696329-84efd5d3-53dd-4f82-8138-c2db1e28fd0c.JPG)| ⁕ dleteTable using trigger |
|![java_sort](https://user-images.githubusercontent.com/115531855/196020772-d4b94452-7f55-4c46-b298-0dcc706d0a56.JPG)| ⁕ Sort and display data |
|![mysql_modeling](https://user-images.githubusercontent.com/115531855/196021215-59296063-aada-4fbb-8158-cff4cfac4906.JPG)| ⁕ mysql modeling |




