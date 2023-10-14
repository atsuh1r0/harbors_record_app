<?php 
require("../dbconnect.php");
session_start();
if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    if ($_POST['email'] === "") {
        $error['email'] = "blank";
    }
    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }
    if ($_POST['posse'] === "") {
        $error['posse'] = "blank";
    }
    if ($_POST['grade'] === "") {
        $error['grade'] = "blank";
    }
    if ($_POST['name'] === "") {
        $error['name'] = "blank";
    }

    
    /* メールアドレスの重複を検知 */
    if (!isset($error)) {
        $users = $pdo->prepare('SELECT COUNT(*) as cnt FROM users WHERE email=?');
        $users->execute(array(
            $_POST['email']
        ));
        $record = $users->fetch();
        if ($record['cnt'] > 0) {
            $error['email'] = 'duplicate';
        }
    }

    $image = $_FILES["image"];
    if ($image['name'] !== '') {
        $type = mime_content_type($image['tmp_name']);
        if ($type !== 'image/png' && $type !== 'image/jpeg') {
            $error['image'] = 'type';
        }
    }
 
    /* エラーがなければ次のページへ */
    if (!isset($error)) {
        if ($image['name'] !== '') {
            //画像のアップロード
            $filename = date('YmdHis') . '_' . $image['name'];
            if (!move_uploaded_file($image['tmp_name'], '../img/' . $filename)) {
                die('ファイルのアップロードに失敗しました');
            }
            $_SESSION['form']['image'] = $filename;
        } else {
            $_SESSION['form']['image'] = $s_filename;
        }
        $_SESSION['join'] = $_POST;   // フォームの内容をセッションで保存
        header('Location: check.php');   
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>ユーザー登録</title>
    <link
  rel="stylesheet"
  href="https://unpkg.com/modern-css-reset/dist/reset.min.css"
/>
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
    <link rel="stylesheet" href="./auth.css">
</head>
<body>
    <!-- <header>
    <div class="header_left">
            <img src="../../img/CRAFT.png" alt="ロゴ">
        </div>
        <div class="header_right">
            ログイン画面
        </div>
    </header> -->
    <main>
    <div class="enroll_container">
    <div class="login_title2">登録画面</div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="control">
                <!-- <label for="posse" class="form_label">所属POSSE</label> -->
                <input id="posse" type="text" name="posse" class="form_control" placeholder="所属POSSE">
                <?php if (!empty($error["posse"]) && $error['posse'] === 'blank'): ?>
                    <div class="error">＊所属posseを入力してください</div>
                <?php endif ?>
            </div>
 
            <div class="control">
                <!-- <label for="grade" class="form_label">期生</label> -->
                <input id="grade" type="text" name="grade" class="form_control" placeholder="期生">
                <?php if (!empty($error["grade"]) && $error['grade'] === 'blank'): ?>
                    <div class="error">＊期生を入力してください</div>
                <?php endif ?>
            </div>

            <div class="control">
                <!-- <label for="name" class="form_label">名前</label> -->
                <input id="name" type="text" name="name" class="form_control" placeholder="名前">
                <?php if (!empty($error["name"]) && $error['name'] === 'blank'): ?>
                    <div class="error">＊名前を入力してください</div>
                <?php endif ?>
            </div>
 
            <div class="control">
                <!-- <label for="email" class="form_label">メールアドレス</label> -->
                <input id="email" type="email" name="email" class="form_control" placeholder="メールアドレス">
                <?php if (!empty($error["email"]) && $error['email'] === 'blank'): ?>
                    <div class="error">＊メールアドレスを入力してください</div>
                <?php elseif (!empty($error["email"]) && $error['email'] === 'duplicate'): ?>
                    <div class="error">＊このメールアドレスはすでに登録済みです</div>
                <?php endif ?>
            </div>

            <div class="control">
                <!-- <label for="password" class="form_label">パスワード</label> -->
                <input id="password" type="password" name="password" class="form_control" placeholder="パスワード">
                <?php if (!empty($error["password"]) && $error['password'] === 'blank'): ?>
                    <div class="error">＊パスワードを入力してください</div>
                <?php endif ?>
            </div>
 
            <div class="control">
                <!-- <label for="question" class="form-label">問題の画像</label> -->
                    <input type="file" name="image" id="image" class="form-control required"/>
                <?php if (!empty($error["image"]) && $error['image'] === 'blank'): ?>
                    <div class="error">＊画像を選択してください</div>
                <?php endif ?>
            </div>
 
            <div class="control">
                <button type="submit" class="login_button">確認する</button>
            </div>
        </form>
    </div>
    </main>
</body>
</html>
