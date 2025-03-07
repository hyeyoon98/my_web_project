<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    $comment_text = $_POST['comment_text'];

    $sql = "INSERT INTO comments (post_id, user_id, comment_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $post_id, $user_id, $comment_text);
    $stmt->execute();

    header("Location: post.php?id=$post_id");
}
?>
