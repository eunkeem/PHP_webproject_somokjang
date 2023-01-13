// 패턴검색, 데이터 입력유무, 패스워드체크
function check_input() {
  if (!document.member_form.id.value) {
    alert("아이디를 입력하세요");
    document.member_form.id.focus();
    return;
  }
  if (!document.member_form.password.value) {
    alert("패스워드를 입력하세요");
    document.member_form.password.focus();
    return;
  }
  if (!document.member_form.password_check.value) {
    alert("패스워드확인을 입력하세요");
    document.member_form.password_check.focus();
    return;
  }
  if (!document.member_form.name.value) {
    alert("이름을 입력하세요");
    document.member_form.name.focus();
    return;
  }
  if (!document.member_form.email.value) {
    alert("이메일을 입력하세요");
    document.member_form.email.focus();
    return;
  }
  // 이메일 유효성검사
  let exptext = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;
  if (exptext.test(document.member_form.email.value) == false) {
    alert("올바른 이메일 형식이 아닙니다.");
    document.member_form.email.focus();
    return;
  }
  if (
    document.member_form.password.value !==
    document.member_form.password_check.value
  ) {
    alert("비밀번호가 일치하지 않습니다");
    document.member_form.password.value = "";
    document.member_form.password_check.value = "";
    document.member_form.password.focus();
    return;
  }

  // 서버에 전송하는 기능
  document.member_form.submit();
}

// 회원관리폼 내용 지우기
function reset_form() {
  document.member_form.id.value = "";
  document.member_form.password.value = "";
  document.member_form.password_check.value = "";
  document.member_form.name.value = "";
  document.member_form.email.value = "";
  document.member_form.id.focus();
  return;
}
function check_id() {
  window.open(
    "member_check_id.php?id=" + document.member_form.id.value,
    "IDcheck",
    "left=700,top=300,width=350,height=200,scrollbars=no,resizable=yes, status=no, titlebar=no, toolbar=no"
  );
}

// 로그인
function login_check_input() {
  if (!document.login_form.id.value) {
    alert("아이디를 입력하세요");
    document.login_form.id.focus();
    return;
  }
  if (!document.login_form.password.value) {
    alert("패스워드를 입력하세요");
    document.login_form.password.focus();
    return;
  }
  // 서버에 전송하는 기능
  document.login_form.submit();
}

//회원정보수정
function modify_check_input() {
  if (!document.member_modify_form.id.value) {
    alert("아이디를 입력하세요");
    document.member_modify_form.id.focus();
    return;
  }
  if (!document.member_modify_form.password.value) {
    alert("패스워드를 입력하세요");
    document.member_modify_form.password.focus();
    return;
  }
  if (!document.member_modify_form.password_check.value) {
    alert("패스워드를 입력하세요");
    document.member_modify_form.password_check.focus();
    return;
  }
  // 서버에 전송하는 기능
  document.member_modify_form.submit();
}
