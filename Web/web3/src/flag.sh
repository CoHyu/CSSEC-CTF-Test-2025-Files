#!/bin/bash

rm -f /flag.sh

if [ -z "$GZCTF_FLAG" ]; then
    export GZCTF_FLAG="flag{this_is_a_test_flag}"
fi

sed -i "s/flag{this_is_a_sample_flag}/$GZCTF_FLAG/g" /var/www/html/flag_parts.php

unset GZCTF_FLAG