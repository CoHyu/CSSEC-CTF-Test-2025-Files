<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// 清除所有 session 数据
$_SESSION = array();
session_destroy();

// 重定向到登录页面
header('Location: login.php');
exit();
?>
