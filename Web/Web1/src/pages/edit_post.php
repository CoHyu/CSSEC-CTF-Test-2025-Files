<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$conn = getDBConnection();
$user_id = getCurrentUserId();
$post_id = intval($_GET['id'] ?? 0);

if ($post_id == 0) {
    redirect('my_posts.php');
}

// 验证文章所有权或admin权限
$username = getCurrentUsername();
if ($username == 'admin') {
    // admin可以编辑任何文章
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
} else {
    // 普通用户只能编辑自己的文章
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    redirect('my_posts.php');
}

$post = $result->fetch_assoc();
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
        // admin可以更新任何文章
        if ($username == 'admin') {
            $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
            $stmt->bind_param("ssi", $title, $content, $post_id);
        } else {
            $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ssii", $title, $content, $post_id, $user_id);
        }
        
        if ($stmt->execute()) {
            $success = '更新成功！';
            $post['title'] = $title;
            $post['content'] = $content;
        } else {
            $error = '更新失败，请稍后重试！';
        }
        
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑博客 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php $is_subpage = true; $current_page = 'edit_post'; include '../includes/navbar.php'; ?>

    <div class="container main-content">
        <div class="post-form-container">
            <h1>编辑博客</h1>
            
            <?php if ($error): ?>
                <div class="error-msg"><?php echo h($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success-msg"><?php echo h($success); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="edit_post.php?id=<?php echo $post_id; ?>" class="post-form">
                <div class="form-group">
                    <label>标题</label>
                    <input type="text" name="title" required maxlength="200" 
                           value="<?php echo h($post['title']); ?>" placeholder="输入博客标题...">
                </div>
                
                <div class="form-group">
                    <label>内容</label>
                    <textarea name="content" required rows="15" placeholder="写下你的想法..."><?php echo h($post['content']); ?></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary">更新</button>
                    <a href="my_posts.php" class="btn-secondary">取消</a>
                </div>
            </form>
        </div>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
