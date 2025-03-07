<?php
session_start();
include "db.php";

$comment_id = $_GET['id'];
$sql = "SELECT * FROM comments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $comment_id);
$stmt->execute();
$comment = $stmt->get_result()->fetch_assoc();

// 로그인한 사용자만 수정 가능
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $comment['user_id']) {
    echo "<script>alert('권한이 없습니다.'); history.back();</script>";
    exit;
}

// 댓글 수정 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_text = $_POST['comment_text'];
    $sql = "UPDATE comments SET comment_text = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_text, $comment_id);
    $stmt->execute();

    header("Location: post.php?id=" . $comment['post_id']);
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>댓글 수정</title>
</head>
<body>
    <h2>댓글 수정</h2>
    <form method="POST">
        <textarea name="comment_text" required><?php echo htmlspecialchars($comment['comment_text']); ?></textarea>
        <button type="submit">수정 완료</button>
    </form>
</body>
</html>
