<?php

declare(strict_types=1);
session_start();
// PDOの設定を呼び出す
require('./dbconnect.php');
if (!isset($_SESSION['id'])) {
  header('Location: auth/signin.php');
} else {
  $user_id = $_SESSION['id'];
}

// $user_id=$_SESSION['id'];

// ユーザー一覧取得
$sql = "SELECT * FROM users where is_at=1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(is_at) as count FROM users where is_at=1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users_count = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT id FROM users where is_at=1 and id =$user_id ";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usersId = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@_@</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./assets/styles/reset.css">
  <link rel="stylesheet" href="./assets/styles/style.css">

</head>

<body>
  <!-- header window -->
  <?php require_once('./components/header.php'); ?>

  <!-- main  -->
  <main>
    <div class="section_button_wrapper">
      <?php if (empty($usersId[0])) : ?>
        <section class="section_button_in">
          <form method="post" action="./attendance.php">
            <input type="hidden" name="user_id"> <!-- ユーザーID（id=1）を指定 -->
            <input type="hidden" name="action"> <!-- 入室アクションを識別するための追加フィールド -->
            <div class="arrow_position">
              <input class="button enter_button" type="submit" value="IN">
              <img src="./img/arrow.jpg" class="arrow_right">
            </div>
          </form>
        </section>
      <?php else : ?>
        <section class="section_button_out">
          <form method="post" action="./exit.php">
            <input type="hidden" name="user_id"> <!-- ユーザーID（id=1）を指定 -->
            <input type="hidden" name="action"> <!-- 入室アクションを識別するための追加フィールド -->
            <div class="arrow_position">
              <input class="button enter_button2" type="submit" value="OUT">
              <img src="./img/arrow.jpg" class="arrow_left">
            </div>
          </form>
          <form method="post" action="./attendance.php">
            <input type="hidden" name="user_id"> <!-- ユーザーID（id=1）を指定 -->
            <input type="hidden" name="action"> <!-- 入室アクションを識別するための追加フィールド -->
            <input class="button change_button" type="submit" value="ラベル変更">
          </form>
        </section>
      <?php endif ?>
    </div>
    <div class="dropdown">

      <button class="current" id="current">
        <div class="current_button"><img src="./img/eye.png" class="eye_img">
          <p class="current_text">現在のHarborS <span class="color"><?php echo $users_count[0]['count'] ?></span>人</p>
          <div class="arrow2"></div>
        </div>
      </button>

    </div>



    <div class="user_container">
      <?php foreach ($users as $key => $user) : ?>
        <div class="user">
          <div class="user_left">
            <img class="user_img" src="./img/<?php echo $user["image"] ?>">
          </div>
          <div class="user_right">
            <div class="user_right_top">
              <p><span class="border"><?php echo $user['posse'] ?></span><span class="grade"><?php echo $user['grade'] ?>期生</span><span class="name"><?php echo $user['name'] ?></span></p>
            </div>
            <div class="user_right_bottom">
              <div class="user_right_bottom_left">
                <p class="time"><?php echo $user["time"] ?></p>
                <p class="p">＠<?php echo $user["at"] ?></p>
                <p class="p2"><?php echo $user["comment"] ?></p>
              </div>
              <div class="user_right_bottom_right">
                <p class="<?php echo $user["status"] ?>"><?php echo $user["status"] ?></p>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    </div>
    <form method="post" action="./schedule/schedule.php">
      <div class="schedule">
        <button class="current" id="current">
          <div class="current_button"><img src="./img/calendar.jpg" class="eye_img">
            <p class="current_text">カレンダー</p>
            <div class="arrow"></div>
          </div>
        </button>
      </div>
    </form>
    </div>
  </main>
  <script src=./assets/script/script.js></script>
</body>

</html>
