<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$conn = getDBConnection();
$user_id = getCurrentUserId();
$username = getCurrentUsername();

// 删除博客
if (isset($_GET['delete'])) {
    $post_id = intval($_GET['delete']);
    if ($username == 'admin') {
        // admin可以删除任何文章
        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $post_id);
    } else {
        // 普通用户只能删除自己的文章
        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $post_id, $user_id);
    }
    $stmt->execute();
    $stmt->close();
    redirect('my_posts.php');
}

// 获取博客文章 - admin看所有文章,普通用户看自己的
if ($username == 'admin') {
    $stmt = $conn->prepare("SELECT p.*, u.username as author FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
} else {
    $stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $user_id);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的博客 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php $is_subpage = true; $current_page = 'my_posts'; include '../includes/navbar.php'; ?>

    <div class="container main-content">
        <h1><?php echo $username == 'admin' ? '所有博客管理' : '我的博客管理'; ?></h1>

        <div class="my-posts-list">
            <?php if ($result->num_rows > 0): ?>
                <table class="posts-table">
                    <thead>
                        <tr>
                            <th>标题</th>
                            <?php if ($username == 'admin'): ?>
                            <th>作者</th>
                            <?php endif; ?>
                            <th>发布时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <a href="view_post.php?id=<?php echo $post['id']; ?>">
                                        <?php echo h($post['title']); ?>
                                    </a>
                                </td>
                                <?php if ($username == 'admin'): ?>
                                <td><?php echo h($post['author']); ?></td>
                                <?php endif; ?>
                                <td><?php echo date('Y-m-d H:i', strtotime($post['created_at'])); ?></td>
                                <td class="actions">
                                    <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn-edit">编辑</a>
                                    <a href="my_posts.php?delete=<?php echo $post['id']; ?>" 
                                       class="btn-delete" 
                                       onclick="return confirm('确定要删除这篇博客吗？')">删除</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p>你还没有发布任何博客</p>
                    <a href="new_post.php" class="btn-primary">写第一篇博客</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
