<?php
highlight_file(__FILE__);
if(isset($_POST['cmd'])){
    $code = $_POST['cmd'];
    if(preg_match('/\'|"|`|\ |,|-|\+|=|\/|\\|<|>|\$|\?|\^|&|\|/ixm',$code)){
        die('Not Allow!');
    }else if(';' === preg_replace('/[^\s\(\)]+?\((?R)?\)/', '', $code)){
        try{
            echo "ok.<br>";
            @eval($code);
            die();
        } catch (Throwable $e) {
            echo "sth went wrong!";
        }
    }
} else {
    echo "Try harder?";
}
?>
