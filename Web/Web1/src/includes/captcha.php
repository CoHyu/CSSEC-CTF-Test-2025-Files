<?php

require_once 'config.php';
require_once 'functions.php';

// 如果没有 GD 扩展，记录日志并返回可读错误，避免调用不存在的函数导致 500
if (!function_exists('imagecreate')) {
    error_log('GD 扩展未启用，验证码无法生成');
    header('Content-Type: text/plain; charset=utf-8', true, 503);
    echo "GD extension is not enabled on the server. Enable GD in php.ini.\n";
    exit;
}

// 生成验证码图片
header('Content-Type: image/png');

$code = generateCaptcha();

// 创建图片
$width = 100;
$height = 40;
$image = imagecreate($width, $height);

// 设置颜色
$bg_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
$line_color = imagecolorallocate($image, 200, 200, 200);

// 添加干扰线
for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
}

// 添加验证码文字
imagestring($image, 5, 30, 12, $code, $text_color);

// 输出图片
imagepng($image);
imagedestroy($image);
?>
