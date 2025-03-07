<?php
session_start();
include "db.php";

// 게시글 목록 가져오기
$sql = "SELECT p.id, p.title, p.content, p.created_at, u.name 
        FROM posts p 
        JOIN users u ON p.user_id = u.user_id 
        ORDER BY p.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자유게시판</title>
</head>
<body>
    <h2>자유게시판</h2>

    <!-- 로그인 상태 확인 -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>안녕하세요, <?php echo $_SESSION['name']; ?>님!</p>
        <button onclick="location.href='write.html'">글쓰기</button>
        <button onclick="location.href='logout.php'">로그아웃</button>
    <?php else: ?>
        <button onclick="location.href='login.html'">로그인</button>
        <button onclick="location.href='register.html'">회원가입</button>
    <?php endif; ?>

    <hr>

    <!-- 게시글 목록 -->
    <?php while ($row = $result->fetch_assoc()): ?>
        <div>
            <h3><a href="post.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></h3>
            <p>작성자: <?php echo htmlspecialchars($row['name']); ?> | 작성일: <?php echo $row['created_at']; ?></p>
            <p><?php echo nl2br(htmlspecialchars(mb_substr($row['content'], 0, 100))) . '...'; ?></p>
            <hr>
        </div>
    <?php endwhile; ?>

</body>
</html>
