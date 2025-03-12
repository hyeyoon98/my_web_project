<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.html");
    exit(); // 리디렉션 후 스크립트 종료
}

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
    <link rel="stylesheet" href="/css/style.css">
        
</head>
<body>

    <div class="navbar">
        <h1>자유게시판</h1>
        <div class="buttons">
            <a href="mypage.php" style="color:white; text-decoration: none;">
            안녕하세요, <?php echo htmlspecialchars($_SESSION['name']); ?>님!
            </a>
            <button onclick="location.href='write.php'">글쓰기</button>
            <button onclick="location.href='logout.php'">로그아웃</button>
        </div>
    </div>

    <div class="container">
        <h2>게시글 목록</h2>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <h3><a href="post.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></h3>
                <p>작성자: <?php echo htmlspecialchars($row['name']); ?> | 작성일: <?php echo $row['created_at']; ?></p>
                <p><?php echo nl2br(htmlspecialchars(mb_substr($row['content'], 0, 100))) . '...'; ?></p>
                <hr>
            </div>
        <?php endwhile; ?>
    </div>

</body>
</html>
