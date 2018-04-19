<?php

namespace WebDB96\Sample;

require_once __DIR__ . '/../inc/bootstrap.php';

// ?raise_error=1 のときエラーが発生します
bugbug(isset($_GET['raise_error']) && $_GET['raise_error']);

?>
<!DOCTYPE html>
<title>WEB+DB PRESS Vol.96 PHP大規模開発入門 第17回 サンプルコード</title>
<link rel="stylesheet" href="/style/sample.css">
<h1>PHP大規模開発入門 第17回 サンプルコード</h1>

<p><a href="?raise_error=1">エラーを発生させてみる</a></p>

<hr>
<?php if (isset($_ENV['MY_PHP_ENV'])): ?>
    <p>現在の環境は<code><?= h($_ENV['MY_PHP_ENV']) ?></code>です。</p>
<?php endif; ?>
