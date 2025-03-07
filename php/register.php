<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $user_id = trim($_POST['user_id']);
    $user_passwd = trim($_POST['user_passwd']);
    $birth = trim($_POST['birth']);
    $phone_number = trim($_POST['phone_number']);
    $email = trim($_POST['email']);

    $hashed_password = password_hash($user_passwd, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, user_id, user_passwd, birth, phone_number, email) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $user_id, $hashed_password, $birth, $phone_number, $email);

    if ($stmt->execute()) {
        echo "<script>alert('회원가입 성공! 로그인하세요.'); location.href='/login.html';</script>";
    } else {
        echo "<script>alert('회원가입 실패! 아이디가 중복되었을 수 있습니다.'); history.back();</script>";
    }

    $stmt->close();
}
$conn->close();
?>
