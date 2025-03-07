<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    die("로그인이 필요합니다.");
}

$user_id = $_SESSION['user_id'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// 현재 비밀번호 확인
$sql = "SELECT password FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!password_verify($current_password, $user['password'])) {
    die("<script>alert('현재 비밀번호가 틀립니다.'); history.back();</script>");
}

// 새 비밀번호 확인
if ($new_password !== $confirm_password) {
    die("<script>alert('새 비밀번호가 일치하지 않습니다.'); history.back();</script>");
}

// 새 비밀번호 해시화 후 업데이트
$new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
$sql = "UPDATE users SET password = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $new_password_hashed, $user_id);
$stmt->execute();

echo "<script>alert('비밀번호가 변경되었습니다.'); location.href='mypage.php';</script>";
?>
