<?php
session_start();
include "db.php";

if (!isset($_GET['id'])) {
    die("잘못된 접근입니다.");
}
$post_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// 게시글 조회
$sql = "SELECT user_id FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("게시글이 존재하지 않습니다.");
}
$post = $result->fetch_assoc();

// 권한 체크 (본인 또는 관리자만 삭제 가능)
if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != $post['user_id'] && $_SESSION['role'] !== 'admin')) {
    die("권한이 없습니다.");
}


// 삭제 실행
$sql = "DELETE FROM posts WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();

header("Location: board.php");
exit;
?>
