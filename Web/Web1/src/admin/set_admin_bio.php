<?php
// 为admin用户添加个人简介
require_once '../includes/database.php';

$conn = getDBConnection();

// 先检查bio字段是否存在，如果不存在则添加
$result = $conn->query("SHOW COLUMNS FROM users LIKE 'bio'");
if ($result->num_rows == 0) {
    $conn->query("ALTER TABLE users ADD COLUMN bio TEXT DEFAULT NULL AFTER avatar_update_time");
    echo "✓ 已添加bio字段<br>";
}

// 更新admin用户的个人简介
$bio = "我是管理员，我可以为所欲为，哈哈哈哈哈哈";
$stmt = $conn->prepare("UPDATE users SET bio = ? WHERE username = 'admin'");
$stmt->bind_param("s", $bio);

if ($stmt->execute()) {
    echo "✓ Admin用户简介已更新<br>";
    echo "<p>简介内容：" . htmlspecialchars($bio) . "</p>";
    echo "<a href='../pages/profile.php'>查看个人中心</a>";
} else {
    echo "✗ 更新失败: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
