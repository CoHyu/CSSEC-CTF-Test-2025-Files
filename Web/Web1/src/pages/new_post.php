<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    
    if (empty($title) || empty($content)) {
        $error = '标题和内容不能为空！';
    } else if (strlen($title) > 200) {
        $error = '标题长度不能超过200个字符！';
    } else {
        $conn = getDBConnection();
        $user_id = getCurrentUserId();
        
        $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $title, $content);
        
        if ($stmt->execute()) {
            $success = '发布成功！';
            echo "<script>setTimeout(function(){ window.location.href='my_posts.php'; }, 1500);</script>";
        } else {
            $error = '发布失败，请稍后重试！';
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
    <title>写博客 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="../index.php" class="logo"><?php echo SITE_NAME; ?></a>
            <ul class="nav-menu">
                <li><a href="../index.php">首页</a></li>
                <li><a href="new_post.php" class="active">写博客</a></li>
                <li><a href="my_posts.php">我的博客</a></li>
                <li><a href="profile.php">个人中心</a></li>
                <li><a href="logout.php">退出</a></li>
            </ul>
            <div class="user-info">
                <img src="uploads/avatars/<?php echo h($_SESSION['avatar']); ?>" alt="avatar" class="nav-avatar">
                <span><?php echo h(getCurrentUsername()); ?></span>
            </div>
        </div>
    </nav>

    <div class="container main-content">
        <div class="post-form-container">
            <h1>写一篇新博客</h1>
            
            <?php if ($error): ?>
                <div class="error-msg"><?php echo h($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success-msg"><?php echo h($success); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="new_post.php" class="post-form">
                <div class="form-group">
                    <label>标题</label>
                    <input type="text" name="title" required maxlength="200" placeholder="输入博客标题...">
                </div>
                
                <div class="form-group">
                    <label>内容</label>
                    <textarea name="content" required rows="15" placeholder="写下你的想法..."></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary">发布</button>
                    <a href="../index.php" class="btn-secondary">取消</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
