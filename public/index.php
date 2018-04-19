<?php

namespace WebDB96\Sample;

require_once __DIR__ . '/../inc/bootstrap.php';

if (isset($_SERVER['REQUEST_URI']) && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/index.php') {
    header('Location: /', false, 301);
    return;
}

?>
<!DOCTYPE html>
<title>WEB+DB PRESS Vol.96 PHP大規模開発入門 第17回 サンプルコード</title>
<link rel="stylesheet" href="/style/sample.css">
<h1>PHP大規模開発入門 第17回 サンプルコード</h1>
<h2>脆弱性のあるコード例</h2>
<ul>
    <li><a href="/vuln/xss.php"><abbr title="cross site scripting">XSS</abbr></a></li>
</ul>

<h2>開発環境</h2>
<ul>
    <li><a href="/greeting.php">PsySHを使ったデバッグ</a></li>
    <li><a href="/raise_error.php">エラーを発生させる</a></li>
    <li><a href="/log_viewer.php">エラーログビューア</a></li>
</ul>

<hr>
<?php if (isset($_ENV['MY_PHP_ENV'])): ?>
    <p>現在の環境は<code><?= h($_ENV['MY_PHP_ENV']) ?></code>です。</p>
<?php else: ?>
    <p><code>$_ENV['MY_PHP_ENV']</code>がセットされてません。<code class="file">.env</code>ファイルを作成してください。</p>
<?php endif; ?>
