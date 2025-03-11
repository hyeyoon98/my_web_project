<?php
session_start();
include "db.php";

$post_id = $_GET['id'];

// 게시글 가져오기
$sql = "SELECT p.id, p.title, p.content, p.file_path, p.created_at, p.user_id, u.name 
        FROM posts p 
        JOIN users u ON p.user_id = u.user_id 
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

// 댓글 가져오기
$sql = "SELECT c.id, c.comment_text, c.created_at, u.name, c.user_id 
        FROM comments c 
        JOIN users u ON c.user_id = u.user_id 
        WHERE c.post_id = ? 
        ORDER BY c.created_at ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$comments = $stmt->get_result();

// 로그인한 사용자 정보
$is_owner = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id'];
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
</head>
<body>
    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
    <p>작성자: <?php echo htmlspecialchars($post['name']); ?> | 작성일: <?php echo $post['created_at']; ?></p>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>

    <?php if (!empty($post['file_path'])): ?>
        <?php $file_name = basename($post['file_path']); ?>
        <p>첨부파일: <a href="<?php echo htmlspecialchars($post['file_path']); ?>" download><?php echo htmlspecialchars($file_name); ?></a></p>
    <?php endif; ?>

    <?php if ($is_owner): ?>
        <button onclick="location.href='edit_post.php?id=<?php echo $post_id; ?>'">수정</button>
    <?php endif; ?>

    <!-- 수정 및 삭제 버튼 (본인 또는 관리자) -->
    <?php if ($is_owner || $is_admin): ?>
        <button onclick="if(confirm('정말 삭제하시겠습니까?')) location.href='delete_post.php?id=<?php echo $post_id; ?>'">삭제</button>
    <?php endif; ?>

    <hr>

    <h3>댓글</h3>
    <?php while ($row = $comments->fetch_assoc()): ?>
        <div>
            <p><b><?php echo htmlspecialchars($row['name']); ?></b>: <?php echo nl2br(htmlspecialchars($row['comment_text'])); ?></p>
            <p>작성일: <?php echo $row['created_at']; ?></p>

            <!-- 로그인한 사용자가 댓글 작성자일 경우에만 수정/삭제 버튼 표시 -->
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']): ?>
                <button onclick="location.href='edit_comment.php?id=<?php echo $row['id']; ?>'">수정</button>
                <button onclick="if(confirm('정말 삭제하시겠습니까?')) location.href='delete_comment.php?id=<?php echo $row['id']; ?>'">삭제</button>
            <?php endif; ?>
            <hr>
        </div>
    <?php endwhile; ?>

    <!-- 댓글 입력 -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="add_comment.php" method="POST">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <textarea name="comment_text" required></textarea>
            <button type="submit">댓글 작성</button>
        </form>
    <?php else: ?>
        <p><a href="/login.html">로그인</a> 후 댓글을 작성할 수 있습니다.</p>
    <?php endif; ?>

    <hr>

    <!-- ✅ 목록으로 돌아가기 버튼 추가 -->
    <button onclick="location.href='board.php'">목록으로</button>

</body>
</html>
