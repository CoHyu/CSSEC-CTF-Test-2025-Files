<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

// 自动初始化数据库（如果不存在）
try {
    $test_conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($test_conn->connect_error || !$test_conn->select_db(DB_NAME)) {
        // 数据库不存在，自动初始化
        initDatabase();
        
        // 创建默认管理员账号
        $conn = getDBConnection();
        $username = 'admin';
        $password = '123456';
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, avatar) VALUES (?, ?, 'default.jpg')");
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
    if ($test_conn) $test_conn->close();
} catch (Exception $e) {
    // 忽略错误，继续执行
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // 不验证验证码
    if (empty($username) || empty($password)) {
        $error = '用户名和密码不能为空！';
    } else {
        $conn = getDBConnection();
        $stmt = $conn->prepare("SELECT id, username, password, avatar FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['avatar'] = $user['avatar'];
                redirect('../index.php');
            } else {
                $error = '用户名或密码错误！';
            }
        } else {
            $error = '用户名或密码错误！';
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h1>登录</h1>
            <?php if ($error): ?>
                <div class="error-msg"><?php echo h($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success-msg"><?php echo h($success); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label>用户名</label>
                    <input type="text" name="username" required>
                </div>
                
                <div class="form-group">
                    <label>密码</label>
                    <input type="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-primary">登录</button>
            </form>
            
            <div class="auth-links">
                还没有账号？<a href="register.php">立即注册</a>
            </div>
        </div>
    </div>
</body>
</html>
