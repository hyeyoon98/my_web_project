<?php
session_start();
include "db.php";

$comment_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// 댓글 정보 가져오기
$sql = "SELECT * FROM comments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $comment_id);
$stmt->execute();
$comment = $stmt->get_result()->fetch_assoc();

// 로그인한 사용자만 삭제 가능
if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != $comment['user_id'] && $_SESSION['role'] !== 'admin')) {
    echo "<script>alert('권한이 없습니다.'); history.back();</script>";
    exit;
}

// 댓글 삭제 (user_id까지 조건 추가)
$sql = "DELETE FROM comments WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $comment_id, $user_id);
$stmt->execute();

// 삭제된 행 개수 확인
if ($stmt->affected_rows > 0) {
    header("Location: post.php?id=" . $comment['post_id']);
} else {
    echo "<script>alert('삭제 실패: 본인의 댓글만 삭제할 수 있습니다.'); history.back();</script>";
}
exit;
?>