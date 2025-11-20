<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$conn = getDBConnection();
$post_id = intval($_GET['id'] ?? 0);

if ($post_id == 0) {
    redirect('index.php');
}

// 获取博客文章
$stmt = $conn->prepare("SELECT p.*, u.username, u.avatar FROM posts p 
                        JOIN users u ON p.user_id = u.id 
                        WHERE p.id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    redirect('index.php');
}

$post = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($post['title']); ?> - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php $is_subpage = true; $current_page = 'view_post'; include '../includes/navbar.php'; ?>

    <div class="container main-content">
        <div class="post-detail">
            <h1 class="post-title"><?php echo h($post['title']); ?></h1>
            
            <div class="post-meta">
                <div class="author-info">
                    <img src="../uploads/avatars/<?php echo h($post['avatar']); ?>" alt="avatar" class="author-avatar">
                    <div>
                        <span class="author-name"><?php echo h($post['username']); ?></span>
                        <span class="post-date"><?php echo date('Y-m-d H:i', strtotime($post['created_at'])); ?></span>
                    </div>
                </div>
            </div>

            <div class="post-body">
                <?php echo nl2br(h($post['content'])); ?>
            </div>

            <div class="post-actions">
                <a href="../index.php" class="btn-secondary">返回首页</a>
                <?php if ($post['user_id'] == getCurrentUserId() || getCurrentUsername() == 'admin'): ?>
                    <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn-primary">编辑</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
