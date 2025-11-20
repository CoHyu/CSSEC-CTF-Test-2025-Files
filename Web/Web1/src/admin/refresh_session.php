<?php
// 刷新session中的头像
session_start();
require_once '../includes/database.php';

if (isset($_SESSION['user_id'])) {
    $conn = getDBConnection();
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("SELECT avatar FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['avatar'] = $user['avatar'];
        echo "✓ Session头像已更新为: " . htmlspecialchars($user['avatar']) . "<br>";
        echo "<a href='../index.php'>返回首页</a>";
    } else {
        echo "✗ 未找到用户";
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo "✗ 未登录<br>";
    echo "<a href='../pages/login.php'>去登录</a>";
}
?>
