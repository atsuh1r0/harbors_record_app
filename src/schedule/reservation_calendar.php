<?php
if (isset($_POST['name']) && isset($_POST['date']) && isset($_POST['time'])) {
    // 送信されたデータを取得
    $name = htmlspecialchars($_POST["name"], ENT_QUOTES);
    $date = htmlspecialchars($_POST["date"], ENT_QUOTES);
    $time = htmlspecialchars($_POST["time"], ENT_QUOTES);

    // データベース接続設定を含むファイルを読み込む
    require('../dbconnect.php');

    try {
        // クエリのプリペアドステートメントを作成
        $stmt = $pdo->prepare("INSERT INTO schedule (name, date, time) VALUES (:name, :date, :time)");

        // プリペアドステートメントのパラメータに値をバインド
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);

        // クエリを実行
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'データベースエラー: ' . $e->getMessage() . "\n";
        exit();
    }

    // スケジュールページにリダイレクト
    header("Location: schedule.php");
    exit;
}
?>
