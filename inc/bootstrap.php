<?php

namespace WebDB96\Sample;

$loader = require __DIR__ . '/../vendor/autoload.php';

ini_set('date.timezone', 'asia/tokyo');


if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    // 必須設定項目が記述されているか
    $dotenv->required(['MY_PHP_ENV']);
}


if (is_production()) {
    // 全てのエラー報告をオフにする
    error_reporting(0);
    // エラー情報が画面に出力されないようにする
    ini_set('display_errors', '0');

    $whoops_handler = new \Whoops\Handler\CallbackHandler('\WebDB96\Sample\my_shutdown_handler');
} else {
    // 全てのエラー出力を有効にする
    error_reporting(E_ALL);
    // 未定義変数などが多い場合はE_NOTICEを警告しないように設定
    // error_reporting(E_ALL & ~E_NOTICE);

    // コマンドラインから実行されたときはテキスト形式で出力
    $whoops_handler = new \Whoops\Handler\PrettyPageHandler;
}

if (PHP_SAPI === 'cli') {
    $whoops_handler = new \Whoops\Handler\PlainTextHandler;
}

// 1. Whoopsの情報を使ってバックトレースをログファイルに保存
// 2. 環境に合ったエラー表示

$whoops = new \Whoops\Run;
$whoops->pushHandler($whoops_handler);
$whoops->pushHandler('\WebDB96\Sample\my_whoops_logger_handler');
$whoops->register();

$monolog_handlers = [];
if (is_production()) {
    ini_set("log_errors", "1");
    $monolog_handlers[] = new \Monolog\Handler\ErrorLogHandler(0, \Monolog\Logger::WARNING);
} else {
    $log_file = __DIR__ . "/../{$_ENV['MY_PHP_ENV']}.log";
    $monolog_handlers[] = new \Monolog\Handler\StreamHandler($log_file);
}
$monolog = new \Monolog\Logger('webdb', $monolog_handlers);
logger($monolog);
