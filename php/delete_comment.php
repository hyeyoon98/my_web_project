<?php
session_start();
include "db.php";

$comment_id = $_GET['id'];

// 댓글 정보 가져오기
$sql = "SELECT * FROM comments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $comment_id);
$stmt->execute();
$comment = $stmt->get_result()->fetch_assoc();

// 로그인한 사용자만 삭제 가능
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $comment['user_id']) {
    echo "<script>alert('권한이 없습니다.'); history.back();</script>";
    exit;
}

// 댓글 삭제
$sql = "DELETE FROM comments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $comment_id);
$stmt->execute();

header("Location: post.php?id=" . $comment['post_id']);
?>
