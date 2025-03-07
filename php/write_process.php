<?php
session_start();
include "db.php"; // DB 연결

if (!isset($_SESSION['user_id'])) {
    die("로그인이 필요합니다.");
}

// 사용자가 입력한 데이터 가져오기
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$content = isset($_POST['content']) ? trim($_POST['content']) : '';
$user_id = $_SESSION['user_id'];

if (empty($title) || empty($content)) {
    die("제목과 내용을 입력해주세요.");
}

// 파일 업로드 처리
$file_path = "";
if (isset($_FILES["upload_file"]) && $_FILES["upload_file"]["error"] == 0) {
    $upload_dir = "uploads/"; // 업로드 폴더
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // 폴더 없으면 생성
    }
    $file_path = $upload_dir . basename($_FILES["upload_file"]["name"]);
    move_uploaded_file($_FILES["upload_file"]["tmp_name"], $file_path);
}

// DB에 게시글 저장
$sql = "INSERT INTO posts (user_id, title, content, file_path) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $user_id, $title, $content, $file_path);
$stmt->execute();
$stmt->close();
$conn->close();

// 게시판 페이지로 이동
header("Location: board.php");
exit;
?>
