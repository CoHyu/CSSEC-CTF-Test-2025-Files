<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$conn = getDBConnection();
$user_id = getCurrentUserId();

// 获取用户信息
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人中心 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php $is_subpage = true; $current_page = 'profile'; include '../includes/navbar.php'; ?>

    <div class="container main-content">
        <div class="profile-container">
            <h1>个人中心</h1>
            
            <div class="profile-card">
                <div class="profile-avatar">
                    <img src="../uploads/avatars/<?php echo h($user['avatar']); ?>" alt="avatar" id="current-avatar" title="右键可复制图片链接">
                </div>
                
                <div class="profile-info">
                    <div class="info-item">
                        <label>用户名：</label>
                        <span><?php echo h($user['username']); ?></span>
                    </div>
                    
                    <div class="info-item">
                        <label>注册时间：</label>
                        <span><?php echo date('Y-m-d H:i', strtotime($user['created_at'])); ?></span>
                    </div>
                    
                    <div class="info-item">
                        <label>个人简介：</label>
                        <span><?php echo h($user['bio'] ?? '这个人很懒，什么都没有留下'); ?></span>
                    </div>
                </div>
                
                <div class="profile-actions">
                    <button class="btn-primary" id="edit-btn" onclick="toggleEditMode()">编辑</button>
                    <div id="edit-form" style="display: none; margin-top: 20px;">
                        <form method="POST" action="../includes/update_avatar.php" enctype="multipart/form-data" onsubmit="return showUploadFailure(event);">
                            <div class="form-group">
                                <label>上传新头像：</label>
                                <input type="file" name="avatar" accept="image/*" required>
                            </div>
                            <div style="display: flex; gap: 15px; margin-top: 20px;">
                                <button type="submit" class="btn-primary" style="flex: 1;">保存</button>
                                <button type="button" class="btn-secondary" style="flex: 1;" onclick="toggleEditMode()">取消</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleEditMode() {
            const editForm = document.getElementById('edit-form');
            const editBtn = document.getElementById('edit-btn');
            if (editForm.style.display === 'none') {
                editForm.style.display = 'block';
                editBtn.style.display = 'none';
            } else {
                editForm.style.display = 'none';
                editBtn.style.display = 'block';
            }
        }
        
        function showUploadFailure(event) {
            event.preventDefault();
            alert('上传失败！\n\n可能的原因：\n1. 文件格式不支持\n2. 文件大小超过限制\n3. 服务器上传目录权限不足');
            return false;
        }
    </script>
</body>
</html>
