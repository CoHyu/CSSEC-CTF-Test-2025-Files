<?php
// 辅助函数

// 删除文件名末尾的点
function deldot($s) {
    for ($i = strlen($s) - 1; $i > 0; $i--) {
        if ($s[$i] != '.') {
            return substr($s, 0, $i + 1);
        }
    }
    return $s;
}

// 检查用户是否登录
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// 获取当前登录用户ID
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

// 获取当前登录用户名
function getCurrentUsername() {
    return $_SESSION['username'] ?? null;
}

// 重定向函数
function redirect($url) {
    header("Location: $url");
    exit();
}

// XSS防护
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// 验证码生成
function generateCaptcha() {
    $code = '';
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < 4; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    $_SESSION['captcha'] = strtolower($code);
    return $code;
}

// 验证码验证（忽略大小写，验证后不清除）
function verifyCaptcha($input, $clearOnSuccess = false) {
    if (!isset($_SESSION['captcha'])) {
        return false;
    }
    $isValid = strtolower(trim($input)) === strtolower($_SESSION['captcha']);
    
    // 只有在明确要求且验证成功时才清除验证码
    if ($isValid && $clearOnSuccess) {
        unset($_SESSION['captcha']);
    }
    
    return $isValid;
}
?>
