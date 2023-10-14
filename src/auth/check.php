<?php

require("../dbconnect.php");
session_start();


/* 会員登録の手続き以外のアクセスを飛ばす */
if (!isset($_SESSION['join'])) {
    header('Location: signup.php');
    exit();
}
//  echo $_SESSION['join']['image'];

if (!empty($_POST['check'])) {

    // 入力情報をデータベースに登録
    $statement = $pdo->prepare("INSERT INTO users SET posse=?,name=?,grade=?, email=?, password=?, image=?");
    $statement->execute(array(
        $_SESSION['join']['posse'],
        $_SESSION['join']['name'],
        $_SESSION['join']['grade'],
        $_SESSION['join']['email'],
        $_SESSION['join']['password'],
        $_SESSION['form']['image']
    ));

    unset($_SESSION['join']);   // セッションを破棄
    header('Location: thank.php');   // thank.phpへ移動
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>確認画面</title>
    <link
  rel="stylesheet"
  href="https://unpkg.com/modern-css-reset/dist/reset.min.css"/>
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
    <link rel="stylesheet" href="./auth.css">
</head>
<body>
    <div class="login_container">
        <form action="" method="POST">
            <input type="hidden" name="check" value="checked">
            <div class="login_title">入力情報の確認</div>
            <p>変更が必要な場合、変更を行ってください。</p>
            <?php if (!empty($error) && $error === "error"): ?>
                <p class="error">＊会員登録に失敗しました。</p>
            <?php endif ?>
            <hr>

            <div class="control">
                <p class="title">所属POSSE</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['posse'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="control">
                <p class="title">名前</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="control">
                <p class="title">規生</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['grade'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="control">
                <p class="title">メールアドレス</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES); ?></span></p>
            </div>

            
            <br>
            <div class="button_container">
            <!-- <button onclick="location.href='signup.php'" class="change_button">変更する</button> -->


                <a href="signup.php" class="change_button">変更する</a>
                <button type="submit" class="login_button">登録する</button>
            </div>
            <!-- <div class="clear"></div> -->
        </form>
    </div>
</body>

</html>

