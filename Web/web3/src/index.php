<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP Protocol Challenge</title>
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
            max-width: 800px;
            width: 100%;
            text-align: center;
        }
        h1 {
            font-size: 3em;
            letter-spacing: 5px;
            margin-bottom: 30px;
        }
        .nothing {
            font-size: 1.5em;
            opacity: 0.5;
        }
    </style>
    <script>
        document.oncontextmenu = function () {
            return false;
        }

        document.onkeydown = function (event) {
            event = event || window.event;
            if (event.keyCode == 123) {
                return false;
            }
            if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
                return false;
            }
            if (event.ctrlKey && event.keyCode == 85) {
                return false;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>WELCOME</h1>
        <div class="nothing">Nothing here...</div>
    </div>
</body>
</html>

<!-- 
    Well done! You bypassed the restrictions.
    FLAG Part 1/5: <?php require_once 'flag_parts.php'; echo htmlspecialchars(get_flag_part(0)); ?>
    
    Your first challenge begins at: aurghfuergf.php
-->