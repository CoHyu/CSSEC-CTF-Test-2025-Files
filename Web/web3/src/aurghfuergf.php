<?php
// Level 1: GET + POST Methods Challenge
require_once 'flag_parts.php';

$pass = false;
$message = '';
$flag_part = '';

if (isset($_GET['user']) && $_GET['user'] === 'admin' && 
    isset($_GET['func']) && $_GET['func'] === 'bypass' &&
    isset($_POST['greet']) && $_POST['greet'] === '123456') {
    $pass = true;
    $next = 'bejfdhsagje.php';
    $flag_part = get_flag_part(1);
} else {
    $current_params = [];
    $current_params[] = 'GET user = ' . (isset($_GET['user']) ? htmlspecialchars($_GET['user']) : '未设置');
    $current_params[] = 'GET func = ' . (isset($_GET['func']) ? htmlspecialchars($_GET['func']) : '未设置');
    $current_params[] = 'POST greet = ' . (isset($_POST['greet']) ? htmlspecialchars($_POST['greet']) : '未设置');
    $message = '当前参数：<br>' . implode('<br>', $current_params);
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 1: HTTP Methods</title>
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
        <h1>LEVEL 1: HTTP METHODS</h1>
        
        <div class="info">
            <p><strong>Challenge:</strong></p>
            <p>发送带有以下参数的请求：</p>
            <ul style="margin: 10px 0 10px 20px;">
                <li>GET: <code>user 为 admin，func 为 bypass</code></li>
                <li>POST: <code>greet 为 123456</code></li>
            </ul>
        </div>

        <?php if ($message): ?>
            <div class="error">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($pass): ?>
            <div class="success">
                ✓ Level 1 Complete!
            </div>
            <div class="flag-part">
                FLAG Part 2/5: <?php echo htmlspecialchars($flag_part); ?>
            </div>
            <div class="success">
                Next: <a href="<?php echo htmlspecialchars($next); ?>"><?php echo htmlspecialchars($next); ?></a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>