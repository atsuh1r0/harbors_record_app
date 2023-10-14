<?php

declare(strict_types=1);
session_start();

// PDOの設定を呼び出す
require('./dbconnect.php'); 

$user_id = $_SESSION['id'];

// ユーザーIDをフォームから取得
if (isset($_POST['user_id'])) {

    try {
        // ユーザーのis_atカラムを1に設定するSQLクエリを準備
        $sql = "UPDATE users SET is_at = 1 WHERE id = :user_id";

        // プリペアドステートメントを作成
        $stmt = $pdo->prepare($sql);

        // ユーザーIDをバインド
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        // SQLクエリを実行
        if ($stmt->execute()) {
          header("Location: ./add.php"); // 前のページのURLを指定
        exit();
        } else {
            echo "エラー: 更新に失敗しました。";
        }
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }
} else {
    echo "ユーザーIDが提供されていません。";
}
