<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

$error = '';
$success = '';
$is_upload = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 总是处理注册逻辑
    if (true) {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $captcha = $_POST['captcha'] ?? '';
        
        if (empty($username) || empty($password)) {
            $error = '用户名和密码不能为空！';
        } else if ($password !== $password_confirm) {
            $error = '两次输入的密码不一致！';
        } else if (strlen($username) < 3 || strlen($username) > 20) {
            $error = '用户名长度必须在3-20个字符之间！';
        } else if (strlen($password) < 6) {
            $error = '密码长度至少为6个字符！';
        } else {
            $conn = getDBConnection();
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $error = '用户名已存在！';
            } else {
                $avatar_filename = 'default.jpg';
                
                // 处理头像上传 - 只检查MIME类型
                if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                    if (file_exists(UPLOAD_PATH)) {
                        if (($_FILES['avatar']['type'] == 'image/jpeg') || ($_FILES['avatar']['type'] == 'image/png') || ($_FILES['avatar']['type'] == 'image/gif')) {
                            $temp_file = $_FILES['avatar']['tmp_name'];
                            $avatar_filename = $_FILES['avatar']['name'];
                            $img_path = UPLOAD_PATH . '/' . $avatar_filename;
                            
                            if (move_uploaded_file($temp_file, $img_path)) {
                                $is_upload = true;
                            } else {
                                $error = '头像上传失败！';
                            }
                        } else {
                            $error = '文件类型不正确！';
                        }
                    }
                }
                
                // 不检查验证码，直接创建用户
                if (empty($error)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users (username, password, avatar) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $username, $hashed_password, $avatar_filename);
                    
                    if ($stmt->execute()) {
                        $success = '注册成功！';
                        echo "<script>setTimeout(function(){ window.location.href='login.php'; }, 2000);</script>";
                    } else {
                        $error = '注册失败，请稍后重试！';
                    }
                }
            }
            
            $stmt->close();
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注册 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h1>注册账号</h1>
            <?php if ($error): ?>
                <div class="error-msg"><?php echo h($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success-msg"><?php echo h($success); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="register.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label>用户名</label>
                    <input type="text" name="username" required minlength="3" maxlength="20">
                </div>
                
                <div class="form-group">
                    <label>密码</label>
                    <input type="password" name="password" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label>确认密码</label>
                    <input type="password" name="password_confirm" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label>头像上传（可选）</label>
                    <input type="file" name="avatar" accept="image/*">
                    <small class="hint">支持上传图片文件</small>
                </div>
                
                <button type="submit" class="btn-primary">注册</button>
            </form>
            
            <div class="auth-links">
                已有账号？<a href="login.php">立即登录</a>
            </div>
        </div>
    </div>
</body>
</html>
