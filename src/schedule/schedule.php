<?php

function getReservation()
{
  try {
    require('../dbconnect.php');
    $stmt = $pdo->query("SELECT * FROM schedule");

    // 予約情報を日付ごとに格納する配列
    $reservation_data = array();

    foreach ($stmt as $row) {
      $day_out = strtotime($row['date']);
      $member_out = (string) $row['name'];
      $date_key = date('Y-m-d', $day_out);

      // 同じ日付の予約が複数ある場合、配列に名前を追加する
      if (isset($reservation_data[$date_key])) {
        $reservation_data[$date_key][] = $member_out;
      } else {
        $reservation_data[$date_key] = array($member_out);
      }
    }

    ksort($reservation_data);
    return $reservation_data;
  } catch (PDOException $e) {
    echo '接続失敗' . $e->getMessage() . "\n";
    exit();
  }
}


$reservation_array = getreservation();
//getreservation関数を$reservation_arrayに代入しておく
function reservation($date, $reservation_data)
{
  // カレンダーの日付と予約情報を照合する関数

  if (array_key_exists($date, $reservation_data)) {
    // もしカレンダーの日付が予約情報のキーに存在する場合

    $names = $reservation_data[$date];
    $output = "<br/><span class='green'>";

    foreach ($names as $name) {
      $output .= $name . "<br/>";
    }

    $output .= "</span>";
    return $output;
  }
}


// タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

// 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
if (isset($_GET['ym'])) {
  $ym = $_GET['ym'];
} else {
  // 今月の年月を表示
  $ym = date('Y-m');
}

// タイムスタンプを作成し、フォーマットをチェックする
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
  $ym = date('Y-m');
  $timestamp = strtotime($ym . '-01');
}

// 今日の日付 フォーマット
$today = date('Y-m-j');

// カレンダーのタイトルを作成
$html_title = date('Y年n月', $timestamp);

// 前月・次月の年月を取得
// mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) - 1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) + 1, 1, date('Y', $timestamp)));


// 該当月の日数を取得
$day_count = date('t', $timestamp);

// １日が何曜日か0:日 1:月 2:火 ... 6:土
// 方法１：mktimeを使う
$youbi = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));


// カレンダー作成の準備
$weeks = [];
$week = '';

// 第１週目：空のセルを追加
// 例）１日が火曜日だった場合、日・月曜日の２つ分の空セルを追加する
$week .= str_repeat('<td></td>', $youbi);

for ($day = 1; $day <= $day_count; $day++, $youbi++) {

  // 2021-06-3
  $date = $ym . '-' . $day;

  if ($today == $date) {
    // 今日の日付の場合は、class="today"をつける
    $week .= '<td class="today">' . $day . reservation($date, $reservation_array); // 予約情報を表示
  } else {
    $week .= '<td>' . $day . reservation($date, $reservation_array); // 予約情報を表示
  }
  $week .= '</td>';


  // 週終わり、または、月終わりの場合
  if ($youbi % 7 == 6 || $day == $day_count) {

    if ($day == $day_count) {
      // 月の最終日の場合、空セルを追加
      // 例）最終日が水曜日の場合、木・金・土曜日の空セルを追加
      $week .= str_repeat('<td></td>', 6 - $youbi % 7);
    }

    // weeks配列にtrと$weekを追加する
    $weeks[] = '<tr>' . $week . '</tr>';

    // weekをリセット
    $week = '';
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>PHPカレンダー</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/styles/reset.css">
  <link rel="stylesheet" href="../assets/styles/schedule.css">
</head>

<body>
  <div class="schedule">
    <button class="current2" id="current">
      <div class="current_button"><img src="../img/calendar.jpg" class="calendar_img">
        <p class="current_text">カレンダー</p>
      </div>
    </button>
  </div>
  <div class="container">
    <h3 class="mb-5"><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
    <table class="table table-bordered">
      <tr>
        <th>日</th>
        <th>月</th>
        <th>火</th>
        <th>水</th>
        <th>木</th>
        <th>金</th>
        <th>土</th>
      </tr>
      <?php
      foreach ($weeks as $week) {
        echo $week;
      }
      ?>
    </table>
  </div>
  <div class="reservation">
    <h2 class="reservation_title">スケジュール登録</h2>
    <form action="reservation_calendar.php" method="post">
      <p class="reservation_text">お名前</p>
      <div><input type="text" name="name" placeholder="山田太郎" class="reservation_box"></div>
      <p class="reservation_text">日付</p>
      <div>
        <input type="date" name="date" min="" class="reservation_box">
      </div>
      <p class="reservation_text">帰宅時間</p>
      <div>
        <input type="time" name="time" min="" class="reservation_box">
      </div>

      <div class="submit button_container">
        <input type="submit" value="送信" class="submit_button">
      </div>
      <div class="reset button_container">
        <!-- <input  value="戻る" class="reset_button"> -->
        <a href="../index.php" class="back">戻る</a>
      </div>
    </form>
  </div>
</body>

</html>
