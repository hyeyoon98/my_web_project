<?php
$host = "192.168.183.128/"; // 데이터베이스 서버
$user = "root"; // MySQL 아이디
$pass = "nine"; // MySQL 비밀번호 (설정한 값)
$dbname = "web"; // 사용할 데이터베이스 이름

// MySQL 연결
$conn = new mysqli($host, $user, $pass, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}
?>
