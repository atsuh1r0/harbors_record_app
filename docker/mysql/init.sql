DROP DATABASE IF EXISTS posse;
CREATE DATABASE posse;
USE posse;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  posse VARCHAR(255),
  name VARCHAR(255),
  grade VARCHAR(255),
  email VARCHAR(255),
  password VARCHAR(255),
  time TIME NULL,
  at VARCHAR(255) NULL,
  status VARCHAR(255) NULL,
  image VARCHAR(255),
  comment VARCHAR(255) NULL, 
  is_at int NULL
) CHARSET=utf8;

-- insert into users (posse,name,grade, email, password,is_at) values ("2","テストさん","3.0", "test@test", "password","1");

INSERT INTO users (posse, name, grade, email, password, time, at, status, image,comment, is_at)
VALUES
-- ('2', '西川航平', '2', 'email1@example.com', 'password1', '08:00:00', 'コワーキング', 'プログラミング中', 'image1.jpg', '1'),
('2', '小野寛太', '2', 'email2@example.com', 'password2', '09:30', 'カフェ', '外出中', 'S__513843207.jpg', 'がんばる！','1'),
-- ('2', '田上黎', '2', 'email3@example.com', 'password3', '10:45:00', '屋上', '雑談中', 'image3.jpg', '1'),
('2', 'ジュリア', '2', 'email4@example.com', 'password4', '11:15:00', 'ルーム', '作業中', 'S__514121730.jpg', '課題無理','1'),
-- ('2', '金子夏蓮', '2', 'email5@example.com', 'password5', '12:30:00', 'コワーキング', '外出中', 'image5.jpg', '1'),
-- ('2', '渡邊美由貴', '2', 'email6@example.com', 'password6', '13:45:00', 'カフェ', '雑談中', 'image6.jpg', '1'),
-- ('2', '渡邉瑛貴', '2', 'email7@example.com', 'password7', '14:15:00', '屋上', 'プログラミング中', 'image7.jpg', '1'),
-- ('2', '三浦広太', '2', 'email8@example.com', 'password8', '15:30:00', 'ルーム', '外出中', 'image8.jpg', '1'),
-- ('2', '寺嶋里紗', '2', 'email9@example.com', 'password9', '16:45:00', 'コワーキング', '雑談中', 'image9.jpg', '1'),
-- ('2', '西山直輝', '2', 'email10@example.com', 'password10', '17:00:00', 'カフェ', 'プログラミング中', 'image10.jpg', '1'),
-- ('2', '多田一稀', '2', 'email11@example.com', 'password11', '18:15:00', '屋上', '外出中', 'image11.jpg', '1'),
-- ('2', '横山健人', '2', 'email12@example.com', 'password12', '19:30:00', 'ルーム', '雑談中', 'image12.jpg', '1'),
-- ('2', '寺下渓志郎', '2', 'email13@example.com', 'password13', '20:45:00', 'コワーキング', 'プログラミング中', 'image13.jpg', '1'),
-- ('3', '日置実里', '3', 'email14@example.com', 'password14', '08:30:00', 'カフェ', '外出中', 'image14.jpg', '1'),
-- ('3', '神保舞琴', '3', 'email15@example.com', 'password15', '09:45:00', '屋上', '雑談中', 'image15.jpg', '1'),
('3', '山崎賢人', '3', 'email16@example.com', 'password16', '10:00', 'ルーム', '作業中', 'S__514121737.jpg', '本物です','1'),
-- ('3', '大串真由', '3', 'email17@example.com', 'password17', '11:15:00', 'コワーキング', '外出中', 'image17.jpg', '1'),
-- ('3', '内藤麻優子', '3', 'email18@example.com', 'password18', '12:30:00', 'カフェ', '雑談中', 'image18.jpg', '1'),
-- ('3', '本村晴基', '3', 'email19@example.com', 'password19', '13:45:00', '屋上', 'プログラミング中', 'image19.jpg', '1'),
('3', '伊藤駿正', '3', 'email20@example.com', 'password20', '14:00', 'ルーム', '外出中', 'S__513843208.jpg', '眠いな-','1'),
('4', '伊藤流星', '4', 'email21@example.com', 'password21', '15:15', '屋上', 'フリー', 'S__514121732.jpg', 'ご飯いこ','1'),
('4', '長友佑都', '4', 'email22@example.com', 'password22', '16:30', 'カフェ', '作業中', 'S__514121735.jpg','ブラボー', '1'),
-- ('4', '羽根田有依', '4', 'email23@example.com', 'password23', '17:45:00', '屋上', '外出中', 'image23.jpg', '1'),
('4', '福田さら', '4', 'email24@example.com', 'password24', '18:00', 'ルーム', 'フリー', 'S__514121733.jpg', '頑張るぞ', '1'),
('4', '鈴木鴻太', '4', 'email25@example.com', 'password25', '19:15', '屋上', '作業中', 'S__513843202.jpg', 'こんにちは','1');
-- ('4', '山田夏寧', '4', 'email26@example.com', 'password26', '20:30:00', 'カフェ', '外出中', 'image26.jpg', '1'),
-- ('4', '宮本遥', '4', 'email27@example.com', 'password27', '21:45:00', '屋上', '雑談中', 'image27.jpg', '1'),
-- ('4', '久保井麻帆', '4', 'email28@example.com', 'password28', '22:00:00', 'ルーム', 'プログラミング中', 'image28.jpg', '1');

-- DROP TABLE IF EXISTS user_invitations;
-- CREATE TABLE user_invitations (
--   id INT AUTO_INCREMENT PRIMARY KEY,
--   user_id INT,
--   -- expired_at DATETIME,
--   invited_at DATETIME DEFAULT CURRENT_TIMESTAMP,
--   activated_at DATETIME,
--   token VARCHAR(255),
--   FOREIGN KEY (user_id) REFERENCES users(id)
-- ) CHARSET=utf8;

-- insert into user_invitations (user_id, invited_at, activated_at, token) values (1, DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY), CURRENT_DATE, "token");
DROP TABLE IF EXISTS schedule;
CREATE TABLE schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    date DATE,
    time TIME
);

-- 今月のランダムな日付を5つ挿入
INSERT INTO schedule (name, date,time) VALUES 
    ('小野寛太', DATE_ADD(CURRENT_DATE, INTERVAL FLOOR(RAND() * 30) DAY), SEC_TO_TIME(FLOOR(RAND() * 86400))),
    ('小野寛太', DATE_ADD(CURRENT_DATE, INTERVAL FLOOR(RAND() * 30) DAY), SEC_TO_TIME(FLOOR(RAND() * 86400))),
    ('小野寛太', DATE_ADD(CURRENT_DATE, INTERVAL FLOOR(RAND() * 30) DAY), SEC_TO_TIME(FLOOR(RAND() * 86400))),
    ('小野寛太', DATE_ADD(CURRENT_DATE, INTERVAL FLOOR(RAND() * 30) DAY), SEC_TO_TIME(FLOOR(RAND() * 86400))),
    ('小野寛太', DATE_ADD(CURRENT_DATE, INTERVAL FLOOR(RAND() * 30) DAY), SEC_TO_TIME(FLOOR(RAND() * 86400)));
