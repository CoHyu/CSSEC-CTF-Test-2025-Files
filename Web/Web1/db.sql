-- 创建数据库
CREATE DATABASE IF NOT EXISTS blog_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE blog_db;

-- 创建用户表
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT 'default.jpg',
    avatar_update_time DATETIME DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 创建博客文章表
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 创建默认管理员账号 (密码: 123456)
-- 密码哈希使用 PHP password_hash() 生成
INSERT INTO users (username, password, avatar) VALUES 
('admin', '$2y$10$BipsOrMqd.yGCjfRIFBf.er7CUY7jSxAqVcac6MgIukRv.vimonOC', 'default.jpg')
ON DUPLICATE KEY UPDATE username=username;
