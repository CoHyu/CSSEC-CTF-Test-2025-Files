<?php
// 开启开发模式的错误显示，便于定位 500 错误（调试完成后请移除或注释）
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('log_errors', '1');

// 错误日志文件（项目根目录下的 logs）
define('ERROR_LOG_DIR', __DIR__ . '/../logs');
if (!file_exists(ERROR_LOG_DIR)) {
    @mkdir(ERROR_LOG_DIR, 0777, true);
}
ini_set('error_log', ERROR_LOG_DIR . '/php_errors.log');

// 数据库配置
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'blog_db');

// 上传路径配置（使用绝对路径，避免相对路径问题）
define('UPLOAD_PATH', __DIR__ . '/../uploads/avatars');

// 网站配置
define('SITE_NAME', '大神博客');
define('SITE_URL', 'http://localhost/Web1');

// Session配置
ini_set('session.cookie_httponly', 1);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// 创建上传目录
if (!file_exists(UPLOAD_PATH)) {
    @mkdir(UPLOAD_PATH, 0777, true);
}
?>
