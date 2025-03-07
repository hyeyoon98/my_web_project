<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    die("로그인이 필요합니다.");
}

$user_id = $_SESSION['user_id'];

// 유저의 모든 게시글, 댓글 삭제
$conn->query("DELETE FROM posts WHERE user_id = $user_id");
$conn->query("DELETE FROM comments WHERE user_id = $user_id");

// 유저 계정 삭제
$sql = "DELETE FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

// 세션 종료 후 로그인 페이지로 이동
session_destroy();
echo "<script>alert('회원 탈퇴가 완료되었습니다.'); location.href='/login.html';</script>";
?>
