<?php
require("../dbconnect.php");
    session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST["email"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM users WHERE email = :email";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(":email", $email);
  $stmt->execute();
  $user = $stmt->fetch();

  if (!$user || !$password= $user["password"]) {
    $message = "認証情報が正しくありません";
  } else {
    // session_start();
    $_SESSION['id'] = $user["id"];
    $_SESSION['name'] = $user["name"];
    // $message = "ログインに成功しました";
    header('Location: ../index.php');
  }


  // if (password_verify($password, $user['password'],)) {
  //   //情報をセッション変数に登録
  //   $_SESSION['email'] = $user['email'];
  //   header('Location: ../index.php');
  // } else {
  //   //パスワードが間違っている場合
  //   $message = "認証情報が正しくありません";
  // }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン画面</title>
  <link
  rel="stylesheet"
  href="https://unpkg.com/modern-css-reset/dist/reset.min.css"/>
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
    <link rel="stylesheet" href="./auth.css">
</head>
<body>
    <main>
    <div class="enroll_container2">
        <div class="login_title">ログイン画面</div>
          <form method="POST">
            <div class="control">
              <!-- <label for="email" class="form_label">メールアドレス</label> -->
              <input type="text" name="email" class="form_control" id="email" placeholder="メールアドレス">
              
            </div>
            <div class="control">
              <!-- <label for="password" class="form_label">パスワード</label> -->
              <input type="password" name="password" id="password" class="form_control" placeholder="パスワード">
            </div>
            <?php if (isset($message)) { ?>
            <p><?= $message ?></p>
          <?php } ?>
          <p class="a"><a href="./signup.php">サインアップはこちらへ</a></p>
            <button type="submit"  class="login_button" >ログイン</button>
          </form>
      </div>
    </div>
    </main>
</body>
</html>
