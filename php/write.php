<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 작성</title>
    <link rel="stylesheet" href="/css/style.css"> 
</head>
<body>

<div class="container">
    <h2>게시글 작성</h2>
    <form action="write_process.php" method="post" enctype="multipart/form-data">
        <label for="title">제목</label>
        <input type="text" id="title" name="title" required>

        <label for="content">내용</label>
        <textarea id="content" name="content" rows="5" required></textarea>

        <label for="upload_file">파일 업로드</label>
        <input type="file" id="upload_file" name="upload_file">

        <button type="submit">게시글 등록</button>
    </form>
    <button onclick="location.href='board.php'">취소</button>
</div>

</body>
</html>
