<?php
if(isset($_POST['cmd'])){
    $code = $_POST['cmd'];
    if(preg_match('/\'|"|`|\ |,|-|\+|=|\/|\\|<|>|\$|\?|\^|&|\|/ixm',$code)){
        die('Not Allow!');
    }else if(';' === preg_replace('/[^\s\(\)]+?\((?R)?\)/', '', $code)){
        @eval($code);
        die();
    }
} else {
    highlight_file(__FILE__);
    echo "Try harder?";
}
?>
