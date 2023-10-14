<?php
session_start();

// PDOの設定を呼び出す
require('./dbconnect.php'); 

$user_id = $_SESSION['id'];

if (isset($_POST['time'])) {
    $time = $_POST['time'];
    $at = $_POST['at'];
    $status = $_POST['status'];
    $comment = $_POST['comment'];

    $stmt = $pdo->prepare("UPDATE users SET at = :at, time = :time, status = :status, comment = :comment WHERE id = :user_id");
    $stmt->bindValue(':at', $at, PDO::PARAM_STR);
    $stmt->bindValue(':time', $time, PDO::PARAM_STR);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // 入退出の通知を送信する
    $lineMessageAnother = $_SESSION['name'] . ' が入室しました。';


    // LINE Notifyのアクセストークン - 別の通知
    $lineAccessTokenAnother = 'wpJvToV8OkhqKJQeRDXEMUBK4wbUrdHOunQE53qodD5'; // 別の通知のためのLINE Notifyアクセストークンを設定

    // LINE Notifyに通知を送信 - 別の通知
    // LINE Notifyに通知を送信 - ユーザー情報
    $lineUrl = 'https://notify-api.line.me/api/notify';
    $lineDataAnother = [
        'message' => $lineMessageAnother,
    ];

    $lineChAnother = curl_init($lineUrl);
    curl_setopt($lineChAnother, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($lineChAnother, CURLOPT_POSTFIELDS, http_build_query($lineDataAnother));
    curl_setopt($lineChAnother, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($lineChAnother, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $lineAccessTokenAnother]);

    $lineResultAnother = curl_exec($lineChAnother);
    curl_close($lineChAnother);

    // ユーザーの情報を通知する
    $sql = "SELECT * FROM users where is_at = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // LINE Notifyのアクセストークン
    $lineAccessToken = 'vh03NgK2bFiGTmGZDyzK2717O4SzDNChWQ3GNnKX4cu'; // ここに自分のLINE Notifyアクセストークンを設定

    // 通知メッセージ - ユーザー情報
    $lineMessageUsers = "ユーザー情報:\n";
    foreach ($users as $user) {
        $lineMessageUsers .= "  {$user['name']}\n";
    }

    
    $lineDataUsers = [
        'message' => $lineMessageUsers,
    ];

    $lineHeaders = [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Bearer ' . $lineAccessToken,
    ];

    $lineChUsers = curl_init($lineUrl);
    curl_setopt($lineChUsers, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($lineChUsers, CURLOPT_POSTFIELDS, http_build_query($lineDataUsers));
    curl_setopt($lineChUsers, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($lineChUsers, CURLOPT_HTTPHEADER, $lineHeaders);

    $lineResultUsers = curl_exec($lineChUsers);
    curl_close($lineChUsers);

    

    if ($lineResultUsers === false || $lineResultAnother === false) {
        echo 'LINE通知の送信に失敗しました。';
    } else {
        // 前のページにリダイレクト
        header("Location: ./index.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>ユーザー情報追加</title>
    <link rel="stylesheet" href="https://unpkg.com/modern-css-reset/dist/reset.min.css" />
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet" />
    <link rel="stylesheet" href="./auth/auth.css">
</head>

<body>
    <main>

        <div class="enroll_container4">
            <form action="" method="POST">
                <div class="control">
                    <label for="at" class="form_label">場所</label>
                    <select id="at" name="at" class="form_control">
                        <option value="ルーム">ルーム</option>
                        <option value="屋上">屋上</option>
                        <option value="カフェ">カフェ</option>
                        <option value="コワーキング">コワーキング</option>
                    </select>
                </div>

                <div class="control">
                    <label for="grade" class="form_label">何時まで</label>
                    <input id="time" type="time" name="time" class="form_control">
                </div>

                <div class="control">
                    <label for="status" class="form_label">ステータス</label>
                    <select id="status" name="status" class="form_control">
                        <option value="作業中">作業中</option>
                        <option value="外出中">外出中</option>
                        <option value="フリー">フリー</option>
                    </select>
                </div>

                <div class="control">
                    <label for="grade" class="form_label">一言</label>
                    <input id="comment" type="text" name="comment" class="form_control">
                </div>

                <div class="control">
                    <button type="submit" class="login_button">ラベルを変更する</button>
                </div>
            </form>
        </div>

    </main>
</body>

</html>