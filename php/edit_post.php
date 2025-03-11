<?php
session_start();
include "db.php";

// 게시글 ID 확인
if (!isset($_GET['id'])) {
    die("잘못된 접근입니다.");
}
$post_id = $_GET['id'];

// 게시글 조회
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

// 권한 체크 (본인만 수정 가능)
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $post['user_id']) {
    die("권한이 없습니다.");
}

// 수정 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $post_id);
    $stmt->execute();
    
    header("Location: post_view.php?id=$post_id");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시글 수정</title>
</head>
<body>
    <h2>게시글 수정</h2>
    <form method="POST">
        <label>제목: <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required></label><br>
        <label>내용: <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea></label><br>
        <button type="submit">수정 완료</button>
    </form>
    <button onclick="location.href='post.php?id=<?php echo $post_id; ?>'">취소</button>
</body>
</html>