<?php
session_start();
include "db.php";

// 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.html';</script>";
    exit;
}

// 게시글 저장 로직 (POST 요청일 때만 실행)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST['title']) ? trim($_POST['title']) : "";
    $content = isset($_POST['content']) ? trim($_POST['content']) : "";
    $user_id = $_SESSION['user_id'];

    // 제목과 내용이 비어 있는지 확인
    if (empty($title) || empty($content)) {
        echo "<script>alert('제목과 내용을 입력해주세요.'); history.back();</script>";
        exit;
    }

    // 파일 업로드 처리
    $file_path = "";
    if (isset($_FILES["upload_file"]) && $_FILES["upload_file"]["error"] == 0) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // 디렉토리가 없으면 생성
        }

        $file_path = $upload_dir . basename($_FILES["upload_file"]["name"]);
        move_uploaded_file($_FILES["upload_file"]["tmp_name"], $file_path);
    }

    // 게시글 저장 쿼리 실행
    $sql = "INSERT INTO posts (user_id, title, content, file_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $user_id, $title, $content, $file_path);

    if ($stmt->execute()) {
        echo "<script>alert('게시글이 등록되었습니다.'); location.href='board.php';</script>";
    } else {
        echo "<script>alert('게시글 등록에 실패했습니다.'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>게시글 작성</title>
</head>
<body>
<div class="write-container">
    <h2>게시글 작성</h2>
    <form action="write_process.php" method="post" enctype="multipart/form-data">
        <div class="input-group">
            <label for="title">제목</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="input-group">
            <label for="content">내용</label>
            <textarea id="content" name="content" rows="5" required></textarea>
        </div>
        <div class="input-group">
            <label for="upload_file">파일 업로드</label>
            <input type="file" id="upload_file" name="upload_file">
        </div>
        <button type="submit" class="write-btn">게시글 작성</button>
    </form>
</div>
</body>
</html>
