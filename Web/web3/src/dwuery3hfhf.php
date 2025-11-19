<?php
// Level 4: Cookie Challenge
require_once 'flag_parts.php';

$pass = false;
$message = '';
$cookie_value = isset($_COOKIE['user']) ? $_COOKIE['user'] : '';
$flag_part = '';

if ($cookie_value === 'CCCCHY') {
    $pass = true;
    $flag_part = get_flag_part(4);
    
    // 获取完整 flag
    $flag_parts = get_flag_parts();
    $complete_flag = implode('', $flag_parts);
} else {
    if (empty($cookie_value)) {
        $message = 'No cookie named "user" found.';
    } else {
        $message = "Cookie 'user' value: " . htmlspecialchars($cookie_value) . ". Expected: CCCCHY";
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 4: Cookie</title>
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
        .flag {
            background: #fff;
            color: #000;
            padding: 30px;
            margin: 20px 0;
            text-align: center;
            font-size: 1.3em;
            letter-spacing: 3px;
            border: 3px double #000;
            font-weight: bold;
        }
        code {
            background: #fff;
            color: #000;
            padding: 2px 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>LEVEL 4: COOKIE</h1>
        
        <div class="info">
            <p><strong>Final Challenge:</strong></p>
            <p>让我看看你的身份 <code>user</code> 是不是 <code>CCCCHY</code> ？ </p>
        </div>

        <?php if ($message): ?>
            <div class="error">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($pass): ?>
            <div class="success">
                ✓ All Levels Complete!<br><br>
                Congratulations! You've mastered HTTP protocol basics.
            </div>
            <div class="flag-part">
                FLAG Part 5/5: <?php echo htmlspecialchars($flag_part); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>