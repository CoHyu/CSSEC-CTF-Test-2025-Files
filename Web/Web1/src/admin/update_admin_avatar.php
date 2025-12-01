<?php
// 更新admin用户头像
require_once '../includes/database.php';

$conn = getDBConnection();

// 更新admin用户的头像为default.jpg
$stmt = $conn->prepare("UPDATE users SET avatar = 'default.jpg' WHERE username = 'admin'");

if ($stmt->execute()) {
    echo "✓ Admin用户头像已更新为 default.jpg<br>";
    echo "<a href='../pages/admin_users.php'>返回用户管理</a>";
} else {
    echo "✗ 更新失败: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
