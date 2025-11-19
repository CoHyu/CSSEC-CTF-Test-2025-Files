<?php
highlight_file(__FILE__);
error_reporting(0);
$pattern = "/flag|system|passthru|exec|popen|php|cat|sort|shell|\`|\.| |\'/i";
if(isset($_GET['cmd'])){
    $cmd = $_GET['cmd'];
    if(!preg_match($pattern, $cmd)){
        eval($cmd);
    }else{
        echo "Try harder ok?";
    }
}else{
    echo "Show me your power.";
}