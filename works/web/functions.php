<?php
// データベースに接続する
function connect_db()
{
    $param = 'mysql:dbname=works;host=localhost;';
    $pdo = new PDO($param,'user','password');
    $pdo->query('SET NAMES utf8;');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
}
// 日付を日(曜日)の形式に変換する
function time_format_dw($date)
{
    $format_date = NULL;
    $week = array('日', '月', '火', '水', '木', '金', '土');

    if ($date) {
        $format_date = date('j(' . $week[date('w', strtotime($date))] . ')', strtotime($date));
    }

    return $format_date;
}


// 時間のデータ形式を調整する
function format_time($time_str)
{
    if (!$time_str || $time_str == '00:00:00') {
        return NULL;
    } else {
        return date('H:i', strtotime($time_str));
    }
}
$target_date = date("Y/m/d H:i:s") ;
?>