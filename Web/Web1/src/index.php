<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

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

if (!isLoggedIn()) {
    header("Location: /pages/login.php");
    exit();
}

$conn = getDBConnection();

// 获取所有博客文章
$sql = "SELECT p.*, u.username, u.avatar FROM posts p 
        JOIN users u ON p.user_id = u.id 
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php $is_subpage = false; $current_page = 'index'; include 'includes/navbar.php'; ?>

    <div class="container main-content">
        <div class="welcome-banner">
            <h1>欢迎来到博客系统</h1>
            <p>分享你的想法，记录你的生活</p>
        </div>

        <div class="posts-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($post = $result->fetch_assoc()): ?>
                    <div class="post-card">
                        <div class="post-header">
                            <div class="author-info">
                                <img src="uploads/avatars/<?php echo h($post['avatar']); ?>" alt="avatar" class="author-avatar">
                                <div>
                                    <h3><?php echo h($post['username']); ?></h3>
                                    <span class="post-date"><?php echo date('Y-m-d H:i', strtotime($post['created_at'])); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="post-content">
                            <h2><?php echo h($post['title']); ?></h2>
                            <p><?php echo nl2br(h(substr($post['content'], 0, 200))); ?>
                            <?php if (strlen($post['content']) > 200): ?>...<?php endif; ?>
                            </p>
                        </div>
                        <div class="post-footer">
                            <a href="pages/view_post.php?id=<?php echo $post['id']; ?>" class="btn-link">阅读全文</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>还没有任何博客文章</p>
                    <a href="pages/new_post.php" class="btn-primary">写第一篇博客</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
