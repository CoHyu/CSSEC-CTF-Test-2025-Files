FROM ctftraining/base_image_nginx_mysql_php_73

# 复制数据库文件
COPY db.sql /db.sql

# 复制 Nginx 配置并删除默认配置
COPY nginx-site.conf /etc/nginx/conf.d/site.conf
RUN rm -f /etc/nginx/conf.d/default.conf

# 复制网站源码
COPY src /var/www/html

# 移动 flag.sh 到根目录并设置权限
RUN mv /var/www/html/flag.sh /flag.sh \
    && chmod +x /flag.sh \
    && chown -R www-data:www-data /var/www/html \
    && mkdir -p /var/www/html/uploads/avatars \
    && mkdir -p /var/www/html/logs \
    && chmod -R 777 /var/www/html/uploads \
    && chmod -R 777 /var/www/html/logs

# 暴露端口
EXPOSE 80

# 启动命令
CMD ["/flag.sh"]
