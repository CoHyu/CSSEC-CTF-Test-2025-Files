<?php
// Level 3: User-Agent Header Challenge
require_once 'flag_parts.php';

$pass = false;
$message = '';
$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
$flag_part = '';

if (strpos($user_agent, '2345 browser') !== false || strpos($user_agent, '2345browser') !== false) {
    $pass = true;
    $next = 'dwuery3hfhf.php';
    $flag_part = get_flag_part(3);
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 3: User Agent</title>
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
            word-wrap: break-word;
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
        <h1>LEVEL 3: USER AGENT</h1>
        
        <div class="info">
            <p><strong>Challenge:</strong></p>
            <p>你必须要用 <code>2345 browser</code> （2345浏览器）访问这个页面才能前往下一关……</p>
            <p>温馨提示：不要尝试去下载这个浏览器。</p>
        </div>

        <?php if ($pass): ?>
            <div class="success">
                ✓ Level 3 Complete!
            </div>
            <div class="flag-part">
                FLAG Part 4/5: <?php echo htmlspecialchars($flag_part); ?>
            </div>
            <div class="success">
                Next: <a href="<?php echo htmlspecialchars($next); ?>"><?php echo htmlspecialchars($next); ?></a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>