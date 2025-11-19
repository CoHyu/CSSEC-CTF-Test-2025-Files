<?php
function get_flag_parts() {
    $flag = 'flag{this_is_a_sample_flag}';
    
    $len = strlen($flag);
    $part_size = ceil($len / 5);
    
    $parts = [];
    for ($i = 0; $i < 5; $i++) {
        $start = $i * $part_size;
        $parts[] = substr($flag, $start, $part_size);
    }
    
    return $parts;
}

function get_flag_part($level) {
    $parts = get_flag_parts();
    return isset($parts[$level]) ? $parts[$level] : '';
}
?>