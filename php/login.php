<?php
session_start();
include 'db.php'; // 데이터베이스 연결

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST); // ✅ POST 데이터 확인용 (디버깅 후 삭제)
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $user_passwd = $_POST['user_passwd'];
    
    if (empty($user_id) || empty($user_passwd)) { 
        echo "<script>alert('아이디와 비밀번호를 입력하세요.'); history.back();</script>";
        exit();
    }

    // SQL 쿼리 실행 (비밀번호는 암호화된 상태에서 확인)
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // 비밀번호 검증 (암호화된 해시 비교)
        if (password_verify($user_passwd, $row['user_passwd'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name'] = $row['name'];

            error_log("login complete : user_id = " . $_SESSION['user_id']);

            echo "<script>alert('로그인 성공!'); location.href='board.php';</script>";
            exit();


            header("Location: board.php"); // 로그인 성공 시 이동
            exit();
        } else {
            echo "<script>alert('비밀번호가 올바르지 않습니다.'); history.back();</script>";
        }
    } else {
        echo "<script>alert('아이디가 존재하지 않습니다.'); history.back();</script>";
    }

    $stmt->close();
}
$conn->close();
?>
