<?php
// 初始化数据库脚本
require_once '../includes/database.php';

echo "<h1>数据库初始化</h1>";
echo "<p>开始初始化数据库...</p>";

initDatabase();

// 创建默认管理员账号
$conn = getDBConnection();
$username = 'admin';
$password = '123456';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 检查是否已存在
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt = $conn->prepare("INSERT INTO users (username, password, avatar) VALUES (?, ?, 'default.jpg')");
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        echo "<p style='color: green;'>✓ 默认管理员账号创建成功！</p>";
        echo "<p>账号: <strong>admin</strong></p>";
        echo "<p>密码: <strong>123456</strong></p>";
    } else {
        echo "<p style='color: red;'>✗ 创建管理员账号失败</p>";
    }
} else {
    echo "<p style='color: orange;'>管理员账号已存在</p>";
}

$stmt->close();
$conn->close();

echo "<p><a href='../pages/login.php'>前往登录页面</a></p>";
?>
