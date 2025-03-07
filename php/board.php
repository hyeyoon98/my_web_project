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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 10px 20px;
        }
        .navbar h1 {
            color: white;
            margin: 0;
        }
        .navbar .buttons {
            display: flex;
            gap: 10px;
        }
        .navbar a, .navbar button {
            text-decoration: none;
            color: white;
            background-color: #555;
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .navbar a:hover, .navbar button:hover {
            background-color: #777;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>자유게시판</h1>
        <div class="buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="mypage.php" style="color:white; text-decoration: none;">
                    안녕하세요, <?php echo htmlspecialchars($_SESSION['name']); ?>님!
                </a>
                <button onclick="location.href='write.php'">글쓰기</button>
                <button onclick="location.href='logout.php'">로그아웃</button>
            <?php else: ?>
                <a href="/login.html">로그인</a>
                <a href="/register.html">회원가입</a>
            <?php endif; ?>
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
