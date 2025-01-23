<?php

// このファイルは composer.json から読み込まれるので、requireしてはいけません。

/**
 * @author  USAMI Kenta <tadsan@zonu.me>
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WebDB96\Sample;

use Monolog\Level;
use Monolog\Logger;
use Throwable;

/** @return bool */
function is_production()
{
     return getenv('MY_PHP_ENV') === 'production';
}

/**
 * 元気にあいさつをします
 *
 * @param  \DateTimeInterface $datetime
 * @return string
 */
function get_greeting(\DateTimeInterface $datetime)
{
    $hour = (int)$datetime->format('H');
    if (5 <= $hour && $hour < 10) {
        $greeting = "おはよう";
    } elseif (10 <= $hour && $hour < 18) {
        $greeting = "こんにちは";
    } elseif (18 <= $hour && $hour < 23) {
        $greeting = "こんばんは";
    } else {
        $greeting = "おやすみなさい";
    }

    // ↓この行のコメントを外す
    // eval(\Psy\sh());
    return "{$greeting}！";
}

/**
 * 文字列をHTMLエスケープします
 */
function h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES);
}

/**
 * ロガーのインスタンスを返す
 *
 * logger()->warn
 *
 * @param  \Monolog\Logger $logger
 * @return \Monolog\Logger
 */
function logger(?\Monolog\Logger $new_logger = null)
{
    static $logger;

    if ($new_logger !== null) {
        $logger = $new_logger;
    }

    return $logger;
}

/**
 * ロガーのインスタンスを返す
 *
 * logger()->warn
 */
function chrome(): Logger
{
    static $logger;

    if ($logger === null) {
        $logger = new \Monolog\Logger('chrome');
        if (is_production()) {
            $handler = new \Monolog\Handler\NullHandler(Level::Warning);
        } else {
            $handler = new \Monolog\Handler\ChromePHPHandler(Level::Warning);
        }

        $logger->pushHandler($handler);
    }

    return $logger;
}

/**
 * 本番環境での終了時に呼ばれる関数
 */
function my_shutdown_handler(Throwable $exception): never
{
    // ここでは簡易ログのみを記録する
    logger()->error(get_class($exception), [
        'message' => $exception->getMessage(),
        'code' => $exception->getCode(),
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
    ]);

    if (PHP_SAPI !== 'cli') {
        echo '<link rel="stylesheet" href="/style/sample.css">', "\n";
        echo "<h1>Server Error</h1>\n";
        echo "<p>当たり障りのないエラーメッセージを出力します。</p>\n\n";
        echo "<hr>";
        echo sprintf("<p>現在の環境は<code>%s</code>です</p>\n", h($_ENV['MY_PHP_ENV']));
        echo '<p><code class="file">.env</code>ファイルで<code>MY_PHP_ENV=develop</code>を設定すると<em>Whoops</em>を使ったエラー表示に切り替わります。</p>';
    }
    exit(1);
}

/**
 * バックトレースとログ情報を記録する関数
 */
function my_whoops_logger_handler(Throwable $exception, $inspector, $run)
{
    $logfile = __DIR__ . '/../error.log';

    if (!file_exists($logfile)) {
        touch($logfile);
    }

    if (is_writable($logfile)) {
        $data = \Whoops\Exception\Formatter::formatExceptionAsDataArray(
            $inspector, true
        ) + [
            'time'     => (string)$_SERVER['REQUEST_TIME_FLOAT'],
            '$_SERVER' => $_SERVER,
            '$_GET'    => $_GET,
            '$_POST'   => $_POST,
            '$_COOKIE' => $_COOKIE,
        ];
        $json = json_encode($data, JSON_UNESCAPED_SLASHES);
        file_put_contents($logfile, $json . "\n", FILE_APPEND);
    }

    return null;
}

/**
 * エラーログを取得します
 *
 * @return object[]
 */
function get_error_log()
{
    $logfile = __DIR__ . '/../error.log';

    $log = [];
    foreach(file($logfile) as $line) {
        $log[] = json_decode($line, true);
    }

    return $log;
}

/**
 * これはバグを発生させる関数です
 *
 * @param  bool $raise_error
 * @return bool
 */
function bugbug($raise_error)
{
    if ($raise_error) {
        return bugbug_internal();
    }

    return false;
}

/**
 * これはバグがある関数です
 *
 * @return bool
 */
function bugbug_internal()
{
    if (mt_rand(0, 1) == 1) {
        throw new \Hoge("実在しないクラスです");
    } else {
        throw new \RuntimeException("エラーっぽいです");
    }

    return true;
}
