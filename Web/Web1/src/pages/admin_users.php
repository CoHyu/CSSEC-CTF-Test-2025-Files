<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

// 检查是否是admin用户
if (getCurrentUsername() != 'admin') {
    redirect('../index.php');
}

$conn = getDBConnection();

// 处理删除用户请求
if (isset($_GET['delete']) && $_GET['delete'] != '') {
    $delete_id = intval($_GET['delete']);
    // 不能删除admin自己
    if ($delete_id != getCurrentUserId()) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
        redirect('admin_users.php');
    }
}

// 获取所有用户
$stmt = $conn->prepare("SELECT id, username, avatar, created_at FROM users ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户管理 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php $is_subpage = true; $current_page = 'admin_users'; include '../includes/navbar.php'; ?>

    <div class="container main-content">
        <div class="my-posts-list">
            <h1>用户管理</h1>
            
            <?php if ($result->num_rows > 0): ?>
                <table class="posts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>头像</th>
                            <th>注册时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo h($user['id']); ?></td>
                                <td><?php echo h($user['username']); ?></td>
                                <td>
                                    <img src="../uploads/avatars/<?php echo h($user['avatar']); ?>" 
                                         alt="avatar" 
                                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
                                         title="右键复制图片链接">
                                </td>
                                <td><?php echo date('Y-m-d H:i', strtotime($user['created_at'])); ?></td>
                                <td class="actions">
                                    <?php if ($user['username'] != 'admin'): ?>
                                        <a href="admin_users.php?delete=<?php echo $user['id']; ?>" 
                                           class="btn-delete" 
                                           onclick="return confirm('确定要删除用户【<?php echo h($user['username']); ?>】吗？此操作不可恢复！');">删除</a>
                                    <?php else: ?>
                                        <span style="color: #999;">管理员</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p>暂无用户</p>
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
