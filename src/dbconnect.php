<?php
// データベース接続処理
$dsn = 'mysql:dbname=posse;host=db;charset=utf8';
$user = 'root';
$password = 'root';

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //連想配列
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //例外
        PDO::ATTR_EMULATE_PREPARES => false, //SQLインジェクション対策
    ]);
    echo '';
} catch (PDOException $e) {
    echo '接続失敗' . $e->getMessage() . "\n";
    exit();
}
