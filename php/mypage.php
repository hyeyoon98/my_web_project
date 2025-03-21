<?php
session_start();
include "db.php";

// 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$id = $_SESSION['id'];


// 현재 사용자 정보 가져오기
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>마이페이지</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #333;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #667eea;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #5563c1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>마이페이지</h2>
        <p>이름: <?php echo htmlspecialchars($user['name']); ?></p>
        <p>아이디: <?php echo htmlspecialchars($user['user_id']); ?></p>
        <p>생년월일: <?php echo htmlspecialchars($user['birth']); ?></p>
        <p>연락처: <?php echo htmlspecialchars($user['phone_number']); ?></p>
        <p>이메일: <?php echo htmlspecialchars($user['email']); ?></p>

        <h3>비밀번호 변경</h3>
        <form action="change_password.php" method="POST">
            <input type="password" name="current_password" placeholder="현재 비밀번호" required>
            <input type="password" name="new_password" placeholder="새 비밀번호" required>
            <input type="password" name="confirm_password" placeholder="새 비밀번호 확인" required>
            <button type="submit">비밀번호 변경</button>
        </form>

        <h3>회원 탈퇴</h3>
        <form action="delete_account.php" method="GET">
            <button type="submit" onclick="return confirm('정말 탈퇴하시겠습니까?')">회원 탈퇴</button>
        </form>
        
        <button onclick="location.href='board.php'">돌아가기</button>
    </div>
</body>
</html>
