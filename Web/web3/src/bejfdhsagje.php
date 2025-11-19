<?php
// Level 2: X-Client-IP Header Challenge
require_once 'flag_parts.php';

$pass = false;
$message = '';
$client_ip = '';
$flag_part = '';

// 检查不支持的头
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $message = '不支持 X-Forwarded-For 头';
} elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
    $message = '不支持 X-Real-IP 头';
} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
    $message = '不支持 Client-IP 头';
} elseif (isset($_SERVER['HTTP_X_CLIENT_IP'])) {
    $client_ip = $_SERVER['HTTP_X_CLIENT_IP'];
    if ($client_ip === '8.8.8.8') {
        $pass = true;
        $next = 'ciwhdiahgfdeffa.php';
        $flag_part = get_flag_part(2);
    } else {
        $message = "检测到的 IP: {$client_ip}";
    }
} else {
    // 显示真实 IP
    $real_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '未知';
    $message = "当前客户端 IP: {$real_ip}";
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 2: Client IP</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', monospace;
            background: #000;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            width: 100%;
            border: 2px solid #fff;
            padding: 40px;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 30px;
            text-align: center;
        }
        .info {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #fff;
        }
        .error {
            background: #fff;
            color: #000;
            padding: 15px;
            margin: 20px 0;
        }
        .success {
            background: #fff;
            color: #000;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .flag-part {
            background: #fff;
            color: #000;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
            font-weight: bold;
            letter-spacing: 2px;
        }
        code {
            background: #fff;
            color: #000;
            padding: 2px 8px;
        }
        a {
            color: #000;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>LEVEL 2: CLIENT IP</h1>
        
        <div class="info">
            <p><strong>Challenge:</strong></p>
            <p>你来自 <code>8.8.8.8</code> 吗？</p>
        </div>

        <?php if ($message): ?>
            <div class="error">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($pass): ?>
            <div class="success">
                ✓ Level 2 Complete!
            </div>
            <div class="flag-part">
                FLAG Part 3/5: <?php echo htmlspecialchars($flag_part); ?>
            </div>
            <div class="success">
                Next: <a href="<?php echo htmlspecialchars($next); ?>"><?php echo htmlspecialchars($next); ?></a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>