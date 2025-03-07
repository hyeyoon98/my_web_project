<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $user_id = trim($_POST['user_id']);
    $user_passwd = trim($_POST['user_passwd']);
    $birth = trim($_POST['birth']);
    $phone_number = trim($_POST['phone_number']);
    $email = trim($_POST['email']);

    $check_sql = "SELECT user_id FROM users WHERE user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $user_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) { 
        echo "<script>alert('이미 사용 중인 아이디입니다.'); history.back();</script>";
        $check_stmt->close();
        $conn->close();
        exit();
    }

    $hashed_password = password_hash($user_passwd, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, user_id, user_passwd, birth, phone_number, email) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $user_id, $hashed_password, $birth, $phone_number, $email);

    if ($stmt->execute()) {
        echo "<script>alert('회원가입 성공! 로그인하세요.'); location.href='/login.html';</script>";
    } else {
        echo "<script>alert('회원가입 실패! 다시 시도하세요.'); history.back();</script>";
    }

    $stmt->close();
}
$conn->close();
?>
