#!/bin/sh

# 删除自己
rm -f /flag.sh

# 设置 flag
if [ -z "$GZCTF_FLAG" ]; then
    export GZCTF_FLAG="flag{this_is_a_test_flag}"
fi

# 将 GZCTF_FLAG 注入到 /flag
echo $GZCTF_FLAG > /flag
chmod 644 /flag

# 清空环境变量
unset GZCTF_FLAG

# 等待 MySQL 启动 (基础镜像已自动启动)
sleep 5

# 导入数据库
mysql < /db.sql

# 设置权限
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
mkdir -p /var/www/html/uploads/avatars
mkdir -p /var/www/html/logs
chown -R www-data:www-data /var/www/html/uploads
chown -R www-data:www-data /var/www/html/logs
chmod -R 777 /var/www/html/uploads
chmod -R 777 /var/www/html/logs

# 启动 PHP-FPM (后台运行)
killall php-fpm 2>/dev/null
php-fpm -D

# 启动 Nginx (前台运行,保持容器运行)
exec nginx
