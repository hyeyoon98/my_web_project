<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    die("로그인이 필요합니다.");
}

$title = $_POST['title'];
$content = $_POST['content'];
$user_id = $_SESSION['user_id'];

$file_path = "";
if (isset($_FILES["upload_file"]) && $_FILES["upload_file"]["error"] == 0) {
    $upload_dir = "uploads/";
    $file_path = $upload_dir . basename($_FILES["upload_file"]["name"]);
    move_uploaded_file($_FILES["upload_file"]["tmp_name"], $file_path);
}

$sql = "INSERT INTO posts (user_id, title, content, file_path) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $user_id, $title, $content, $file_path);
$stmt->execute();

header("Location: /board.html");
?>
