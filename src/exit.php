<?php

declare(strict_types=1);
session_start();

// PDOの設定を呼び出す
require('./dbconnect.php');

$user_id = $_SESSION['id'];

if (isset($_POST['user_id'])) {
  $sql = "UPDATE users SET is_at = 0 WHERE id = :user_id";

  // プリペアドステートメントを作成
  $stmt = $pdo->prepare($sql);

  // ユーザーIDをバインド
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

  // SQLクエリを実行
  if ($stmt->execute()) {
    // LINE Notifyのアクセストークン
    $lineAccessToken = 'wpJvToV8OkhqKJQeRDXEMUBK4wbUrdHOunQE53qodD5'; // あなたのLINE Notifyアクセストークンを設定

    // 通知メッセージ
    $lineMessage = $_SESSION['name'] . ' が退出しました。';

    // LINE Notifyに通知を送信
    $lineUrl = 'https://notify-api.line.me/api/notify';
    $lineData = [
      'message' => $lineMessage,
    ];

    $lineHeaders = [
      'Content-Type: application/x-www-form-urlencoded',
      'Authorization: Bearer ' . $lineAccessToken,
    ];

    $lineCh = curl_init($lineUrl);
    curl_setopt($lineCh, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($lineCh, CURLOPT_POSTFIELDS, http_build_query($lineData));
    curl_setopt($lineCh, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($lineCh, CURLOPT_HTTPHEADER, $lineHeaders);

    $lineResult = curl_exec($lineCh);
    curl_close($lineCh);

    

    // // LINE Notifyのアクセストークン
    // $lineAccessToken = 'vh03NgK2bFiGTmGZDyzK2717O4SzDNChWQ3GNnKX4cu'; // ここに自分のLINE Notifyアクセストークンを設定

    // // 通知メッセージ - ユーザー情報
    // $lineMessageUsers = "ユーザー情報:\n";
    // foreach ($users as $user) {
    //   $lineMessageUsers .= "  {$user['name']}\n";
    // }


    // $lineDataUsers = [
    //   'message' => $lineMessageUsers,
    // ];

    // $lineHeaders = [
    //   'Content-Type: application/x-www-form-urlencoded',
    //   'Authorization: Bearer ' . $lineAccessToken,
    // ];

    // $lineChUsers = curl_init($lineUrl);
    // curl_setopt($lineChUsers, CURLOPT_CUSTOMREQUEST, 'POST');
    // curl_setopt($lineChUsers, CURLOPT_POSTFIELDS, http_build_query($lineDataUsers));
    // curl_setopt($lineChUsers, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($lineChUsers, CURLOPT_HTTPHEADER, $lineHeaders);

    // $lineResultUsers = curl_exec($lineChUsers);
    // curl_close($lineChUsers);

    if ($lineResult === false) {
      echo 'LINE通知の送信に失敗しました。';
    } else {
      // 前のページにリダイレクト
      header("Location: ./index.php");
      exit();
    }
  }
}
