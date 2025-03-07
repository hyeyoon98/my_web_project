function validateForm() {
    let isValid = true;

    // 입력 필드 가져오기
    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value.trim();

    // 오류 메시지 요소 가져오기
    let usernameError = document.getElementById("username-error");
    let passwordError = document.getElementById("password-error");

    // 오류 메시지 초기화
    usernameError.innerText = "";
    passwordError.innerText = "";

    // 아이디 유효성 검사
    if (username === "") {
        usernameError.innerText = "아이디를 입력하세요.";
        isValid = false;
    }

    // 비밀번호 유효성 검사
    if (password === "") {
        passwordError.innerText = "비밀번호를 입력하세요.";
        isValid = false;
    } else if (password.length < 6) {
        passwordError.innerText = "비밀번호는 최소 6자 이상이어야 합니다.";
        isValid = false;
    }

    return isValid;
}


function validateRegisterForm() {
    let isValid = true;

    let name = document.getElementById("name").value.trim();
    let user_id = document.getElementById("user_id").value.trim();
    let user_passwd = document.getElementById("user_passwd").value.trim();
    let birth = document.getElementById("birth").value;
    let phone_number = document.getElementById("phone_number").value.trim();
    let email = document.getElementById("email").value.trim();

    document.getElementById("name-error").innerText = "";
    document.getElementById("user_id-error").innerText = "";
    document.getElementById("user_passwd-error").innerText = "";
    document.getElementById("birth-error").innerText = "";
    document.getElementById("phone_number-error").innerText = "";
    document.getElementById("email-error").innerText = "";

    if (name === "") {
        document.getElementById("name-error").innerText = "이름을 입력하세요.";
        isValid = false;
    }
    if (user_id === "") {
        document.getElementById("user_id-error").innerText = "아이디를 입력하세요.";
        isValid = false;
    }
    if (user_passwd.length < 6) {
        document.getElementById("user_passwd-error").innerText = "비밀번호는 최소 6자 이상이어야 합니다.";
        isValid = false;
    }
    if (birth === "") {
        document.getElementById("birth-error").innerText = "생년월일을 선택하세요.";
        isValid = false;
    }
    if (!/^\d{3}-\d{3,4}-\d{4}$/.test(phone_number)) {
        document.getElementById("phone_number-error").innerText = "올바른 전화번호 형식이 아닙니다.";
        isValid = false;
    }
    if (!/^\S+@\S+\.\S+$/.test(email)) {
        document.getElementById("email-error").innerText = "올바른 이메일 주소를 입력하세요.";
        isValid = false;
    }

    return isValid;
}
